<?php
/**
 * 车秘问答SDK
 *
 * @author sskaje
 * @version 0.1
 */

/**
 * Source
 */
defined('CHEMI_SOURCE') or die("define CHEMI_SOURCE!\n");

/**
 * Secret
 */
defined('CHEMI_SECRET') or die("define CHEMI_SECRET!\n");

define('CHEMI_API_SDK_VERSION', '0.1');

/**
 * 基础类
 */
class AutohelloBase
{
    /**
     * 生产环境
     */
    #const URL = 'http://api.autohello.com';
    /**
     * 开发环境
     */
    const URL = 'http://api.km.dev.autohello.cn';
    /**
     * 开发环境外网接入
     */
    #const URL = 'http://api.km.vpn.autohello.cn:30080';

}

class Autohello extends AutohelloBase
{

    public function __construct()
    {
    }

    /**
     * 认证
     *
     * @return \AutohelloAuth
     */
    public function auth()
    {
        return new AutohelloAuth();
    }

    /**
     * 配置
     *
     * @return \AutohelloConfig
     */
    public function config()
    {
        return new AutohelloConfig();
    }

    /**
     * 车型库
     *
     * @return \AutohelloCar
     */
    public function car()
    {
        return new AutohelloCar();
    }

    /**
     * 用户
     *
     * @return \AutohelloUser
     */
    public function user()
    {
        return new AutohelloUser();
    }

    /**
     * 问答
     *
     * @return \AutohelloQuestion
     */
    public function question()
    {
        return new AutohelloQuestion();
    }
}

/**
 * Class AutohelloException
 */
class AutohelloException extends Exception {}



# EOF