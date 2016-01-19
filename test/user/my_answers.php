<?php
/**
 * 用户答案
 *
 * title: 问题
 * content: 答案
 */
require(__DIR__ . '/../inc.php');

$mobile = '';
$t = $autohello->auth()->mobile($mobile);

$page = 1;

$answers = $t->user()->my_answers($page, $pagesize=10);

var_dump($answers);