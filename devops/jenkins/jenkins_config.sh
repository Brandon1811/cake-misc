#!/bin/bash

cat > config/app_local.php <<'CONFIG'
<?php
return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
    'Error' => [
        'errorLevel' => E_ALL & ~E_USER_DEPRECATED,
        'exceptionRenderer' => 'Cake\Error\ExceptionRenderer',
        'skipLog' => [],
        'log' => true,
        'trace' => true,
    ],
    'Email' => [
        'default' => [
            'transport' => 'test',
            'from' => 'JENKINS@example.com',
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
        ],
    ],
    'Datasources' => [
        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'host'       => 'localhost',
            'database'   => 'cakephp_test',
            'username'      => 'jenkins',
            'password'   => 'cakephp_jenkins',
            'log' => true,
        ],
    ],
    'Queuesadilla' => [
        'default' => [
            'url' => 'mysql://jenkins:cakephp_jenkins@localhost:3306/cakephp_test?table=jobs',
        ],
    ],
];
CONFIG
