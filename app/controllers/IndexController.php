<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function esTestAction()
    {
        $params = [
            'index' => 'jxc',
            'body'  =>[
                'mappings'=>[
                    'xianlu' => [
                        'properties'=> [
                            'id'=>[
                                'type' => 'long',
                            ],
                            'city_id' => [
                                'type' => 'integer',
                            ],
                        ]
                    ]
                ]
            ]
        ];

        $bool = $this->es->create($params);
        echo $bool;
    }

    public function redisTestAction()
    {
        echo $this->request->get('h');exit;
        echo $this->redis->set('jxc',12233);
    }

    public function curlTestAction()
    {
        $content = $this->curl->get('http://www.wenming.cn/');
        print_r( $this->curl->get('http://www.wenming.cn/'));
        exit;
    }

    public function configAction()
    {
        print_r($this->config);
    }

    public function getServiceAction()
    {
        $logService = $this->service->get('log');
        $logContent = $logService->log(123);
        echo $logContent;

        $logService = $this->service->get('log');
        $logContent = $logService->log(456);
        echo $logContent;
    }
}

