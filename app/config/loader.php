<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->librarayDir,
        $config->application->serviceDir
    ]
)->registerNamespaces(
    [
        "Library" => APP_PATH ."/library/",
        "Service" => APP_PATH ."/service/",
    ]
)->register();
