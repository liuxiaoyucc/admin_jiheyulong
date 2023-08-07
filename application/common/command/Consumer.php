<?php
declare(strict_types=1);

namespace app\common\command;

use app\common\service\Beanstalk;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Env;

class Consumer extends Command
{
    /* 消费者数量 */
    private $count = 2;
    // 都是延迟队列
    private $queue_name_list = [
        'receive_test' //test
    ];

    private $dir_base;
    private $log_file;
    private $msg = '';

    /**
     * 命令配置
     */
    protected function configure()
    {
        $this->setName('beanstalk')
            ->setDescription('receive beanstalk message is_sidebarand operate');
    }

    /**
     * 执行命令体
     * @param Input $input
     * @param Output $output
     * @return mixed
     */
    protected function execute(Input $input, Output $output)
    {
        $this->dir_base = Env::get('root_path') . 'public/msg/';
        if (!is_dir($this->dir_base . 'exec')) {
            mkdir($this->dir_base . 'exec', 0755, true);
        }
        $this->log_file = $this->dir_base . 'exec/' . date('Y-m-d') . '.log';
        $this->msg = str_repeat('-', 25) . date('Y-m-d H:i:s') . "[" .
            (microtime(true) - time()) . "]" . str_repeat('-', 25) . PHP_EOL;
        try {
            (new Beanstalk())->receive();
        } catch (\Exception $e) {
            $this->msg .= 'file：' . $e->getFile() . PHP_EOL .
                'line：' . $e->getLine() . PHP_EOL .
                'msg：' . $e->getMessage() . PHP_EOL;
            // 记录日志
            file_put_contents($this->log_file, $this->msg, FILE_APPEND);
        }
    }


}