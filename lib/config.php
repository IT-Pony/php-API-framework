<?php
    define('partnercode', '1000');
    define('key', 'xiaobao@000');
    define('version', '1.0');
    define('source', isMobile());
    //短信配置
    $message = array(
        1 => '找回密码,本次短信验证码是',
        2 => '忘记密码,本次短信验证码是',
        3 => '会员注册,本次短信验证码是',
        4 => '提现申请，本次短信验证码是',
    );
    
    session_start();

    if(!empty($_SESSION['codes'])){
		$codes_check = explode('_',$_SESSION['codes']);
        if($codes_check['1'] < time()) $_SESSION['codes'] = '0_0';
    }

    //第三方登录接口
    //qq
    define('qq_appid', '101060216');
    define('qq_appkey', '2e14cf9819e1705a48a980a4f7c07cd0');
    define('qq_callback', 'http://www.baosm.com/user.php&scope=get_user_info&state='.md5('qq'));
    //weibo
    define( "WB_AKEY" , '224904879' );
    define( "WB_SKEY" , '36dd35e03b164b015733c5a50e421dcd' );
    define( "WB_CALLBACK" , 'http://www.baosm.com&scope=all&state='.md5('sina'));
    //weixin
    define('wx_appid', 'wx1fb43dd11f2ff701');
    define('wx_secret', 'd33c2f5fd9470a16dc3fe6e270addef8');
    define('wx_callback', 'http://www.baosm.com/weixincallback.php');