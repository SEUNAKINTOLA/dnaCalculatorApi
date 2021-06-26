<?php
       require_once ('./ServiceRequest.php');
         
     //   ini_set("display_errors","on");
    
        $method        = strtolower($_SERVER['REQUEST_METHOD']);
        $protocol      = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        $headers       = apache_request_headers();
        $req           = $_REQUEST;
        
        $url           = '';
        
        $request       = array(
                                'method'=>$method,
                                'protocol'=>$protocol,
                                'headers'=>$headers,
                                'req'=>$req,
                                );
        $services      = new ServiceRequest($request);
        
        echo $services->response();
         
?>