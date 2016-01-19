<?php
/**
 * 问题详情
 */

require(__DIR__ . '/../inc.php');

$question_id = isset($argv[1]) ? $argv[1] : 0;

$r = $autohello->question()->detail((int) $question_id);
var_dump($r);
