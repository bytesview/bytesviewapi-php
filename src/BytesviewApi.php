<?php
declare(strict_types=1);

namespace BytesviewApi;

class BytesviewApi extends BytesviewApiBase {
    
    private $_api_key       =   '';
    
    /**
     * 
     * @param string $api_key
     */
    function __construct(string $api_key){
        parent::__construct();
        $this->_api_key     =   $api_key;
    }
    
    /**
     * Set the connection and response timeouts.
     *
     * @param int $connectionTimeout
     * @param int $timeout
     */
    public function setTimeouts(int $connectionTimeout, int $timeout): void
    {
        $this->connectionTimeout = $connectionTimeout;
        $this->timeout = $timeout;
    }
    
    /**
     * Set the number of times to retry on error and how long between each.
     *
     * @param int $maxRetries
     * @param int $retriesDelay
     */
    public function setRetries(int $maxRetries, int $retriesDelay): void
    {
        $this->maxRetries = $maxRetries;
        $this->retriesDelay = $retriesDelay;
    }
    
    /**
     * @param bool $value
     */
    public function setDecodeJsonAsArray(bool $value): void
    {
        $this->decodeJsonAsArray = $value;
    }
    
    /**
     * @param array $proxy
     */
    public function setProxy(array $proxy): void
    {
        $this->proxy = $proxy;
    }
    
    public function get(string $url, array $parameters = [])
    {
        return $this->http('GET', $url, $parameters,$this->_api_key, false);
    }
    
    public function post(string $url, array $parameters = [], bool $json = false ) {
        return $this->http('POST', $url, $parameters,$this->_api_key, $json);
    }
    
    function sentiment_api($data,$lang = 'en')
    {
        $data   =   array('data' => $data, 'lang' => $lang);
        return $this->post($this->SentimentApiURL(),$data,true);
    }
    
    function emotion_api($data,$lang = 'en'){
        $data   =   array('data' => $data, 'lang' => $lang);
        return $this->post($this->EmotionApiURL(),$data,true);
    }
    
    function keywords_api($data,$lang = 'en'){
        $data   =   array('data' => $data, 'lang' => $lang);
        return $this->post($this->KeywordApiURL(),$data,true);
    }
    
    function semantic_api($data,$lang= 'en'){
        $data   =   array('data' => $data, 'lang' => $lang);
        return $this->post($this->SemanticApiURL(),$data,true);
    }
    
    function name_gender_api($data){
        $data   =   array('data' => $data);
        return $this->post($this->NameGenderApiURL(),$data,true);
    }
    
    function ner_api($data,$lang = 'en'){
        $data   =   array('data' => $data,'lang' => $lang);
        return $this->post($this->NERApiURL(),$data,true);
    }
    
    function intent_api($data,$lang = 'en'){
        $data   =   array('data' => $data,'lang'=>$lang);
        return $this->post($this->IntentApiURL(),$data,true);
    }
}