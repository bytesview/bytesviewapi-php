<?php 
declare(strict_types=1);

namespace BytesviewApi;

class BytesviewApiBase {
    
    /**
     * Bytesview API Host
     * 
     * @var string
     */
    private const API_HOST          =   'https://api.bytesview.com/';
    
    /**
     * Bytesview API Base Path
     * 
     * @var string
     */
    private const API_BASE_PATH     =   '/static';

    /**
     * Current Version of Bytesview API
     * 
     * @var string
     */    
    private const API_VERSION       =   '1';
    
    /**
     * Response details about the result of the last request
     *
     * @var Object
     */
    private $response;
    
    /**
     * Number of attempts we made for the request
     *
     * @var int
     */
    private $attempts = 0;
    
    /** 
     * How long to wait for a response from the API
     * @var int 
     */
    protected $timeout = 60;
    
    /**
     * How long to wait while connecting to the API
     * @var int
     */
    protected $connectionTimeout = 120;
    
    /**
     * How many times we retry request when API is down
     * @var int
     */
    protected $maxRetries = 0;
    
    /** 
     * Delay in seconds before we retry the request
     * @var int
     */
    protected $retriesDelay = 1;
    
    /**
     * Decode JSON Response as associative Array
     * @var bool
     */
    protected $decodeJsonAsArray = false;
    
    /** 
     * Store proxy connection details 
     * @var array
     */
    protected $proxy = [];
    
    public function __construct()
    {
        $this->_resetLastResponse();
    }
    
    private function _resetLastResponse(): void
    {
        $this->response = new Response();
    }
    
    private function _getLastHttpCode(): int
    {
        return $this->response->getHttpCode();
    }
    
    /**
     * Delays the retries when they're activated.
     */
    private function _sleepIfNeeded(): void
    {
        if ($this->maxRetries && $this->attempts) {
            sleep($this->retriesDelay);
        }
    }
    
    /**
     * Decodes a JSON string to stdObject or associative array
     *
     * @param string $string
     * @param bool   $asArray
     *
     * @return array|object
     */
    private function _j_decode(string $string, bool $asArray)
    {
        if (
            version_compare(PHP_VERSION, '5.4.0', '>=') &&
            !(defined('JSON_C_VERSION') && PHP_INT_SIZE > 4)
            ) {
                return json_decode($string, $asArray, 512, JSON_BIGINT_AS_STRING);
            }
            
            return json_decode($string, $asArray);
    }
    
    /**
     * Resets the attempts number.
     *   
     */
    private function _resetAttemptsNumber(): void
    {
        $this->attempts = 0;
    }
    
    /**
     * Checks if we have to retry request if API is down.
     *
     * @return bool
     */
    private function _requestsAvailable(): bool
    {
        return $this->maxRetries && $this->attempts <= $this->maxRetries && $this->_getLastHttpCode() >= 500;
    }
    
    /**
     *
     * Make requests and retry them (if enabled) in case of BytesviewAPI problems.
     *
     * @param string $method
     * @param string $url
     * @param string $method
     * @param array  $parameters
     * @param bool   $json
     *
     * @return array|object
     */
    private function _makeRequests(string $url, string $method, array $parameters,string $api_key,bool $json) {
        do {
            $this->_sleepIfNeeded();
            $result = $this->_request($url, $method, $parameters,$api_key, $json);
            $response = $this->_j_decode($result, $this->decodeJsonAsArray);
            $this->response->setBody($response);
            $this->attempts++;
            
            // Retry up to our $maxRetries number if we get errors greater than 500 (over capacity etc)
            
        }while ($this->_requestsAvailable());
        
        return $response;
    }
    
    /**
     * Make an HTTP request
     *
     * @param string $url
     * @param string $method
     * @param string $authorization
     * @param array $postfields
     * @param bool $json
     *
     * @return string
     * @throws BytesviewAPIException
     */
    private function _request(string $url, string $method, array $postfields,string $api_key, bool $json = false): string 
    {
        $options                        =   $this->_curlOptions();
        $options[CURLOPT_URL]           =   $url;
        $options[CURLOPT_HTTPHEADER]    =   ['Accept: application/json','X-ACCESS-TOKEN: '.$api_key];
            
        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                $options[CURLOPT_POST] = true;
                if ($json) {
                    $options[CURLOPT_HTTPHEADER][]  =   'Content-type: application/json';
                    $options[CURLOPT_POSTFIELDS]    =   json_encode($postfields);
                } else {
                    $options[CURLOPT_POSTFIELDS]    =   Util::buildHttpQuery($postfields,);
                }
                break;
            case 'DELETE':
                $options[CURLOPT_CUSTOMREQUEST]     =   'DELETE';
                break;
            case 'PUT':
                $options[CURLOPT_CUSTOMREQUEST]     =   'PUT';
                break;
        }
            
