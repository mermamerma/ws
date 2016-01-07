<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include ('./clases/class.pgsql.php');
include ('./clases/modelo/entidades/BaseCitasMPPRE.php');

class BaseCitasMPPREDao
{
    
    private $db;

    function __construct() {

        $this->db = new pgsql();
    }
    
    function listarSolicitantes()
    {
        $sql = "SELECT cedula, fecha_nac, nacionalidad FROM solicitantes LIMIT 2";
        $this->db->setQuery($sql);
        $SemillaMPPREarray = array();
        while ($row = $this->db->getFetch_Array()) {

            $SemillaMPPRE = new SemillaMPPRE_MPPEUCT();
            $SemillaMPPRE ->setCedula($row['cedula']);
            $SemillaMPPRE ->setFecha_cita($row['fecha_nac']);
            $SemillaMPPRE ->setTipo_solicitante($row['nacionalidad']);
            array_push($SemillaMPPREarray, $SemillaMPPRE);
        }

        return $SemillaMPPREarray;
    }
    
    function getSolicitante($nacionalidad, $cedula) {
        $sql = " SELECT * FROM v_citas_activas WHERE nacionalidad = '$nacionalidad' AND cedula = '$cedula' ORDER BY fecha_cita DESC LIMIT 1 ";
        #die($sql) ;
        $this->db->setQuery($sql);
        $num_rows = $this->db->getNumRows() ;
        $emptyArr = array();
        if ($num_rows >= 1) {
            $row  = $this->db->getFetch_Object() ;            
            return array('nacionalidad'  => $row->nacionalidad,
                        'cedula'         => $row->cedula,
                        'nombres'        => $row->nombres,
                        'apellidos'      => $row->apellidos,
                        'fecha_creacion' => $row->fecha_creacion,
                        'fecha_cita'     => $row->fecha_cita
                        );
        } 
        return $emptyArr;
    } 
    function getCitasActivas($fecha) {        
        $sql = "SELECT * FROM v_citas_activas WHERE fecha_cita >= '$fecha' LIMIT 3 " ;
        #die($sql) ;
        $this->db->setQuery($sql);
        $num_rows = $this->db->getNumRows() ;
        $resultArr = array();         
        while ($row = $this->db->getFetch_Object()) {             
            $resultArr [] = array(
                'nacionalidad'  => $row->nacionalidad,
                'cedula'         => $row->cedula,
                'nombres'        => $row->nombres,
                'apellidos'      => $row->apellidos,
                'fecha_creacion' => $row->fecha_creacion,
                'fecha_cita'     => $row->fecha_cita);                      
        }
        return $resultArr ;
    }
    
    function getCitasCanceladas($fecha) {        
        $sql = "SELECT * FROM v_citas_canceladas WHERE fecha_cancelacion >= '$fecha' LIMIT 3 " ;
        #die($sql) ;
        $this->db->setQuery($sql);
        $num_rows = $this->db->getNumRows() ;
        $resultArr = array();         
        while ($row = $this->db->getFetch_Object()) {             
            $resultArr [] = array(
                'nacionalidad'      => $row->nacionalidad,
                'cedula'            => $row->cedula,
                'nombres'           => $row->nombres,
                'apellidos'         => $row->apellidos,
                'fecha_cancelacion' => $row->fecha_cancelacion,
                'fecha_cita'        => $row->fecha_cita);                      
        }
        return $resultArr ;
    }
    
}