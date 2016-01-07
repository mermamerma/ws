<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SemillaMPPRE_MPPEUCT 
{    
    /** @var int  */
    public $cedula;

    /** @var date  */
    public $fecha_cita;

    /** @var string  */
    public $tipo_solicitante;
    
    function __construct() {
        
    }
    
    function getCedula() {
        return $this->cedula;
    }

    function getFecha_cita() {
        return $this->fecha_cita;
    }

    function getTipo_solicitante() {
        return $this->tipo_solicitante;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setFecha_cita($fecha_cita) {
        $this->fecha_cita = $fecha_cita;
    }

    function setTipo_solicitante($tipo_solicitante) {
        $this->tipo_solicitante = $tipo_solicitante;
    }

}