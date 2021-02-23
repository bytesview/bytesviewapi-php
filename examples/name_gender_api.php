<?php
require_once '../autoload.php';
require_once 'config.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

$data  =  array("key1" => "alvina","ey2"=> "نسترن","key3" => "ron", "key4" => "rinki","key5" => "オウガ ");

$response = $bytesviewapiObj->name_gender_api($data);

var_dump($response);