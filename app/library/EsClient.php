<?php
namespace Library;
/**
 * es客户端封装类
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/1/22
 * Time: 15:52
 */

class EsClient
{
    private $config = [];
    private $client = null;

    public function __construct( $config ){
        $this->config = $config;
        $hosts = array($this->config['host']);
        $this->client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
    }


    /**
     * 批量插入文档
     * https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_indexing_documents.html
     * @param params
     * [
     *      body => [
     *          ['index'=>['_index'=>$esIndex, '_type'=>$esType, '_id'=>$id]],
     *          [doc],
     *          ['index'=>['_index'=>$esIndex, '_type'=>$esType, '_id'=>$id]],
     *          [doc],
     *          ......
     *      ]
     * ]
     * @return $reponse,插入多少条就有多少个items，更新和插入的status状态是不同的
     *  {
     *      "took": 7,
     *     "errors": false,
     *     "items": [
     **         {
     *         "index": {
     *         "_index": "search",
     *         "_type": "xianlu",
     *        "_id": "2",
     *         "_version": 11,
     *         "result": "updated",
     *        "_shards": {
     *        "total": 2,
     *        "successful": 1,
     *         "failed": 0
     *        },
     *        "created": false,
     *        "status": 200
     *         }
     *         }
     *      ]
     * }
     */
    public function bulk( $params ){
        $ret = null;
        try{
            $reponse = $this->getClient()->bulk($params);
            return $reponse;
        }catch(Exception $e){
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 清空 type
     * @param params
     * [
     *      'index' => index,
     *      'type' => type,
     * ]
     * @return bool
     */
    public function clearType( $params ){
        //deleteByQuery
        try{
            $params['body'] = [
                'query' => [
                    'match_all'=>new \stdClass()
                ]
            ];
            $this->getClient()->deleteByQuery($params);
        }catch(Exception $e){
            $this->getLogger()->info("clear type failed!!" . $e->getMessage());
            return FALSE;
        }
        return TRUE;
    }


    /**
     * 创建索引, 存在则不创建
     * https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_index_management_operations.html
     * @param params
     * [
     *      index=>index
     * ]
     * @return bool
     */
    public function create( $params ){
        $createParams = [
            'index' => $params['index']
        ];
        $exists = $this->getClient()->indices()->exists($createParams);
        if($exists){
            return TRUE;
        }

        try{
            $this->getClient()->indices()->create($params);
        }catch(Exception $e){
            return FALSE;
        }
        return TRUE;
    }


    /**
     * 映射字段
     * https://www.elastic.co/guide/en/elasticsearch/client/php-api/5.0/_index_management_operations.html
     * @param $params
    //        $params = [
    //            'index' => 'my_index',
    //            'type' => 'my_type2',
    //            'body' => [
    //                'my_type2' => [
    //                    '_source' => [
    //                        'enabled' => true
    //                    ],
    //                    'properties' => [
    //                        'first_name' => [
    //                            'type' => 'string',
    //                            'analyzer' => 'standard'
    //                        ],
    //                        'age' => [
    //                            'type' => 'integer'
    //                        ]
    //                    ]
    //                ]
    //            ]
    //        ];
     * @return bool
     */
    public function putMapping( $params ){
        try{
            $this->getClient()->indices()->putMapping($params);
        }catch(Exception $e){
            return FALSE;
        }
        return TRUE;
    }


    /**
     * 添加文档
     * @param $params
    //        $params = [
    //            'index' => 'my_index',
    //            'type' => 'my_type',
    //            'id' => 'my_id',
    //            'body' => [ 'testField' => 'abc']
    //        ];
     * @return array
     */
    public function index( $params ){
        $ret = null;
        try{
            $ret = $this->getClient()->index($params);
        }catch(Exception $e){
            return false;
        }
        return $ret;
    }

    /**
     * 更新文档
     * https://www.elastic.co/guide/en/elasticsearch/client/php-api/5.0/_updating_documents.html
     * @param $params
     * @return array
     */
    public function update( $params ){
        $ret = null;
        try{
            $ret = $this->getClient()->update($params);
        }catch(Exception $e){
            return false;
        }
        return $ret;
    }

    /**
     * https://www.elastic.co/guide/en/elasticsearch/client/php-api/5.0/_deleting_documents.html
     * 删除文档
     * @param $id
     * @param
     */
    public function delete( $params ){
        $ret = null;
        try{
            $ret = $this->getClient()->delete($params);
        }catch(Exception $e){
            return false;
        }
        return $ret;
    }

    /**
     * 搜索
     * https://www.elastic.co/guide/en/elasticsearch/client/php-api/5.0/_search_operations.html
     * @param $queryBody
     * @return mixed
     */
    public function search( $params ){
        $ret = null;
        try{
            $ret = $this->getClient()->search( $params );
        }catch(Exception $e){
            return false;
        }
        return $ret;
    }

    /**
     * 获取es 客户端实例
     * @return null
     */
    private function getClient(){
        return $this->client;
    }

}
