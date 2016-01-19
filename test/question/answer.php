<?php
/**
 * 回答
 */

require(__DIR__ . '/../inc.php');


$mobile = '';
$t = $autohello->auth()->mobile($mobile);

$question_id = 6025365;
$content = '<script>alert(/a/)</script>';
$reply_answer_id = 0;
$reply_uids = [];

$car = $t->question()->answer($question_id, $content, $reply_answer_id, $reply_uids);

var_dump($car);