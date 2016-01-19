<?php

/**
 * 配置接口调用
 */
class AutohelloConfig extends AutohelloBase
{

    public function question_tags()
    {
        $api_url = self::URL . '/api/config/question_tags/';
        $r = AutohelloUtils::api_get($api_url);

        return $r['tags'];
    }
}

/**
 * 用户方法
 */
class AutohelloUser extends AutohelloBase
{
    /**
     * 用户的车列表
     *
     * @param int $uid
     * @return array
     */
    public function car_list($uid)
    {
        $api_url = self::URL . '/api/user/car_list/' . intval($uid);
        return AutohelloUtils::api_get($api_url);
    }

    /**
     * 用户信息
     *
     * @param $uid
     * @return array
     */
    public function info($uid)
    {
        $api_url = self::URL . '/api/user/info/' . intval($uid);
        return AutohelloUtils::api_get($api_url);
    }

    /**
     * 用户的问题列表
     * 每页固定20条
     *
     * @param int $uid
     * @param int $page
     * @return array
     */
    public function questions($uid, $page=1)
    {
        $api_url = self::URL . '/api/user/questions/' . intval($uid) . '/' . intval($page);
        return AutohelloUtils::api_get($api_url);
    }

    /**
     * 用户参与回复的问题列表
     * 包括自己回复自己和自己回复他人的
     * 每页固定20条
     *
     * @param int $uid
     * @param int $page
     * @return array
     */
    public function replied_questions($uid, $page=1)
    {
        $api_url = self::URL . '/api/user/replied_questions/' . intval($uid) . '/' . intval($page);
        return AutohelloUtils::api_get($api_url);
    }
}

/**
 * 车型库方法
 */
class AutohelloCar extends AutohelloBase
{
    /**
     * 厂商列表(大品牌)
     *
     * @return array
     */
    public function vendor()
    {
        $api_url = self::URL . '/api/car/vendor/';
        $r =  AutohelloUtils::api_get($api_url);
        return $r['list'];
    }

    /**
     * 品牌列表(对应其他数据方的渠道名,如上海大众)
     *
     * @param int $vendor_id
     * @return array
     */
    public function brand($vendor_id)
    {
        $api_url = self::URL . '/api/car/brand/' . intval($vendor_id);
        $r =  AutohelloUtils::api_get($api_url);
        return $r['list'];
    }

    /**
     * 车系列表
     *
     * @param int $brand_id
     * @return array
     */
    public function series($brand_id)
    {
        $api_url = self::URL . '/api/car/series/' . intval($brand_id);
        $r =  AutohelloUtils::api_get($api_url);
        return $r['list'];
    }

    /**
     * 车款列表
     *
     * @param int $series_id
     * @return array
     */
    public function model($series_id)
    {
        $api_url = self::URL . '/api/car/model/' . intval($series_id);
        $r =  AutohelloUtils::api_get($api_url);
        return $r['list'];
    }

    /**
     * 参考部分app设计,将自品牌作为分组,取出同一vendor下的所有车系
     *
     * @param int $vendor_id
     * @return mixed
     */
    public function brand_series($vendor_id)
    {
        $api_url = self::URL . '/api/car/brand_series/' . intval($vendor_id);
        $r =  AutohelloUtils::api_get($api_url);
        return $r['list'];
    }
}

/**
 * 问答
 */
class AutohelloQuestion extends AutohelloBase
{
    /**
     * 问题详情
     *
     * @param int $question_id
     * @return array
     */
    public function detail($question_id)
    {
        $api_url = self::URL . '/api/question/detail/' . intval($question_id);

        $r =  AutohelloUtils::api_get($api_url);

        return $r['question'];
    }

    /**
     * 回答列表
     *
     * @param int $question_id
     * @return array
     */
    public function answer_list($question_id)
    {
        $api_url = self::URL . '/api/question/answer_list/' . intval($question_id);

        $r =  AutohelloUtils::api_get($api_url);

        return $r;
    }
}

/**
 * 认证方法
 */
class AutohelloAuth extends AutohelloBase
{
    /**
     * 用 UID, TOKEN 创建认证接口对象
     *
     * @param int $uid
     * @param string $token
     * @return \AutohelloAuthedAPI
     */
    public function api($uid, $token)
    {
        return new AutohelloAuthedAPI($uid, $token);
    }

    /**
     * 使用手机号获取认证接口对象
     *
     * @param string $mobile
     * @return \AutohelloAuthedAPI
     */
    public function mobile($mobile)
    {
        $result = $this->mobile_auth($mobile);

        return $this->api($result['uid'], $result['token']);
    }

