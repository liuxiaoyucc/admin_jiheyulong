<?php


namespace app\admin\controller;

use app\admin\model\Manager;
use app\admin\model\Role;
use think\facade\Log;
use think\facade\Request;

class Manage extends Basic
{

    /**
     * 管理员列表
     * @param Request $request
     * @param Manager $manager
     * @return \think\response\Json
     */
    public function list(Request $request, Manager $manager)
    {
        try {
            $param = $request::post();
            $page = $param['page'];
            $limit = $param['limit'];

            $condition[] = ['1', '=', '1'];

            if (!empty($param['username'])) $condition[] = ['username', 'like', '%' . $param['username'] . '%'];
            if (!empty($param['tel'])) $condition[] = ['tel', 'like', '%' . $param['tel'] . '%'];


            $total = count($manager->where($condition)->field('1')->select());
            $data = $manager // 模型关联
                ->where($condition)
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }

    /**
     * 新增管理员
     * @param Request $request
     * @param Manager $manager
     * @return \think\response\Json
     */
    public function create(Request $request, Manager $manager)
    {
        if ($request::isPost()) {
            try {
                $code = 0;
                $message = '操作成功';

                $param = $request::post();
				if ($param['password'] === $param['repassword']) {
					$param['password'] = md5($param['password']);
					$manager->allowField(true)->save($param);
				}else {
					$code = -1;
					$message = '两次密码不一致';
				}
                return json(['code' => $code, 'message'=> $message]);
            }catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * 删除管理员
     * @param Request $request
     * @param Manager $manager
     * @return array
     */
    public function remove(Request $request, Manager $manager)
    {
        if ($request::isPost()) {
            try {
                $ids = $request::post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $manager::destroy($request::post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];

            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    /**
     * 获取管理员信息
     * @param Request $request
     * @param Manager $manager
     * @return array
     */
    public function info(Request $request, Manager $manager)
    {
        try {
            $manager_id = $request::get('manager_id');
            $data = $manager
                ->where(['id' => $manager_id])
                ->field('id,username,tel,sex')
                ->find();
            return ['code' => 0, 'message' => 'ok', 'data'=> $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

    /**
     * 更新管理员信息
     * @param Request $request
     * @param Manager $manager
     * @return array|\think\response\Json
     */
    public function update(Request $request, Manager $manager)
    {
        if ($request::isPost()) {
            try {
                $code = 0;
                $message = '操作成功';

                $manager_id = $request::post('manager_id');
                $param = $request::post('manager_info');
                $res = $this->validate($param, 'app\admin\validate\Permission.manager_update');
				if ($param['password'] === $param['repassword']) {
					if ($param['password']) {
						$param['password'] = md5($param['password']);
					}else {
						unset($param['password']);
					}

					$manager->allowField(true)->save($param, ['id'=> $manager_id]);
				}else {
					$code = -1;
					$message = '两次密码不一致';
				}

                return json(['code' => $code, 'message'=> $message]);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

}