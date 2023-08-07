<?php


namespace app\admin\controller;

use app\common\model\User as MUser;
use think\facade\Log;
use think\facade\Request;

class User extends Basic
{

    /**
     * 管理员列表
     * @param Request $request
     * @return \think\response\Json
     */
    public function list(Request $request, MUser $user)
    {
        try {
            $param = $request::post();
            $page = $param['page'];
            $limit = $param['limit'];

            $condition[] = ['1', '=', '1'];

            if (!empty($param['username'])) $condition[] = ['username', 'like', '%' . $param['username'] . '%'];


            $total = count($user->where($condition)->field('1')->select());
            $data = $user // 模型关联
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
     * @return \think\response\Json
     */
    public function create(Request $request, MUser $user)
    {
        if ($request::isPost()) {
            try {
                $code = 0;
                $message = '操作成功';

                $param = $request::post();
				if ($param['password'] === $param['repassword']) {
					$param['password'] = password($param['password']);
					$user->allowField(true)->save($param);
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
     * @return array
     */
    public function remove(Request $request, MUser $user)
    {
        if ($request::isPost()) {
            try {
                $ids = $request::post('ids');
                if (is_array($ids) && count($ids) > 0) {
					$user::destroy($request::post('ids'));
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
	 * @param MUser $user
	 * @return array
	 */
    public function info(Request $request, MUser $user)
    {
        try {
            $user_id = $request::get('user_id');
            $data = $user
                ->where(['id' => $user_id])
                ->find();
            return ['code' => 0, 'message' => 'ok', 'data'=> $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

    /**
     * 更新管理员信息
     * @param Request $request
     * @return array|\think\response\Json
     */
    public function update(Request $request, MUser $user)
    {
        if ($request::isPost()) {
            try {
                $code = 0;
                $message = '操作成功';

                $user_id = $request::post('user_id');
                $param = $request::post('user_info');
				if ($param['password'] === $param['repassword']) {
					if ($param['password']) {
						$param['password'] = password($param['password']);
					}else {
						unset($param['password']);
					}

					$user->allowField(true)->save($param, ['id'=> $user_id]);
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