<?php
/**
 * 品牌id查子品牌和对应车系
 */
require(__DIR__ . '/../inc.php');

$vendor_id = isset($argv[1]) ? $argv[1] : 61;

$r = $autohello->car()->brand_series((int) $vendor_id);
var_dump($r);