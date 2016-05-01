<?php
	/**
	 * @descript GET请求
	 * @param  [string]  $url  请求地址
	 * @return [json]	 $data 返回数据
     */
    function https_get($url)
    {
        //初始化一个会话
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //超时时间
    	curl_setopt($ch, CURLOPT_TIMEOUT, 500);
		//判断一下是不是https
        if(strpos($url,'https') == 0){
            //跳过证书验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        //发送到那个地址
    	curl_setopt($ch, CURLOPT_URL, $url);
        //执行会话	
		$result = curl_exec($ch);
        //关闭会话
		curl_close($ch);

		return $result;
    }

	/**
	 * @descript POST请求
	 * @param  [string]    $url    请求地址
	 * @param  [array]     $array  发送数据
	 * @return [json]	   $data   返回数据
     */
    function https_post($url,$data = '')
    {
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //判断一下是不是https
        if(strpos($url,'https') == 0){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        //判断是否要传数据
        if (!empty($data)){
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HEADER, 0); 
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
		return $result;
    }

    /**
     * @descript 接口请求
     * @param  [string]    $url     请求地址
     * @param  [array]     $array   发送数据
     * @return [json]      $results 返回数据
     */
    function Api($url,$post,$action_type)
    {
        $req = json_encode($post);

        $data = array(
            'partnercode'   => partnercode,
            'key'           => key,
            'version'       => version,
            'source'        => source,
            'action'        => $action_type,
            'reqhash'       => urlencode(md5($req.key)),
            'req'           => $req,
        );

        return json_decode(https_post($url,$data),true);
    }

    /**
     * @descript 判断手机还是电脑访问
     */
    function isMobile(){
        //获取用户浏览器
        $UA = strtoupper(@$_SERVER['HTTP_USER_AGENT']);
        //判断用户浏览器标识
        if(preg_match("/(iPhone|iPad|iPod|Android)/i", $UA)){
            $source = 2;
        }
        //如果存在并且不等于false
        if(strpos($UA, 'WINDOWS NT') !== false){
            $source = 1;
        }
        return $source;
    }
    /**
     * @descript 判断成功后跳转
     */
    function results_location($location,$address){
        if($location['result'] == 1){
            $location_addr = $address['yes'];
        }else{
            $location_addr = $address['no'];
        }

        exit('<script>alert("'.$location['notice'].'");location.href="'.$location_addr.'"</script>');
    }

    /**
     * @descript 验证码 m个数字  显示大小为n   边宽x   边高y 
     */
    function vCode($num = 4, $size = 20, $width = 0, $height = 0) {   
        !$width && $width = $num * $size * 4 / 5 + 5;   
        !$height && $height = $size + 10;    
        // 去掉了 0 1 O l 等  
        $str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVW";   
        $code = '';   
        for ($i = 0; $i < $num; $i++) {   
            $code .= $str[mt_rand(0, strlen($str)-1)];   
        }    
        // 画图像  
        $im = imagecreatetruecolor($width, $height);    
        // 定义要用到的颜色  
        $back_color = imagecolorallocate($im, 235, 236, 237);   
        $boer_color = imagecolorallocate($im, 118, 151, 199);   
        $text_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));    
        // 画背景  
        imagefilledrectangle($im, 0, 0, $width, $height, $back_color);    
        // 画边框  
        // imagerectangle($im, 0, 0, $width-1, $height-1, $boer_color);    
        // 画干扰线  
        for($i = 0;$i < 5;$i++) {   
            $font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));   
            imagearc($im, mt_rand(- $width, $width), mt_rand(- $height, $height), mt_rand(30, $width * 2), mt_rand(20, $height * 2), mt_rand(0, 360), mt_rand(0, 360), $font_color);   
        }    
        // 画干扰点  
        for($i = 0;$i < 50;$i++) {   
            $font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));   
            imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $font_color);   
        }    
        // 画验证码  
        @imagefttext($im, $size , 0, 5, $size + 3, $text_color, 'c:\\WINDOWS\\Fonts\\simsun.ttc', $code);   
        $_SESSION["VerifyCode"]= strtolower($code);    
        header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");   
        header("Content-type: image/png;charset=gb2312");   
        imagepng($im);   
        imagedestroy($im);   
    }  