<?php

$server->register("Citas.ping",
    array(),
    array("return" => "xsd:string"),
    "{$ns}",
    "",
    "",
    "",
    "Metodo para verificar que el WS este activo, devuleve 'OK' en caso de estar activo"
);
    
$server->register("Citas.getSolicitante",
    array("nacionalidad" => "xsd:string", "cedula" => "xsd:string"),
    array("return" => "tns:SolicitanteInfo"),
    "{$ns}",
    "",
    "",
    "",
    "Obtiene los datos de un solicitante en especifico. Recibe la nacionalidad {V,E,P} y numero de cedula o pasaporte"
);
    
$server->register("Citas.getCitasActivas",
    array("fecha_cita" => "xsd:string"),
    array("return" => "tns:ArrayCitasActivas"),
    "{$ns}",
    "",
    "",
    "",
    "Devuelve las citas activas de los solicitantes. Recibe la fecha de la cita en formato YYYY-mm-dd"
);
    
$server->register("Citas.getCitasCanceladas",
    array("fecha_cancelacion" => "xsd:string"),
    array("return" => "tns:ArrayCitasCanceladas"),
    "{$ns}",
    "",
    "",
    "",
    "Devuelve las citas activas de los solicitantes. Recibe la fecha de cancelacion en formato YYYY-mm-dd"
);
    
$server->wsdl->addComplexType(
    'SolicitanteInfo',
    'complextType',
    'struct',
    'all',
    '',
    array(
        'nacionalidad'      => array('nacionalidad'     => 'nacionalidad', 'type' => 'xsd:string'),
        'cedula'            => array('cedula'           => 'cedula', 'type' => 'xsd:string'),
        'nombres'           => array('nombres'          => 'nombres', 'type' => 'xsd:string'),
        'apellidos'         => array('apellidos'        => 'apellidos', 'type' => 'xsd:string'),
        'fecha_creacion'    => array('fecha_creacion'   => 'fecha_creacion', 'type' => 'xsd:string'),
        'fecha_cita'        => array('fecha_cita'       => 'fecha_cita', 'type' => 'xsd:string')
    )
); 

$server->wsdl->addComplexType('ArrayCitasActivas',
                              'complexType',
                              'array',
                              '',
                              'SOAP-ENC:Array',
                              array(),
                              array(array('ref' => 'SOAP-ENC:arrayType',
                              'wsdl:arrayType' => 'xsd:SolicitanteInfo[]')),'SolicitanteInfo'); 

$server->wsdl->addComplexType(
    'CitasCanceladas',
    'complextType',
    'struct',
    'all',
    '',
    array(
        'nacionalidad'      => array('nacionalidad'         => 'nacionalidad', 'type' => 'xsd:string'),
        'cedula'            => array('cedula'               => 'cedula', 'type' => 'xsd:string'),
        'nombres'           => array('nombres'              => 'nombres', 'type' => 'xsd:string'),
        'apellidos'         => array('apellidos'            => 'apellidos', 'type' => 'xsd:string'),
        'fecha_cancelacion' => array('fecha_cancelacion'    => 'fecha_cancelacion', 'type' => 'xsd:string'),
        'fecha_cita'        => array('fecha_cita'           => 'fecha_cita', 'type' => 'xsd:string')
    )
); 

$server->wsdl->addComplexType('ArrayCitasCanceladas',
                              'complexType',
                              'array',
                              '',
                              'SOAP-ENC:Array',
                              array(),
                              array(array('ref' => 'SOAP-ENC:arrayType',
                              'wsdl:arrayType' => 'xsd:CitasCanceladas[]')),'CitasCanceladas'); 