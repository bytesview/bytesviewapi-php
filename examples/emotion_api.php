<?php
require_once '../autoload.php';
require_once 'config.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

$data = array(
                "string1" => "Accessories for AirTags appearing online, Apple hasn't announced the tracking fobs",
                "string2" => "this is not what we expect"
            );

$response = $bytesviewapiObj->emotion_api($data);

var_dump($response);