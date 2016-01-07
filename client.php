<title>client</title>
<meta charset="utf-8">
<?php

require_once('clases/lib/nusoap.php');

ini_set("soap.wsdl_cache_enabled", "0");


$username = 'mppeuct';
$password = '123456';

$client = new nusoap_client("http://{$_SERVER['HTTP_HOST']}/ws/server.php?wsdl",'wsdl'); 
#$client = new nusoap_client("http://{$_SERVER['HTTP_HOST']}/ws/server.php?wsdl",false); 
$client->setCredentials($username, $password, 'basic');

#$client->soap_defencoding = 'UTF-8';
#$client->decode_utf8 = false;

$result = $client->call('Citas.ping',array());    
#$result = $client->call('Citas.getSolicitante',array('nacionalidad' => 'V','cedula' => '18161508'));
#$result = $client->call('Citas.getCitasActivas',array('fecha_cita' => '2016-03-01'));
#$result = $client->call('Citas.getCitasCanceladas',array('fecha_cancelacion' => '2015-11-12'));
    
if ($client->fault) {
	echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
} else {
	$err = $client->getError();
	if ($err) {
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		echo '<h2>Resultado</h2><pre>'; 
                var_dump($result); echo '</pre>';
	}
}
echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';