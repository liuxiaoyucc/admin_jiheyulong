<?php
declare(strict_types=1);

namespace app\common\service;

use app\common\model\Compete;
use app\common\model\CompeteApply;
use app\common\model\Notify;
use app\common\model\User;
use app\common\model\UserTicket;
use app\common\model\VipRecord;

/**
 * 计划任务
 * Class PlanTask
 * @package app\common\service
 */
class PlanTask
{
    private $msg = null;
    private $res_msg = '';
    private $file_name = '';

    public function __construct($msg, $file_name = '', $preMsg = '')
    {
        $this->file_name = $file_name;
        $this->res_msg = $preMsg;
        $this->res_msg .= str_repeat('-', 25) . date('Y-m-d H:i:s') . "[" .
            (microtime(true) - time()) . "]" . str_repeat('-', 25) . PHP_EOL;
        if (array_key_exists('id', $msg) && $msg['id']) {
            $idMsg = is_array($msg['id']) ? implode(',', $msg['id']) : $msg['id'];
            $this->res_msg .= 'id：' . $idMsg . PHP_EOL;
        }
        $this->res_msg .= 'state：msg actioned' . PHP_EOL;
        $this->msg = $msg;
    }


    public function vip_expire()
    {
        c_log("vip_expire, 开始执行", 'beanstalk_compete');
        try {
            $param = $this->msg;
            $m_vip_record = new VipRecord();
            $m_user = new User();
            $m_notify = new Notify();

            $vip_record_id = $param['vip_record_id'];
            $user_id = $param['user_id'];

            $m_vip_record->where(['id'=> $vip_record_id])->update(['status'=> 2, 'day'=> 0]);
            $m_user->where(['id'=> $user_id])->update(['is_vip'=> 0, 'is_old_vip'=> 1]);

            // 写入通知
            $m_notify->publish($user_id, 'VIP到期提醒', '您购买的VIP已到期');

        } catch (\Exception $e) {
            c_log("报名处理异常\t" . $e->getMessage(), 'beanstalk_compete');
        }
    }


    public function ticket_expire()
    {
        c_log("ticket_expire, 开始执行", 'beanstalk_compete');
        try {
            $param = $this->msg;
            $m_user_ticket = new UserTicket();
            $m_user = new User();
            $m_notify = new Notify();

            $user_ticket_id = $param['user_ticket_id'];
            $user_id = $param['user_id'];

            $m_user_ticket->where(['id'=> $user_ticket_id])->update(['status'=> 3]);


            // 写入通知
            $m_notify->publish($user_id, '门票到期提醒', '您有一张门票已到期, 请到我的门票中查看');

        } catch (\Exception $e) {
            c_log("报名处理异常\t" . $e->getMessage(), 'beanstalk_compete');
        }
    }


    /**
     * 切换到报名阶段, 并准备更改到下一阶段(赛前准备)
     */
    public function compete_apply()
    {
        c_log("compete_apply, 开始执行", 'beanstalk_compete');

        try {
            $param = $this->msg;
            $compete_id = $param['compete_id'];
            $phase = 1;
            $this->change_phase($compete_id, $phase);

            /*
             * 更改到准备阶段
             */
            $beanstalk = new Beanstalk();
            $param['queue'] = 'compete_prepare';
            $param['time'] = date('Y-m-d H:i:s');
            $cur_time = time();
            $delay = $param['prepare_time'] - $cur_time;
            $beanstalk->put(json_encode($param), $delay);
            return true;

        } catch (\Exception $e) {
            c_log("报名处理异常\t" . $e->getMessage(), 'beanstalk_compete');
        }




    }

    /**
     * 切换到赛前准备阶段或流局状态
     */
    public function compete_prepare()
    {
        $m_compete = new Compete();
        $m_compete_apply = new CompeteApply();

        $param = $this->msg;
        $compete_id = $param['compete_id'];

        $d_compete = $m_compete->get($compete_id);
        $d_apply_users = $m_compete_apply
            ->where([
                'compete_id' => $compete_id,
                'status' => 1
            ])->select();

        $apply_number = count($d_apply_users);
        $apply_minimum = $d_compete['apply_minimum']; // 赛事开始最小需达到人数

        $phase = 2;
        if ($apply_number < $apply_minimum) {
            // 报名人数未达标逻辑
            $phase = 5; // 流局
        }

        $this->change_phase($compete_id, $phase);


        /*
         * 更改到开始阶段, phase为5时流局, 状态不再改变
         */
        $beanstalk = new Beanstalk();

        if ($phase === 2) {
            $param['queue'] = 'compete_start';
            $param['time'] = date('Y-m-d H:i:s');
            $cur_time = time();
            $delay = $param['start_time'] - $cur_time;
            $beanstalk->put(json_encode($param), $delay);
        }
        if ($phase === 5) {
            $beanstalk->put(json_encode([
                'queue'=> 'compete_withdraw',
                'compete_id'=> $compete_id,
                'time'=> date('Y-m-d H:i:s'),
            ]), 30);
        }


        return true;
    }

    /**
     * 赛事开始
     */
    public function compete_start()
    {
        $param = $this->msg;
        $compete_id = $param['compete_id'];
        $phase = 3;
        $this->change_phase($compete_id, $phase);

        return true;
    }

    /**
     * 赛事结束
     */
    public function compete_end()
    {

    }


    private function change_phase($compete_id, $phase)
    {
        c_log("赛事ID\t" . $compete_id . "\t即将更改到\t" . $phase . "\t阶段", 'beanstalk_compete');
        $m_compete = new Compete();

        $u_data = [
            'phase' => $phase
        ];
        if ($phase === 5) { // 流局自动写入结束时间
            $u_data['end_time'] = time();
        }
        $m_compete->where([
            'id' => $compete_id
        ])->update($u_data);

        c_log("赛事ID\t" . $compete_id . "\t更改到\t" . $phase . "\t阶段", 'beanstalk_compete');
    }

    /**
     * 流局逻辑处理
     * @throws \Exception
     */
    public function compete_withdraw()
    {
        c_log("compete_withdraw", 'beanstalk_compete');

        // 找出所有报名用户, 进行退票处理
        $m_compete_apply = new CompeteApply();
        $m_user_ticket = new UserTicket();
        $m_notify = new Notify();

        $param = $this->msg;
        $compete_id = $param['compete_id'];
        c_log("compete_withdraw\t" . "compete_id: \t" . $compete_id, 'beanstalk_compete');

        $apply_records = $m_compete_apply
            ->where([
                'compete_id'=> $compete_id,
                'status'=> 1,
            ])
            ->select();
        c_log("compete_withdraw\t" . json_encode($apply_records), 'beanstalk_compete');

        if (count($apply_records) > 0) {
            $u_data = [];
            foreach ($apply_records as $record) {
                $u_data[] = ['id'=> $record['user_ticket_id'], 'status'=> 1];
            }
            c_log("compete_withdraw\t" . json_encode($u_data), 'beanstalk_compete');

            $m_user_ticket->saveAll($u_data);
            $m_notify->compete_cancel($compete_id);
        }

        return true;
    }

    public function __destruct()
    {
        if ($this->file_name) {
            file_put_contents($this->file_name, $this->res_msg, FILE_APPEND);
        }
    }

}