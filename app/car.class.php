<?php
    require_once('./base/base.class.php');
    class Car extends Base
    {
        public function get_car(){
            $arr = range("A","Z");
            foreach ($arr as $key => $value) {
                $body = $this->get_request("https://www.autohome.com.cn/grade/carhtml/{$value}.html");
                preg_match_all('/dl([\s\S]*?)<\/dl/', $body['body'],$array);
                foreach ($array as $kk => $vv) {
                    return $vv[0];
                }
                return $array;



                array_shift($array);
                $car_data = [];
                foreach ($array[0] as $k => $v) {
                    $car_data[$k][] = $array[0][$k];
                    $car_data[$k][] = $array[1][$k];
                    $car_data[$k][] = $array[2][$k];
                }
                return $array;
            }
            return json_encode($arr);
        }
    }


/*<dt><a href=\"\/(.*?)\"><img width=\"50\" height=\"50\" src=\"\/(.*?)"><\/a><div><a href=.*?>(.*?)<*/
