<?php
    require_once('./base/base.class.php');
    class Car extends Base
    {
        public function get_car_list(){
            $arr = range("A","Z");
            $n = 0;
            $car = [];
            $car_type=[];
            foreach ($arr as $key => $value) {
                $body = $this->get_request("https://www.autohome.com.cn/grade/carhtml/{$value}.html");
                preg_match_all('/dl([\s\S]*?)<\/dl/', $body['body'],$array);
                foreach ($array[0] as $kk => $vv) {
                    // return $array[0][0];

                    preg_match_all('/c=\"\/(.*?)\"><\/a><div><a href=\"\/(.*?)">(.*?)<\/a><\/div><\/dt/', $array[0][$kk],$a);
                    preg_match_all('/4.*=\"\/(.*?)\".*>(.*?)<\/a><\/h4/', $array[0][$kk],$b);
                    array_shift($a);
                    array_shift($b);
                    $car_type[$kk]['car_logo'] = $a[0][0];
                    $car_type[$kk]['car_sign'] = $a[1][0];
                    $car_type[$kk]['car_type_name'] = $a[2][0];
                    $car_type[$kk]['letter'] = $value;
                    $car_type[$kk]['car_type_id'] = $this->get_code();
                    foreach ($b[0] as $kkk => $vvv) {
                        $n++;
                        $car[$n]['car_type_id'] = $car_type[$kk]['car_type_id'];
                        $car[$n]['car_sign'] = $b[0][$kkk];
                        $car[$n]['car_name'] = $b[1][$kkk];
                        $car[$n]['letter'] = $value;
                    }
                }
                $time=time();
                foreach ($car as $ke => $va) {
                    echo $value.'-----'.$ke;
                    $sql = "insert into `car` (car_type_id,car_sign,car_name,letter,created_at) values ('{$va['car_type_id']}','{$va['car_sign']}','{$va['car_name']}','{$va['letter']}','{$time}')";
                    echo '---'.$this->pdo->exec($sql);
                    echo "----ok\n";
                }
                foreach ($car_type as $kes => $vas) {
                    echo $value.'---type--'.$kes;
                    $sql = "insert into `car_type` (letter,car_type_id,car_sign,car_type_name,car_logo,created_at) values ('{$vas['letter']}','{$vas['car_type_id']}','{$vas['car_sign']}','{$vas['car_type_name']}','{$vas['car_logo']}','{$time}')";
                    echo '---'.$this->pdo->exec($sql);
                    echo "----ok\n";
                }
            }
            return 'over';
        }
    }


/*<dt><a href=\"\/(.*?)\"><img width=\"50\" height=\"50\" src=\"\/(.*?)"><\/a><div><a href=.*?>(.*?)<*/
