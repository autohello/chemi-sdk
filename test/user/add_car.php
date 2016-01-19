<?php
/**
 * 用户添加车
 */
require(__DIR__ . '/../inc.php');

$mobile = '';
$t = $autohello->auth()->mobile($mobile);

$model_id = 6; # DS 5 2014款 1.6T 手自一体 THP160 豪华版

$car = $t->user()->add_car($model_id);

var_dump($car);