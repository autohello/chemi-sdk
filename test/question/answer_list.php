<?php
/**
 * 答案列表
 */

require(__DIR__ . '/../inc.php');

$question_id = isset($argv[1]) ? $argv[1] : 0;

$r = $autohello->question()->answer_list((int) $question_id);
var_dump($r);
