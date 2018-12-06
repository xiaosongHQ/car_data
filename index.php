<?php
require_once(__DIR__.'/app/car.class.php');
 $car = new Car();
 echo "<pre>";
    $res = $car->get_car();
    var_dump($res);