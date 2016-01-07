<?php

include './clases/modelo/dao/BaseCitasMPPREDao.php';


class Citas {
    public $dao;

    function __construct() {
        $this->dao = new BaseCitasMPPREDao();
    }    
    
    function ping() { 
        return('OK');
    }    
    
    function getSolicitante($nacionalidad,$cedula) {        
        return $this->dao->getSolicitante($nacionalidad,$cedula);
    }
    
    function getCitasActivas($fecha) {
        return $this->dao->getCitasActivas($fecha);
    }
    
    function getCitasCanceladas($fecha) {
        return $this->dao->getCitasCanceladas($fecha);
    }
    
}

