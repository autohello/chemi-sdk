<?php
/**
 * 用户信息、用户提问列表、用户回答过的问题列表
 */
require(__DIR__ . '/../inc.php');

$uid = isset($argv[1]) ? $argv[1] : 108;

$user_info = $autohello->user()->info($uid);

var_dump($user_info);

$user_questions = $autohello->user()->questions($uid);
var_dump($user_questions);

$user_replied_questions = $autohello->user()->replied_questions($uid);
var_dump($user_replied_questions);