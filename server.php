<?php

require_once('clases/controlador/Citas.php');
require_once('clases/lib/nusoap.php');
require_once('clases/modelo/dao/LogDao.php');
require_once('funciones.php');

$debug = 1;

$server     = new soap_server;
$header     = $server->requestHeaders;
$flag       = doAuthenticate();



if ($flag == FALSE)
    $server->fault(401,'Authentication failed!');
    
        
$file = basename($_SERVER['PHP_SELF']);
$ns="http://{$_SERVER['HTTP_HOST']}/ws/{$file}"; 

$server->configureWSDL("Web Service MPPRE-MPPEUCT",$ns);


#$server->soap_defencoding = 'UTF-8';
#$server->decode_utf8 = false;
#$server->encode_utf8 = true;

require_once('wsdl.php');



$obj    = new Citas();
$log    = new LogDao();
$log->register($header);

if($flag == FALSE)
    $log->registerBadLogin();


//Establecer servicio       
if (isset($HTTP_RAW_POST_DATA)) { 
  $input = $HTTP_RAW_POST_DATA; 
}else{ 
  $input = implode("rn", file('php://input')); 
} 
$server->service($input);