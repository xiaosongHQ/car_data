<?php
    class Base
    {
        protected function test($a){
            return $a+$a;
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
    }