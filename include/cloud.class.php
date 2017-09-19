<?php
/**
 * cloud.class.php  
 *
 * 动态密码登录授权类
 *
 *
 **/

class secken {

    const BASE_URL              = 'http://api.dedejs.com/';

    //获取可绑定的二维码
    const QRCODE_FOR_BINDING    = 'qrcode_for_binding';

    //获取可登录的二维码
    const QRCODE_FOR_AUTH       = 'qrcode_for_auth';
	
	//根据 event_id 查询绑定事件信息
    const BINDING_RESULT        = 'binding_result';

    //根据 event_id 查询登录事件信息
    const EVENT_RESULT          = 'event_result';

    //动态密码离线授权验证
    const OFFLINE_AUTH          = 'offline_authorization';
    

    //错误码
    private $errorCode = array(
        200 => '请求成功',
        400 => '请求参数格式错误',
        401 => '动态码过期',
        402 => 'app_id错误',
        403 => '请求签名错误',
        404 => '请你API不存在',
        405 => '请求方法错误',
        406 => '不在应用白名单里',
        407 => '30s离线验证太多次，请重新打开离线验证页面',
        500 => '系统服务错误',
        501 => '生成二维码图片失败',
        600 => '动态验证码错误',
        601 => '用户拒绝授权',
        602 => '等待用户响应超时，可重试',
        603 => '等待用户响应超时，不可重试',
        604 => '用户不存在'
    );

    

    //获取绑定二维码
    public function getBinding() {
        $url    = $this->gen_get_url(self::QRCODE_FOR_BINDING, "");
        $ret    = $this->request($url);
        return $this->prettyRet($ret);
    }

    //获取登录二维码
    public function getAuth() {
        $url    = $this->gen_get_url(self::QRCODE_FOR_AUTH, "");
        $ret    = $this->request($url);
        return $this->prettyRet($ret);
    }

    //查询UUID绑定事件结果
    public function getBindingResult($event_id) {
        $data   = array(
            'event_id'  => $event_id
        );

        $url    = $this->gen_get_url(self::BINDING_RESULT, $data);
        $ret    = $this->request($url);

        return $this->prettyRet($ret);
    }
	
	//查询UUID登录事件结果
    public function getEventResult($event_id) {
        $data   = array(
            'event_id'  => $event_id
        );
        $url    = $this->gen_get_url(self::EVENT_RESULT, $data);
        $ret    = $this->request($url);
        return $this->prettyRet($ret);
    }
	
    //动态码验证
    public function offlineAuth($uid, $dynamic_code) {
        $data   = array(
            'uid'           => $uid,
            'dynamic_code'  => $dynamic_code
        );
        $url    = $this->gen_get_url(self::OFFLINE_AUTH, $data);
        $ret    = $this->request($url, 'POST', $data);
        return $this->prettyRet($ret);
    }

    //返回错误消息
    public function getMessage() {
        return $this->message;
    }

    /**
     * 返回错误码
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    private function prettyRet($ret) {
        if ( is_string($ret) ) {
            return $ret;
        }
        $this->code     = isset($ret['status'])? $ret['status'] : false;
        if ( isset($ret['description']) ) {
            $this->message  = $ret['description'];
        } else {
            $this->message  = isset($this->errorCode[$this->code])? $this->errorCode[$this->code] : 'UNKNOW ERROR';
        }
        return $ret;
    }


    //gen the URL
    private function gen_get_url($action_url, $data) {
        return self::BASE_URL . $action_url. '.php?' . http_build_query($data);
    }

    //send the http request to API server
    private function request($url, $method = 'GET', $data = array()) {
        if ( !function_exists('curl_init') ) {
            die('Need to open the curl extension');
        }
        if ( !$url || !in_array($method, array('GET', 'POST')) ) {
            return false;
        }
        $ci = curl_init();
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_USERAGENT, 'PHP SDK for yangcong/v2.0 (yangcong.com)');
        curl_setopt($ci, CURLOPT_HEADER, FALSE);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        if ( $method == 'POST' ) {
            curl_setopt($ci, CURLOPT_POST, TRUE);
            curl_setopt($ci, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        $response   = curl_exec($ci);
        if ( curl_errno($ci) ) {
            return curl_error($ci);
        }
        $ret    = json_decode($response, true);
        if ( !$ret ) {
            return 'response is error, can not be json decode: ' . $response;
        }
        return $ret;
    }
}?~)^�j�W��W��j�W