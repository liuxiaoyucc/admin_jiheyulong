<?php


namespace app\api\controller\v1;



use think\Controller;
use think\Request;

class Index extends Controller
{
    /**
     * 首页信息
     * banner + 赛事分类
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        return 'index';
    }


    /**
     * 将字符串转换成二进制
     * @param $str
     * @return string
     * php 中显示的字符串是多少进制的？？
     * 例如：$str = '你好'; // 这边的 '你好' 是什么进制数据（我知道他是字符串！）??
     */
    public function str2bin($str)
    {
        //1.列出每个字符
        // 这边的分割正则也不理解
        // (?<!^) 后瞻消极断言
        // (?!$) 前瞻消极断言
        // 看意思好像说的是：不以^开头（但是这边 ^ 又没有被转义...），不以 $ 结尾（同上）
        // 然后得到的记过就是字符串一个个被分割成了数组（郁闷）
        // 求解释
        $arr = preg_split('/(?<!^)(?!$)/u', $str);
        //2.unpack字符
        foreach ($arr as &$v) {
            /**
             * unpack：将二进制字符串解包(英语原文：Unpack data from binary string)
             * H: 英语描述原文：Hex string, high nibble first
             * 这段代码做了什么？？
             */
            $temp = unpack('H*', $v); // 这边被解析出来的字符串为什么是 16进制的？？
            $v = base_convert($temp[1], 16, 2);
            unset($temp);
        }

        return join(' ', $arr);
    }

    public function auto_k_i_import()
    {
        return ;
        try {
            $m_ingredient = new \app\common\model\Ingredient();
            $m_ingredient_kindergarten = new KindergartenIngredient();
            $d_ingredients = $m_ingredient->all();

            $i_data = [];

            foreach ($d_ingredients as $d_ingredient) {
                $i_data[] = [
                    'kindergarten_id'=> 3,
                    'ingredient_id'=> $d_ingredient['id'],
                ];
            }
            $m_ingredient_kindergarten->saveAll($i_data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function test()
    {
        try {
            return 1;
            return is_holiday('2021-9-28');
            $a = [
                'z'=> [
                    'x'=> [3,4,5,6],
                    1,2,3,4]
            ];
            $b = &$a['z'];
            $b = json_decode(json_encode($b), true);
            $c = &$b['x'];
            unset($c[1]);
            unset($b[1]);
            print_r($a);

            return;
            print_r($b);
            print_r($c);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}