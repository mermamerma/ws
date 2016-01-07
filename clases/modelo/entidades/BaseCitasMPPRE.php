<?php

class BaseCitasMPPRE
{    
    /** @var int  */
    public $cedula;

    /** @var nacionalidad  */
    public $nacionalidad;
    
    /** @var string nombres  */
    public $nombres;
    
    /** @var string apellidos  */
    public $apellidos;
    
    /** @var date fecha_creacion  */
    public $fecha_creacion;

    /** @var date fecha_cita */
    public $fecha_cita;

    
    
    function __construct() {
        
    }
    function getCedula() {
        return $this->cedula;
    }

    function getNacionalidad() {
        return $this->nacionalidad;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getFecha_cita() {
        return $this->fecha_cita;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setNacionalidad($nacionalidad) {
        $this->nacionalidad = $nacionalidad;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setFecha_cita($fecha_cita) {
        $this->fecha_cita = $fecha_cita;
    }


    

}