        if (in_array($method, ['GET', 'PUT', 'DELETE']) && !empty($postfields) ) {
            $options[CURLOPT_URL]   .=  '?' . Util::buildHttpQuery($postfields);
        }
                
        $curlHandle     =   curl_init();
        curl_setopt_array($curlHandle, $options);
        
        $response       =   curl_exec($curlHandle);
                
        // Throw exceptions on cURL errors.
        if (curl_errno($curlHandle) > 0) {
            $error      =   curl_error($curlHandle);
            $errorNo    =   curl_errno($curlHandle);
            curl_close($curlHandle);
            throw new BytesviewAPIException($error, $errorNo);
        }
                
        $this->response->setHttpCode( curl_getinfo($curlHandle, CURLINFO_HTTP_CODE));
            
        $parts          =   explode("\r\n\r\n", $response);
        $responseBody   =   array_pop($parts);
        $responseHeader =   array_pop($parts);
        $this->response->setHeaders($this->_parseHeaders($responseHeader));
        
        curl_close($curlHandle);
        
        return $responseBody;
    }
    
    /**
     * Set Curl options.
     *
     * @return array
     */
    private function _curlOptions(): array
    {
        $options = [
            CURLOPT_CONNECTTIMEOUT  =>  $this->connectionTimeout,
            CURLOPT_HEADER          =>  true,
            CURLOPT_RETURNTRANSFER  =>  true,
            CURLOPT_SSL_VERIFYHOST  =>  2,
            CURLOPT_SSL_VERIFYPEER  =>  true,
            CURLOPT_TIMEOUT         =>  $this->timeout,
        ];
        
        if (!empty($this->proxy)) {
            $options[CURLOPT_PROXY]         =   $this->proxy['CURLOPT_PROXY'];
            $options[CURLOPT_PROXYUSERPWD]  =   $this->proxy['CURLOPT_PROXYUSERPWD'];
            $options[CURLOPT_PROXYPORT]     =   $this->proxy['CURLOPT_PROXYPORT'];
            $options[CURLOPT_PROXYAUTH]     =   CURLAUTH_BASIC;
            $options[CURLOPT_PROXYTYPE]     =   CURLPROXY_HTTP;
        }
        
        return $options;
    }
    
    
    /**
     * Get the header info to store.
     *
     * @param string $header
     *
     * @return array
     */
    private function _parseHeaders(string $header): array
    {
        $headers = [];
        foreach (explode("\r\n", $header) as $line) {
            if (strpos($line, ':') !== false) {
                [$key, $value] = explode(': ', $line);
                $key = str_replace('-', '_', strtolower($key));
                $headers[$key] = trim($value);
            }
        }
        return $headers;
    }
    
    /**
     * @param string $method
     * @param string $host
     * @param string $path
     * @param array  $parameters
     * @param bool   $json
     *
     * @return array|object
     */
    protected function http( string $method,string $url, array $parameters, string $api_key,bool $json ) {
        $this->_resetLastResponse();
        $this->_resetAttemptsNumber();
        $this->response->setApiPath($url);
        return $this->_makeRequests($url, $method, $parameters,$api_key,$json);
    }
    
    /**
     * GET Sentiment API Base URL
     * @return string
     */
    protected function SentimentApiURL():string
    {
        return self::API_HOST.self::API_VERSION.self::API_BASE_PATH.'/sentiment';
    }
    
    /**
     * GET EmotionAPI Base URL
     * @return string
     */
    protected function EmotionApiURL():string
    {
        return self::API_HOST.self::API_VERSION.self::API_BASE_PATH.'/emotion';
    }
    
    /**
     * GET Keyword API Base URL
     * @return string
     */
    protected function KeywordApiURL():string
    {
        return self::API_HOST.self::API_VERSION.self::API_BASE_PATH.'/keywords';
    }
    
    /**
     * GET Semantic API Base URL
     * @return string
     */
    protected function SemanticApiURL():string
    {
        return self::API_HOST.self::API_VERSION.self::API_BASE_PATH.'/semantic';
    }
    
    /**
     * GET NameGender API Base URL
     * @return string
     */
    protected function NameGenderApiURL():string
    {
        return self::API_HOST.self::API_VERSION.self::API_BASE_PATH.'/name-gender';
    }
    
    /**
     * GET NER API Base URL
     * @return string
     */
    protected function NERApiURL():string
    {
        return self::API_HOST.self::API_VERSION.self::API_BASE_PATH.'/ner';
    }
        
    /**
     * GET Intent API Base URL
     * @return string
     */
    protected function IntentApiURL():string
    {
        return self::API_HOST.self::API_VERSION.self::API_BASE_PATH.'/intent';
    }
}