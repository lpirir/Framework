<?php

/**
 * This is an auto generated file by Webiny Rest component.
 * Please do not edit this file because the changes might break your REST Api.
 *
 * @rest.class Webiny\Component\Rest\Tests\Mocks\MockApiClassNew
 * @rest.version v1.1
 * @rest.buildDate Wed, 27. Aug, 2014 00:09:51
 */

$a = array(
    'class'             => 'Webiny\\Component\\Rest\\Tests\\Mocks\\MockApiClassNew',
    'cacheKeyInterface' => false,
    'accessInterface'   => false,
    'version'           => '1.1',
    'get'               => array(
        'new-method/' => array(
            'default'     => false,
            'role'        => false,
            'method'      => 'newMethod',
            'urlPattern'  => 'new-method',
            'cache'       => array(
                'ttl' => 0,
            ),
            'header'      => array(
                'cache'  => array(
                    'expires' => 0,
                ),
                'status' => array(
                    'success'      => 200,
                    'error'        => 404,
                    'errorMessage' => '',
                ),
            ),
            'rateControl' => array(),
            'params'      => array(),
        ),
    ),
);


return $a;