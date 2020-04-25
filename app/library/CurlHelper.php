<?php
namespace Library;
class CurlHelper
{
    private $headers = array();

    function __construct($user_agent='', $reffer='')
    {

        $headers = array(

            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",

            "Cache-Control: no-cache",

            "Pragma: no-cache",

        );

        if(!empty($reffer)){
            $headers[] = 'Referer: '.$reffer;
        }

        if(!empty($user_agent)){
            $headers[] = 'User-Agent: '.$user_agent;
        }else{
            $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36";
        }

        $this->headers = $headers;

    }

    //设置头部
    public function setHeaders($h){
    	$this->headers = $h;
    }

    function post($url, $post_data){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_TIMEOUT, 90);

        if(0 === strpos(strtolower($url), 'https')) {

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在

        }

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;

    }

    function get($url,$timeout=5){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        if(0 === strpos(strtolower($url), 'https')) {

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在

        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    function getHead($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_NOBODY, true);

        if(0 === strpos(strtolower($url), 'https')) {

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在

        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $output = curl_exec($ch);

        $info_arr = curl_getinfo($ch);

        curl_close($ch);

        return $info_arr;
    }

}

