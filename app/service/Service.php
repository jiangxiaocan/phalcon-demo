<?php
namespace Service;
/**
 * Created by PhpStorm.
 * User: jxc
 * Date: 2020/4/25
 * Time: 21:35
 */

class Service{
    private $service = [];
    public function get($name)
    {
        if(empty($name)){
            return false;
        }

        if(isset($this->service[$name])){
            return $this->service[$name];
        }

        $flag = strpos($name,'/') !==false;
        if($flag){

            $className = substr($name, strpos($name,'/')+1).'Service';
            $subPath = strtolower(substr($name, 0, strpos($name,'/')));

            $path = APP_PATH."/service/{$subPath}/{$className}.php";
            require_once( $path );

            $class = new $className();

        }else{
            $basename = strtolower($name);
            $path = APP_PATH.'/service/'.$basename.'/service.php';
            require_once( $path );

            $className  = $name.'Service';
            $class = new $className();

        }
        $this->service[$name] = $class;

        return $this->service[$name];
    }
}