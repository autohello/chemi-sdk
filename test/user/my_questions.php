<?php
/**
 * 用户问题
 */
require(__DIR__ . '/../inc.php');

$mobile = '';
$t = $autohello->auth()->mobile($mobile);

$page = 1;

$questions = $t->user()->my_questions($page, $pagesize=10);

var_dump($questions);