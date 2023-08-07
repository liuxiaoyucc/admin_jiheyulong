<?php

namespace app\index\controller;

use app\common\model\Banner;
use app\common\model\Config;
use app\common\model\CooperationCase;
use app\common\model\CooperationCaseCategory;
use app\common\model\DevNode;
use app\common\model\FriendlyLink;
use app\common\model\Knowledge;
use app\common\model\KnowledgeCategory;
use app\common\model\Lawyer;
use app\common\model\LawyerCategory;
use app\common\model\Major;
use app\common\model\Message;
use app\common\model\Navigation;
use app\common\model\Specialist;
use app\common\model\NewsCategory;

use app\common\model\User;
use think\Controller;

use think\Db;
use think\Request;

class Pc extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	public function search()
	{
		try {
			$m_specialist = new Specialist();
			$m_major = new Major();
			$m_config = new Config();

			$param = $this->request->post();
			$number = $param['number'];
			$major_id = $param['major_id'];

			$where = [];
			if ($major_id) { // 组装find_in_set
				$major_ids = explode(',', $major_id);

				$prefix = '(';
				$part_sql = '';
				$suffix = ')';

				foreach ($major_ids as $major) {
					if ($part_sql) {
						$part_sql .= ' or ';
					}
					$part_sql .= "FIND_IN_SET($major, major_ids)";
				}
				$part_sql = $prefix . $part_sql . $suffix;
				$where[] = ['', 'exp', Db::raw($part_sql)];
			}

			$is_cheat = $m_config->where(['key'=> 'is_cheat'])->find()['value'];

			if ($is_cheat) {
				$where[] = ['is_certainly', '=', 1];
			}

			$data = $m_specialist->where($where)->append(['majors'])->select();

			if (!$data->isEmpty()) {
				$data = $data->toArray();
				shuffle($data);
				$data = array_slice($data, 0, $number);
			}

			return [
				'code'=> 0,
				'data'=> $data,
				'msg'=> '请求成功',
			];
		} catch (\Exception $exception) {
			return $exception->getMessage();
		}
	}

	/**
	 * 首页呈现
	 * @return mixed
	 */
	public function index()
	{

		try {
			return $this->fetch('');
		} catch (\Exception $exception) {
			return $exception->getMessage();
		}

	}

	/**
	 * 注册
	 */
	public function reg()
	{
		try {
			if ($this->request->isPost()) {
				// 检查登录参数, 登录成功, session保存登录态, 返回code, 由前端跳转至首页
				$param = $this->request->post();

				$m_user = new User();

				$username = $param['username'];
				$company_name = $param['company_name'];
				$password = password($param['password']);

				$d_user = $m_user->where([
					'username' => $username,
					'status' => 1
				])->find();

				if ($d_user) {
					return [
						'code' => -1,
						'msg' => '用户名已存在'
					];
				}

				$m_user->save([
					'company_name'=> $company_name,
					'username' => $username,
					'password' => $password,
				]);

				return [
					'code' => 0,
					'msg' => '注册成功, 等待审核'
				];
			}

			return $this->fetch();
		} catch (\Exception $exception) {
			return '加载中...';
		}
	}

	/**
	 * 登录页加载
	 */
	public function login()
	{

		try {
			if ($this->request->isPost()) {
				// 检查登录参数, 登录成功, session保存登录态, 返回code, 由前端跳转至首页
				$param = $this->request->post();


				$m_user = new User();

				$username = $param['username'];
				$password = password($param['password']);
				$captcha = $param['captcha'];

				if (!captcha_check($captcha)) {
					return [
						'code'=> -1,
						'msg'=> '验证码错误'
					];
				};

				$d_user = $m_user->where([
					'username' => $username,
					'password' => $password,
					'status' => 1,
				])->field(['company_name', 'username', 'password', 'status'])->find();

				if (!$d_user) {
					return [
						'code' => -2,
						'msg' => '账户不存在'
					];
				}

				unset($d_user['password']);
				cookie('user', $d_user);

				return [
					'code' => 0,
					'msg' => '登录成功'
				];


			}

			return $this->fetch();
		} catch (\Exception $exception) {
			return '加载中...';
		}
	}


}
