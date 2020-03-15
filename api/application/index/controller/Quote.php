<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Validate;
use think\Db;
use app\index\model\QuoteModel;
//报价控制器
class Quote extends Controller {
    public function index() {
        return view();
    }
    public function InsertQ() {
        //因不确定前端人员传的数值，只能采取 for 循环补充机制
        for ($i = 0;$i < 12;$i++) {
            $Month[$i] = $i + 1;
            for ($y = 0;$y <= 31;$y++) {
                $Day[$i + 1][$y] = null;
            }
        }
        dump($Month);
        // dump($Day);
        // exit;
        // $request = Request::instance();
        // $data = $request->post();   //全部数据
        $data['Year'] = "2016"; //年
        $data['Month'][0] = "11"; //月    一维数组
        $data['Month'][1] = "12";
        $data['Day'][11][0] = "2"; //日    二维数组   月 + 下标
        $data['Day'][12][0] = "2";
        $data['Money'][11][2] = "222"; //钱    二维数组   月 + 日
        $data['Money'][12][2] = "222";
        $data['Type'] = "1"; //类型
        dump($data);
        //验证
        // 查询年份
        //判断类型
        // 缺少公司id
        for ($i = 0;$i < count($data['Month']);$i++) {
            $x = $data['Month'][$i];
            for ($y = 0;$y < count($data['Day'][$x]);$y++) {
                $h = $data['Day'][$x][$y];
                $Day[$x][$h] = $data['Money'][$x][$h];
            }
        }
        if ($data['Year'] % 4 == 0 && $data['Year'] % 100 != 0 || $data['Year'] % 400 == 0) {
            $run = 29; //闰年
            
        } else {
            $run = 28; //平年
            
        }
        $list = array();
        for ($i = 0;$i < count($Month);$i++) {
            for ($y = 0;$y < count($data['Month']);$y++) {
                if ($Month[$i] == $data['Month'][$y]) {
                    if ($Month[$i] > 7) {
                        if ($Month[$i] % 2 == 0) {
                            $yue = NUll;
                            for ($y = 1;$y <= 31;$y++) {
                                $dayue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                $yue = $dayue;
                            }
                            $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $dayue, 'Type' => $data['Type']];
                        } else {
                            $yue = NUll;
                            for ($y = 1;$y <= 30;$y++) {
                                $xiaoyue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                $yue = $xiaoyue;
                            }
                            $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $xiaoyue, 'Type' => $data['Type']];
                        }
                    } else {
                        if ($Month[$i] % 2 != 0) {
                            $yue = NUll;
                            for ($y = 1;$y <= 31;$y++) {
                                $dayue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                $yue = $dayue;
                            }
                            $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $dayue, 'Type' => $data['Type']];
                        } else {
                            $yue = NUll;
                            if ($Month[$i] == 2) {
                                for ($y = 1;$y <= $run;$y++) {
                                    $xiaoyue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                    $yue = $xiaoyue;
                                }
                                $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $xiaoyue, 'Type' => $data['Type']];
                            } else {
                                for ($y = 1;$y <= 30;$y++) {
                                    $xiaoyue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                    $yue = $xiaoyue;
                                }
                                $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $xiaoyue, 'Type' => $data['Type']];
                            }
                        }
                    }
                } else {
                    if ($Month[$i] > 7) {
                        if ($Month[$i] % 2 == 0) {
                            $yue = NUll;
                            for ($y = 1;$y <= 31;$y++) {
                                $dayue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                $yue = $dayue;
                            }
                            $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $dayue, 'Type' => $data['Type']];
                        } else {
                            $yue = NUll;
                            for ($y = 1;$y <= 30;$y++) {
                                $xiaoyue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                $yue = $xiaoyue;
                            }
                            $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $xiaoyue, 'Type' => $data['Type']];
                        }
                    } else {
                        if ($Month[$i] % 2 != 0) {
                            $yue = NUll;
                            for ($y = 1;$y <= 31;$y++) {
                                $dayue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                $yue = $dayue;
                            }
                            $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $dayue, 'Type' => $data['Type']];
                        } else {
                            $yue = NUll;
                            if ($Month[$i] == 2) {
                                for ($y = 1;$y <= $run;$y++) {
                                    $xiaoyue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                    $yue = $xiaoyue;
                                }
                                $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $xiaoyue, 'Type' => $data['Type']];
                            } else {
                                for ($y = 1;$y <= 30;$y++) {
                                    $xiaoyue = $yue . '|"' . $y . '"="' . $Day[$Month[$i]][$y] . '"';
                                    $yue = $xiaoyue;
                                }
                                $list[$i] = ['Year' => $data['Year'], 'Month' => $Month[$i], 'Day' => $xiaoyue, 'Type' => $data['Type']];
                            }
                        }
                    }
                }
            }
        }
        // dump($list);
        $model = new QuoteModel;
        $code = $model->saveAll($list, false);
        // echo $model->getLastSql();
        
    }
    public function DelectQ() {
        // dump($Day);
        // $request = Request::instance();
        // $data = $request->post();   //全部数据
        //获取前端数据 ， 年 月 日 类型， 现为日历类型 公司id
        // 删除格式为，清空对应的钱  必有数据 token 年 类型
        // 清空对应日， 需数据 年 月 日
        // 清空对应的月， 需数据 年 月
        // 清空 对应的年， 需要数据 年
        $data['Year'] = "2016"; //年
        $data['Month'][0] = "11"; //月    一维数组
        $data['Month'][1] = "12";
        // $data['Day'][2][0] = "2";          //日    二维数组   月 + 下标
        // $data['Day'][1][0] = "2";
        // $data['Month'] = null;
        $data['Day'] = null;
        $model = new QuoteModel;
        $list = $model->where('Year', $data['Year'])->where('Month', '<', 13)->field('Day')->select();
        if ($data['Day'] == NUll) {
            if ($data['Month'] == NUll) {
                for ($i = 0;$i < 12;$i++) {
                    $Month[$i] = $i + 1;
                }
                for ($y = 0;$y < count($Month);$y++) {
                    $leng = substr_count($list[$y]['Day'], '|');
                    for ($i = 1;$i <= $leng;$i++) {
                        for ($c = 1, $n = 0;$c <= $i * 4 - 1;$c++, $n++) {
                            $n = strpos($list[$y]['Day'], '"', $n);
                        }
                        $head = $n;
                        for ($c = 1, $n = 0;$c <= $i * 4;$c++, $n++) {
                            $n = strpos($list[$y]['Day'], '"', $n);
                        }
                        $x = $n - 1 - $head;
                        $list[$y]['Day'] = substr_replace($list[$y]['Day'], "", $head, $x);
                    }
                    $code = $model->where('Year', $data['Year'])->where('Month', '=', $Month[$y])->update(['Day' => $list[$y]['Day']]);
                }
            } else {
                for ($y = 0;$y < count($data['Month']);$y++) {
                    $leng = substr_count($list[$data['Month'][$y] - 1]['Day'], '|');
                    for ($i = 1;$i <= $leng;$i++) {
                        for ($c = 1, $n = 0;$c <= $i * 4 - 1;$c++, $n++) {
                            $n = strpos($list[$data['Month'][$y] - 1]['Day'], '"', $n);
                        }
                        $head = $n;
                        for ($c = 1, $n = 0;$c <= $i * 4;$c++, $n++) {
                            $n = strpos($list[$data['Month'][$y] - 1]['Day'], '"', $n);
                        }
                        $x = $n - 1 - $head;
                        $list[$data['Month'][$y] - 1]['Day'] = substr_replace($list[$data['Month'][$y] - 1]['Day'], "", $head, $x);
                    }
                    $code = $model->where('Year', $data['Year'])->where('Month', $data['Month'][$y])->update(['Day' => $list[$data['Month'][$y] - 1]['Day']]);
                }
            }
        } else {
            $list = $model->where('Year', $data['Year'])->where('Month', '<', 13)->field('Day')->select();
            for ($y = 0;$y < count($data['Month']);$y++) {
                echo $data['Month'][$y] . " ";
                for ($i = 0;$i < count($data['Day'][$data['Month'][$y]]);$i++) {
                    $head = strpos($list[$data['Month'][$y]]['Day'], $data['Day'][$data['Month'][$y]][$i], 0);
                    $head = strpos($list[$data['Month'][$y]]['Day'], '"', $head + 2);
                    $x = strpos($list[$data['Month'][$y]]['Day'], '"', $head + 1);
                    $x = $x - $head - 1;
                    $list[$data['Month'][$y]]['Day'] = substr_replace($list[$data['Month'][$y]]['Day'], "", $head + 1, $x);
                }
                $code = $model->where(['Year' => $data['Year'], 'Month' => $data['Month'][$y]])->update(['Day' => $list[$data['Month'][$y] - 1]['Day']]);
                // echo $model->getLastSql();
                
            }
        }
    }
    public function UpdataQ() {
        // $request = Request::instance();
        // $data = $request->post();   //全部数据
        // 必须要的数据有，年 类型 公司id 钱
        // 一年都是这个价，钱就传变量                                  日 和 月 为空
        // 一年就几个月是这个价，钱就传 一维数组(月)                    日为空
        // 一年的那几个月那几日就这个价，钱就传 二维数组(月+日)          都不得为空
        // $replace = array("1: AA1","2: AAA","3: AAA");
        // dump($replace);
        // echo implode("<br>",substr_replace($replace,'BB3B',3,3));
        // exit;
        $data['Year'] = "2016"; //年
        $data['Month'][0] = 1; //月
        $data['Month'][1] = 2;
        $data['Day'] = null; //日
        $data['Money'][2] = "1122"; //钱
        $data['Money'][1] = "1";
        $model = new QuoteModel;
        $list = $model->where('Year', $data['Year'])->where('Month', '<', 13)->field('Day')->select();
        if ($data['Day'] == NULL) {
            if ($data['Month'] == null) {
                for ($i = 0;$i < 12;$i++) {
                    $Month[$i] = $i + 1;
                }
                for ($y = 0;$y < count($list);$y++) {
                    $leng = substr_count($list[$y]['Day'], '|');
                    for ($i = 1;$i <= $leng;$i++) {
                        for ($c = 1, $n = 0;$c <= $i * 4 - 1;$c++, $n++) {
                            $n = strpos($list[$y]['Day'], '"', $n);
                        }
                        $head = $n;
                        for ($c = 1, $n = 0;$c <= $i * 4;$c++, $n++) {
                            $n = strpos($list[$y]['Day'], '"', $n);
                        }
                        $x = $n - 1 - $head;
                        $list[$y]['Day'] = substr_replace($list[$y]['Day'], $data['Money'], $head, $x);
                    }
                    $code = $model->where('Year', $data['Year'])->where('Month', '=', $Month[$y])->update(['Day' => $list[$y]['Day']]);
                }
            } else {
                for ($y = 0;$y < count($data['Month']);$y++) {
                    $leng = substr_count($list[$data['Month'][$y] - 1]['Day'], '|');
                    for ($i = 1;$i <= $leng;$i++) {
                        for ($c = 1, $n = 0;$c <= $i * 4 - 1;$c++, $n++) {
                            $n = strpos($list[$data['Month'][$y] - 1]['Day'], '"', $n);
                        }
                        $head = $n;
                        for ($c = 1, $n = 0;$c <= $i * 4;$c++, $n++) {
                            $n = strpos($list[$data['Month'][$y] - 1]['Day'], '"', $n);
                        }
                        $x = $n - 1 - $head;
                        $list[$data['Month'][$y] - 1]['Day'] = substr_replace($list[$data['Month'][$y] - 1]['Day'], $data['Money'][$data['Month'][$y]], $head, $x);
                    }
                    $code = $model->where('Year', $data['Year'])->where('Month', $data['Month'][$y])->update(['Day' => $list[$data['Month'][$y] - 1]['Day']]);
                }
            }
        } else {
            $list = $model->where('Year', $data['Year'])->where('Month', '<', 13)->field('Day')->select();
            for ($y = 0;$y < count($data['Month']);$y++) {
                echo $data['Month'][$y] . " ";
                for ($i = 0;$i < count($data['Day'][$data['Month'][$y]]);$i++) {
                    $head = strpos($list[$data['Month'][$y]]['Day'], $data['Day'][$data['Month'][$y]][$i], 0);
                    $head = strpos($list[$data['Month'][$y]]['Day'], '"', $head + 2);
                    $x = strpos($list[$data['Month'][$y]]['Day'], '"', $head + 1);
                    $x = $x - $head - 1;
                    $list[$data['Month'][$y]]['Day'] = substr_replace($list[$data['Month'][$y]]['Day'], $data['Money'], $head + 1, $x);
                }
                $code = $model->where(['Year' => $data['Year'], 'Month' => $data['Month'][$y]])->update(['Day' => $list[$data['Month'][$y] - 1]['Day']]);
            }
        }
    }
    public function SelectQ() {
        //根据年份和月份进行查询
        // $request = Request::instance();
        // $data = $request->post();   //全部数据
        $data['Year'] = "2016"; //年
        $data['Month'][0] = "2"; //月
        $model = new QuoteModel;
        $code = $model->where(['Year' => $data['Year'], 'Month' => ['in', $data['Month']]])->select();
        if ($code) {
            for ($y = 0;$y < count($code);$y++) {
                $leng = substr_count($code[$y]['Day'], '|');
                $arr = explode("|", $code[$y]['Day']);
                for ($i = 0;$i < $leng;$i++) {
                    preg_match('/\d+/', $arr[$i + 1], $n);
                    $day[$i] = $n[0];
                    $x = stripos($arr[$i + 1], $day[$i], 0);
                    $j = stripos($arr[$i + 1], '"', $x);
                    $arr[$i + 1] = substr_replace($arr[$i + 1], null, $x, $j);
                    $n = null;
                    preg_match('/\d+/', $arr[$i + 1], $n);
                    if ($n) {
                        $money[$i] = $n[0];
                    } else {
                        $money[$i] = null;
                    }
                }
            }
            dump($day);
            dump($money);
        } else {
            //返回错误信息
            
        }
    }
    public function infoQ() {
        //根据当前的年月日，从数据库获取数据，获取最近发团的日期
        $data = explode('/', date("Y/m/d"));
        again:
            $model = new QuoteModel;
            $code = $model->where(['Year' => $data[0], 'Month' => $data[1]])->field('Day')->select();
            if ($code) {
                $x = strstr($code[0]['Day'], '"' . $data[2] . '"', false);
                $arr = explode("|", $x);
                // $arr[1] = '"30"="300"';                 //记得删除
                for ($i = 0;$i < count($arr);$i++) {
                    preg_match('/\d+/', $arr[$i], $n);
                    $x = stripos($arr[$i], $n[0], 0);
                    $j = stripos($arr[$i], '"', $x);
                    $arr[$i] = substr_replace($arr[$i], null, $x, $j);
                    preg_match('/\d+/', $arr[$i], $n);
                    if ($n) {
                        break;
                    }
                }
                if ($i < count($arr)) {
                    $code = $model->where(['Year' => $data[0], 'Month' => $data[1]])->select();
                    for ($y = 0;$y < count($code);$y++) {
                        $leng = substr_count($code[$y]['Day'], '|');
                        $arr = explode("|", $code[$y]['Day']);
                        for ($i = 0;$i < $leng;$i++) {
                            preg_match('/\d+/', $arr[$i + 1], $n);
                            $day[$i] = $n[0];
                            $x = stripos($arr[$i + 1], $day[$i], 0);
                            $j = stripos($arr[$i + 1], '"', $x);
                            $arr[$i + 1] = substr_replace($arr[$i + 1], null, $x, $j);
                            $n = null;
                            preg_match('/\d+/', $arr[$i + 1], $n);
                            if ($n) {
                                $money[$i] = $n[0];
                            } else {
                                $money[$i] = null;
                            }
                        }
                    }
                    dump($day);
                    dump($money);
                } else {
                    if ($data[1] <= 12) {
                        $data[1] = $data[1] + 1;
                    } else {
                        $data[0] = $data[0] + 1;
                        $data[1] = 1;
                    }
                    gotoagain;
                }
            } else {
                //这种情况只有数据没有添加，才会成立！！！
                echo "数据不存在";
            }
        }
        public function xx() {
            $arr = [['qwe' => 'qwe', 'asd' => 'asd', 'zxc' => 'zxc'], ['rty' => 'rty', 'rty' => 'rty', 'rty' => 'rty'], ['vbn' => 'vbn', 'vbn' => 'vbn', 'fgh' => 'fgh'], ];
            dump($arr);
            array_splice($arr, 1, 1);
            dump($arr);
        }
    }
?>