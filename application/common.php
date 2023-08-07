<?php

use Firebase\JWT\JWT;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use think\facade\Env;
use think\facade\Log;
use app\common\model\HolidayContrast;
use GuzzleHttp\Client;

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

if (!function_exists('password')) {

	/**
	 * 密码加密算法
	 * @param $value 需要加密的值
	 * @param $type  加密类型，默认为md5 （md5, hash）
	 * @return mixed
	 */
	function password($value)
	{
		$value = sha1('dyjs_') . md5($value) . md5('_encrypt') . sha1($value);
		return sha1($value);
	}

}

function gen_dates_by_range($start, $end)
{
    $dt_start = strtotime($start);
    $dt_end = strtotime($end);
    $res = [];
    while ($dt_start <= $dt_end) {
        $res[] = date('Y-m-d', $dt_start);
        $dt_start = strtotime('+1 day', $dt_start);
    }
    return $res;
}

/**
 * 1. 排除周六周日
 * 2. 排除节日
 * @param $dates
 * @return array
 */
function exclude_weekend($dates)
{
    $res = [];
    if (count($dates)) {
        foreach ($dates as $date) { // 排除掉周末
            if (!is_weekend($date) && !is_holiday(date('Y-n-j', strtotime($date)))) {
//            if (!is_weekend($date)) {
                $res[] = $date;
            }
        }


    }
    return $res;
}

/**
 * 获取指定日期是周几
 * @param $date
 * @return string
 */
function get_weekday_by_date($date)
{
    $weekday_map = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];
    $weekday = date('w', strtotime($date));
    return $weekday_map[$weekday];
}

/**
 * 判断传入的日期是否为周六周日
 * @param $date
 * @return bool
 */
function is_weekend($date)
{
    return (date('w', strtotime($date)) == 6) || (date('w', strtotime($date)) == 0);
}

/**
 * 判断节日
 * @param $date
 * @return bool
 */