    /**
     * 使用手机号认证
     *
     * @param  string $mobile
     * @return array            ['uid'=>UID, 'token'=>$token]
     */
    public function mobile_auth($mobile)
    {
        $api_url = self::URL . '/u/sync/mobile';

        $ts = time();

        $param = '';
        $param .= '&ts=' . $ts;
        $param .= '&source=' . CHEMI_SOURCE;
        $param .= '&mobile=' . $mobile;
        $param .= '&sig=' . $this->sign('mobile', $mobile, $ts);

        $result = AutohelloUtils::api_get($api_url . '?' . $param);

        return $result;
    }

    /**
     * 签名方法
     *
     * @param string $type
     * @param string $data
     * @param string $ts
     * @return string
     */
    protected function sign($type, $data, $ts)
    {
        return md5(CHEMI_SOURCE . CHEMI_SECRET . $ts . $type . $data);
    }
}


/**
 * 认证后可用的接口
 */
class AutohelloAuthedAPI extends AutohelloBase
{
    protected $uid;
    protected $token;

    public function __construct($uid, $token)
    {
        $this->uid = $uid;
        $this->token = $token;
    }

    protected function call_api($api_url, $data)
    {
        $post = 'json=' . urlencode(json_encode($data));

        $post .= '&token=' . urlencode($this->token);
        $post .= '&uid=' . intval($this->uid);
        $post .= '&source=' . intval(CHEMI_SOURCE);

        return AutohelloUtils::api_post($api_url, $post);
    }

    public function user()
    {
        return new AutohelloAuthedUser($this->uid, $this->token);
    }

    public function question()
    {
        return new AutohelloAuthedQuestion($this->uid, $this->token);
    }
}

/**
 * 认证后可用的用户相关接口
 */
class AutohelloAuthedUser extends AutohelloAuthedAPI
{

    /**
     * 用户添加车
     *
     * @param int    $model_id     车款id,必选
     * @param string $plate_number 车牌号,可选
     * @return array
     */
    public function add_car($model_id, $plate_number='')
    {
        $api_url = self::URL . '/u/user/add_car';
        $data = [
            'model_id'     => $model_id,
            'plate_number' => $plate_number,
        ];

        return $this->call_api($api_url, $data);
    }

    /**
     * 用户提问
     *
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function my_questions($page=1, $pagesize=10)
    {
        $api_url = self::URL . '/u/user/my_questions/' . $page . '/' . $pagesize;
        $data = [];

        return $this->call_api($api_url, $data);
    }

    /**
     * 用户答案
     *
     * @param int $page
     * @param int $pagesize
     * @return mixed
     */
    public function my_answers($page=1, $pagesize=10)
    {
        $api_url = self::URL . '/u/user/my_answers/' . $page . '/' . $pagesize;
        $data = [];

        return $this->call_api($api_url, $data);
    }
}

/**
 * 认证后可用的提问、回答相关接口
 */
class AutohelloAuthedQuestion extends AutohelloAuthedAPI
{
    /**
     * 提问
     *
     * @param array   $info  array(content=>标题, tags=>分类标签 参考 config->question_tags(), model_id=>车款ID, user_car_id => 用户车ID)
     * @return mixed
     * @throws \Exception
     */
    public function ask(array $info)
    {
        if (!isset($info['content']) || !isset($info['tags']) || (!isset($info['model_id']) && !isset($info['user_car_id']))) {
            throw new Exception('缺少参数', 10002);
        }

        $api_url = self::URL . '/u/question/ask/';

        return $this->call_api($api_url, $info);
    }

    /**
     * 回复
     *
     * @param int    $question_id        问题ID
     * @param string $content            回复内容
     * @param int    $reply_to_answer_id 回复评论ID,如果是回复了别人的评论,带上这个ID,默认为0
     * @param array  $reply_to_uids      回复提醒UID列表,提到的用户会收到推送,只限该问题的参与者
     * @return mixed
     */
    public function answer($question_id, $content, $reply_to_answer_id=0, array $reply_to_uids=[])
    {
        $reply_to_uids = array_map('intval', $reply_to_uids);

        $data = array(
            'content'   =>  $content,
            'reply_list' => $reply_to_uids,
        );

        $api_url = self::URL . '/u/question/answer/' . intval($question_id) . '/' . intval($reply_to_answer_id);

        return $this->call_api($api_url, $data);
    }
}


# EOF