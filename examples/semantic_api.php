<?php
require_once '../autoload.php';
require_once 'config.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

$data = array(
                "string1" => "this is what we expect",
                "string2" => "this is not what we expect"
            );

$response = $bytesviewapiObj->semantic_api($data);

var_dump($response);