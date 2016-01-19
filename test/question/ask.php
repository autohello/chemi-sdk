<?php
/**
 * 提问
 */

require(__DIR__ . '/../inc.php');

$mobile = '';
$t = $autohello->auth()->mobile($mobile);

$content = '<script>alert(/a/)</script>' . mt_rand();
$description = '<script>alert(/a/)</script>';

$model_id = 6;

# 提问可接受的分类标签列表，必选参数
$all_tags = $autohello->config()->question_tags();

$tags = $all_tags[array_rand($all_tags)];

$info = [
    'content'     => $content,
    'model_id'    => $model_id,
    'user_car_id' => 0,
    'tags'        => $tags,
];

$ret = $t->question()->ask($info);

var_dump($ret);