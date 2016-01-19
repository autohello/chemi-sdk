<?php
/**
 * 子品牌ID查车系
 */
require(__DIR__ . '/../inc.php');

$brand_id = isset($argv[1]) ? $argv[1] : 61;

$r = $autohello->car()->series((int) $brand_id);
var_dump($r);