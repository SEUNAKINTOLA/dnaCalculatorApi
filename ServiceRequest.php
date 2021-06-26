<?php 
class ServiceRequest {
        
       private $req = array(); // class member to serve as our request from the api. 
       private $method;
       private $code;
       private $text;
       private $url;
       private $curl = null;
       private $token;
       private $headers;
       private $protocol;
       public  $response = null;
       private $active_process = null;
       
       
       function __construct($arr = array() ){
           if (empty($arr)) return;
           //print_r($arr);
            $this->method    = isset($arr['method'])? $arr['method'] : '';
            $this->url       = '';//$url;
            $this->headers   = isset($arr['headers'])? $arr['headers'] : '';
            $this->protocol  = isset($arr['protocol'])? $arr['protocol'] : '';
            $this->req       = isset($arr['req'])? $arr['req'] : ''; 
            //var_dump($_POST);
            
            $this->_get_process();
            
       } 
       
       
       function _get_process(){
        
         if(isset($this->req['process']) && ($this->req['process'] != '')){
            ///var_dump($this->req['process']);
            switch($this->req['process']){
                 case'extractvalidgenes':
                  require_once('./ExtractValidGenes.php');
                  $this->active_process = new ExtractValidGenes($this->req);
                break;
                 default:
              }
         }
       }
       
       function response(){
         if( $this->active_process  == null )  return json_encode( array('message' => 'invalid api call') );
            $this->getRequestType($this->method,$this->headers, $this->req);
            
            return $this->_http_response_status($this->protocol, $this->code,$this->text,$this->response);
       }
       
       function getRequestType($method,$headers, $req) {
            $code           = 403;
            $msg            = 'Forbidden, No Authorization header!';
            $result         = array('error' => 'Server was unable to find the authorization header from this request.'); 
        
            if (!isset($headers['Authorization'])) return $this->validateToken('', $code,$msg, $result ); 
        
            preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches);
            $this->token = $matches[1];
            if ( $this->validateToken($this->token) === 1 ) {
                
                switch( $method ) {
                    case 'post':
                        $this->response = $this->active_process->post();
                        
                    break;
                    
                    case 'get': 
                        $this->response = $this->active_process->get();
                    break;
                }
            }
            else {
                $this->response = $this->validateToken($this->token) ;
            } 
            
       }
       
       private function save_user_det( $request ){
            if ( empty($request) ){
                $this->code       = 400;
                $this->text       = 'Bad Request';
                $response   = array('error' => 'REQUEST Body is Empty.');
                $this->response = $response;
                return ;
            } 
            $this->curl = curl_init();
            curl_setopt( $this->curl, CURLOPT_URL, $this->url );
            curl_setopt( $this->curl, CURLOPT_POST, true);
            curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt( $this->curl, CURLOPT_POSTFIELDS, $request );
            curl_setopt( $this->curl, CURLOPT_HTTPGET, 1);
            curl_setopt( $this->curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
            curl_setopt( $this->curl, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
            curl_setopt( $this->curl, CURLOPT_HEADER, 1);
            curl_setopt( $this->curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            curl_setopt( $this->curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($this->curl);
            if ($response == false) echo "error : ". curl_error($this->curl);
            curl_close($this->curl);
            $code = 200;
            $text = 'OK';
            return $this->_http_response_status($this->protocol, $code, $text, $response);
       }
       
       
       private function validateToken( $token, $code = '', $text = '', $result = array() ) {
            $this->token = trim($token);
            if ( empty( $this->token ) ){
              $this->response = $this->_http_response_status($this->protocol, $code, $text, $result);  
              return $this->response;
            } 
            
            $code   = 502;
            $text   = 'Bad Gateway';
            $result = array('error' => 'Server was unable to find the specified client in our whitelist of client! Token has been modified.');
            if (trim($token) !== '39109f7df56e1051c399e685066bb852') {
                $this->response = $this->_http_response_status($this->protocol, $code, $text, $result);
            }
            else{
                return 1;
            }
            
       }
       private function _http_response_status( $protocol, $code, $text, $result ) {
            header($protocol . ' ' . $code . ' ' . $text);
            return json_encode( array('result' => $result) );
       }
    }
?>