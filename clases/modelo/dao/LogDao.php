<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LogDao
{
    
    private $db;
    
    var $soapaction = '';
    var $username   = '';
    var $password   =  '';    


    function __construct() {
        if (isset($_SERVER['HTTP_SOAPACTION'])) 
            $this->soapaction = $_SERVER['HTTP_SOAPACTION'] ;
        elseif (isset($HTTP_SERVER_VARS['HTTP_SOAPACTION'])) 
            $this->soapaction = $HTTP_SERVER_VARS['HTTP_SOAPACTION'] ;
        else 
            $this->soapaction = '' ;
        
        if(isset($_SERVER['PHP_AUTH_USER']))
            $this->username = $_SERVER['PHP_AUTH_USER'] ;
        
        if(isset($_SERVER['PHP_AUTH_PW']))
            $this->password = $_SERVER['PHP_AUTH_PW'] ;            

        $this->db = new pgsql();
    }
    
    function register($header) {            
        if($this->soapaction != '') {              
            $fecha      = date('Y-m-d H:i:s');
            $ip         = getIpCliente();
            $metodo     = $this->soapaction ;
            $sql        = "INSERT INTO bitacora_ws (fecha,metodo,ip,detalle) VALUES ('$fecha','$metodo','$ip','$header')";
            $this->db->setQuery($sql);
        }
    }
    
    function registerBadLogin($detalle = '') {
        if($this->soapaction != '') {
            $detalle    = "Error en credenciales. Usuario:$this->username Contraseña:$this->password";
            $fecha      = date('Y-m-d H:i:s');
            $ip         = getIpCliente(); 
            $metodo     = $this->soapaction ;
            $sql        = "INSERT INTO bitacora_ws (fecha,metodo,ip,detalle) VALUES ('$fecha','$metodo','$ip','$detalle')";
            $this->db->setQuery($sql);
        }
    }
}
    
