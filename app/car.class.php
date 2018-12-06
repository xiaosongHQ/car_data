<?php
    require_once('./base/base.class.php');
    class Car extends Base
    {
        public function get_car(){
            $arr = range("A","Z");
            foreach ($arr as $key => $value) {
                $body = $this->get_request("https://www.autohome.com.cn/grade/carhtml/{$value}.html");
                preg_match_all('/h3-tit\"><a href=\"\/(.*?)\">/', $body,$array);
                return $array;
            }
            return json_encode($arr);
        }
    }