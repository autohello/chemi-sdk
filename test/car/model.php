<?php
/**
 * 车系id查车款列表
 */
require(__DIR__ . '/../inc.php');

$series_id = isset($argv[1]) ? $argv[1] : 61;

$r = $autohello->car()->model((int) $series_id);
var_dump($r);