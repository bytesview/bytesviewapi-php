<?php
require_once '../autoload.php';
require_once 'config.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

$data = array(
                "key1" => "Shriram Automall India Limited is hiring for Accounts Department."               
            );

$response = $bytesviewapiObj->topic_api($data);

var_dump($response);