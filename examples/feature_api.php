<?php
require_once '../autoload.php';
require_once 'config.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

$data = array(
                "key1" => "This is probably one of the funniest films of the 1980's. Eddie Murphy does a fine job as con man Billy Ray and Dan Ackroyd is great as Louis."                
            );

$response = $bytesviewapiObj->feature_api($data);

var_dump($response);