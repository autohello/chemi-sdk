<?php
/**
 * 用户车列表
 */
require(__DIR__ . '/../inc.php');

$uid = isset($argv[1]) ? $argv[1] : 108;

$car_list = $autohello->user()->car_list($uid);

var_dump($car_list);