<?php
/**
 * 手机号认证
 */
require(__DIR__ . '/../inc.php');

$mobile = isset($argv[1]) ? $argv[1] : '';

$result = $autohello->auth()->mobile($mobile);

var_dump($result);