function is_holiday($date)
{
    $m_holiday_contrast = new HolidayContrast();

    $d_holiday_contrast = $m_holiday_contrast->where(['date' => $date])->find();

    if ($d_holiday_contrast) {
        if ($d_holiday_contrast['is_holiday'] == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        $url = config('juhe.calendar.api');
        $app_key = config('juhe.calendar.app_key');

        $res = curl_get($url . '?date=' . $date . '&key=' . $app_key);
        $res = json_decode($res);
        c_log(json_encode($res), 'juhe_calender');

        if ($res->error_code == 0) { // 请求成功

            if ($res->result && $res->result->data && $res->result->data->holiday) {
                // 请求结果入库
                $i_data = [
                    'date' => $date,
                    'is_holiday' => 1,
                    'holiday'=> $res->result->data->holiday,
                    'desc'=> $res->result->data->desc,
                    'weekday'=> $res->result->data->weekday,
                ];
                $m_holiday_contrast->save($i_data);
                return true;
            }
            $i_data = [
                'date' => $date,
                'is_holiday' => 0,
                'holiday'=> '',
                'desc'=> '',
                'weekday'=> '',
            ];
            $m_holiday_contrast->save($i_data);

        }
        return false;
    }

}


/**
 * @param $root_path
 * @return array
 * @throws \PhpOffice\PhpSpreadsheet\Exception
 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
 */
function read_sheet_content($root_path)
{

    $inputFileType = IOFactory::identify($root_path); //传入Excel路径

    $excelReader = IOFactory::createReader($inputFileType); //Xlsx

    $PHPExcel = $excelReader->load($root_path); // 载入excel文件

    $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表

    return $sheet->toArray();
}

function gen_jwt_token($param = [])
{
    $time = time();
    $en_data = [
        'iat' => $time,
        'exp' => $time + config('jwt.expire_time'),
        'data' => $param
    ];
    return JWT::encode($en_data, config('jwt.jwt_key'));
}

function check_ali_callback($data)
{
    require '../extend/alipay/wappay/service/AlipayTradeService.php';
    $config = config('alipay.config');
    $alipayService = new \AlipayTradeService($config);

    return $alipayService->check($data);
}

function call_alipay($body, $total_amount, $order_number, $notify_url)
{
    require '../extend/alipay/aop/AopClient.php';
    require_once "../extend/alipay/aop/request/AlipayTradeAppPayRequest.php";

    $aop = new \AopClient();

    $config = config('alipay.config');

    $aop->gatewayUrl = $config['gatewayUrl'];
    $aop->appId = $config['app_id'];
    $aop->rsaPrivateKey = $config['merchant_private_key'];
    $aop->format = 'json';
    $aop->postCharset = $config['charset'];
    $aop->signType = $config['sign_type'];
    $aop->alipayrsaPublicKey = $config['alipay_public_key'];

    $request = new \AlipayTradeAppPayRequest();
    $arr['body'] = $body;
    $arr['subject'] = $body;
    $arr['out_trade_no'] = $order_number;
    $arr['timeout_express'] = '30m';
    $arr['total_amount'] = floatval($total_amount);
    $arr['product_code'] = 'QUICK_MSECURITY_PAY';

    $json = json_encode($arr);
    $request->setNotifyUrl($notify_url);
    $request->setBizContent($json);
    $response = $aop->sdkExecute($request);
    return htmlspecialchars($response);
}

/**
 * 生成邀请码
 * user_id转62进制, 不足六位前面补零
 * @param int $base
 * @return string
 */
function gen_invite_code(int $base)
{
    $base += 1000000000; // 从10亿开始, 62进制为6位
    return from10_to62($base);
}

/**
 * 邀请码转user_id
 * @param $code
 * @return int|string
 */
function invite_code_to_user_id($code)
{
    return from62_to10($code) - 1000000000;
}

/**
 * 十进制数转换成62进制
 *
 * @param $num
 * @return string
 */
function from10_to62($num)
{
    $to = 62;
    $dict = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $ret = '';
    do {
        $ret = $dict[bcmod($num, $to)] . $ret;
        $num = bcdiv($num, $to);
    } while ($num > 0);
    return $ret;
}

/**
 * 62进制数转换成十进制数
 *
 * @param  $num
 * @return string
 */
function from62_to10($num)
{
    $from = 62;
    $num = strval($num);
    $dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $len = strlen($num);
    $dec = 0;
    for ($i = 0; $i < $len; $i++) {
        $pos = strpos($dict, $num[$i]);
        $dec = bcadd(bcmul(bcpow($from, $len - $i - 1), $pos), $dec);
    }
    return $dec;
}

//生成唯一订单号
function build_order_no()
{
    return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

function c_log($content, $dir = 'common')
{
    $path = Env::get('root_path') . '/runtime/log/debug/' . $dir . '/' . date('Y') . '/' . date('m') . '/';
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
    file_put_contents($path . date('Y-m-d') . '.log', $content . PHP_EOL, FILE_APPEND);
}

function random_nickname($length = 6)
{
    $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ1234567890";
    $validCharNumber = strlen($validCharacters);
    $result = "";
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
    return '用户_' . $result;
}


function listToTree($list, $pk = 'id', $pid = 'parent_id', $child = 'children', $root = 0)
{
    if (!is_array($list)) {
        return [];
    }

    // 创建基于主键的数组引用
    $aRefer = [];
    foreach ($list as $key => $data) {
        $aRefer[$data[$pk]] = &$list[$key];
    }

    $tree = [];
    foreach ($list as $key => $data) {
        // 判断是否存在parent
        $parentId = $data[$pid];
        if ($root === $parentId) {

            $tree[] = &$list[$key];

        } else {
            if (isset($aRefer[$parentId])) {
                $parent = &$aRefer[$parentId];
                $parent[$child][] = &$list[$key];
            }
        }
    }

    return $tree;
}

function encode_password($str)
{
    return md5('gfp' . md5($str));
}

/**
 * 支付密码, 登录密码
 * @param $str
 * @param $password
 * @return bool
 */
function check_password($str, $password)
{
    return encode_password($str) === $password;
}

function curl_get($url)
{

    $info = curl_init();
    curl_setopt($info, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($info, CURLOPT_HEADER, 0);
    curl_setopt($info, CURLOPT_NOBODY, 0);
    curl_setopt($info, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($info, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($info, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($info, CURLOPT_URL, $url);
    $output = curl_exec($info);
    curl_close($info);
    return $output;
}

if (!function_exists('curl')) {
    /**
     * curl提交
     * @param $type integer 1 get 2 post
     * @param $url  string  访问的地址
     * @param $param  array 请求的数据
     * @param int $is_ignore
     * @return mixed|string    返回的数据
     */
    function curl(int $type, string $url, $param = [], $is_ignore = 0)
    {
        $_param = '';
        if (array_key_exists('sig', $param))
            $param['sig'] = urlencode($param['sig']);
        if ($type == 1) {
            foreach ($param as $key => $item) {
                $_param .= $key . "=" . $item . "&";
            }
            $url .= "?" . rtrim($_param, '&');
        } else {
            $_param = json_encode($param);
        }
        //初始化
        $curl = curl_init();
        if ($is_ignore) {
            ignore_user_abort();
        }
//        //设置header
//        $headers = ["Content-type: application/json;charset='utf-8'"];
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if ($type == 2) {
            //设置post方式提交
            curl_setopt($curl, CURLOPT_POST, 1);
            //设置post数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, $_param);
        }
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        return json_decode($data, true);
    }

}