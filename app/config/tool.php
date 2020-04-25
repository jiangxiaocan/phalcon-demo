<?php
/**
 * Created by PhpStorm.
 * User: jxc
 * Date: 2020/4/25
 * Time: 20:37
 */
use Library\EsClient;
use Library\CurlHelper;
Use Service\Service;

$di->set('es',function (){

    $esServerConfig = require APP_PATH.'/config/elasticsearch_service.php';

    return new EsClient($esServerConfig['default']);
});

$di->set('redis',function () use($config){
    $redis = new redis();
    $redis->connect($config->redis->host,$config->redis->port);
    if(!empty($config->redis->password)){
        $redis->auth($config->redis->password);
    }
    return $redis;
});

$di->set('curl',function (){
    $curl = new CurlHelper();
    return $curl;
});

$di->set('service',function (){
    $service  = new Service();
    return $service;
});