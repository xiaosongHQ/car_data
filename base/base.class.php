<?php
    class Base
    {
        public $pdo;
        public function __construct(){//构造方法  链接数据库  设置不超时
            ini_set('max_execution_time', '0');    //设置运行不超时
            try {
                $pdo = new PDO('mysql:host=47.52.204.201;dbname=car_data','xiaosongHQ','Lx5201314.');
                $this->pdo = $pdo;
            } catch (PDOException $e) {
                echo 'error:'.$e->getMessage();
                return '数据库连接遇到了问题';
            }
        }

        //获取网页源代码
        public function get_request($url,$method='get',$data=[],$code='utf8'){  //后期更改protected
            $curl=curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            if($method=='post'){
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            if($code=='gbk'){
                $this_code = array("content-type: application/x-www-form-urlencoded; charset=GBK");//编码乱码
                curl_setopt($curl,CURLOPT_HTTPHEADER,$this_code);
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //将curl_exec()获取的信息以字符串返回
            $body=curl_exec($curl);
            $body = mb_convert_encoding($body, 'utf-8', 'GBK,UTF-8,ASCII');
            $message = curl_getinfo($curl,CURLINFO_HTTP_CODE);
            return ['body'=>$body,'message'=>$message];
        }


        public function get_code(){//获得编号
             $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
            str_shuffle($str);
            $name=substr(str_shuffle($str),18,18);
            return 'WS'.$name.$this->getMillisecond();
        }


        protected function getMillisecond() {//获得毫秒时间
            list($t1, $t2) = explode(' ', microtime());
            return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
        }
    }