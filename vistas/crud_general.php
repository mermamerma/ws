<?php

include('../clases/class.php');


$oficinaControl = new OficinaControl();
$usuarioControl = new UsuarioControl();
$taquillaControl = new TaquillaDao();
switch ($_GET['param']) {
    
    case 1:
        $id = $_GET['id'];
        $geo = $oficinaControl->listarGeograficoCombo($id);
        echo "<option value=\"1\">Seleccione una opcion</option>";
        foreach ($geo as $key => $value) {
            echo "<option value=\"" . $value['id'] . "\">" . $value['nombre'] . "</option>";
        }
        break;
    case 2:
        $resultado = false;
       
        $datosUsuario = $usuarioControl->listarUsuariosID($_GET['id_usuario']);
        foreach ($datosUsuario AS $vUsuario => $valor)

        if($valor->getNIVEL() != 0 && $valor->getOFICINA_ID() != 0)
        {
           $resultado = $usuarioControl->bloqActivarUsuario($_GET['id_usuario'],$_GET['estado']);
           echo $resultado;
        } 
        else
        {
           echo $resultado;
        }
        break;
    case 3:
        $id = $_GET['id'];
        $geo = $oficinaControl->listarOficinasXIdActivas($id);
        echo "<option value=\"1\">Seleccione una opcion</option>";
        foreach ($geo as $key => $value) {
            echo "<option value=\"" . $value->ID . "\">" . $value->NOMBRE . "</option>";
        }
        break;
    case 4:
        $id = $_GET['id'];
        $geo = $taquillaControl->getTaquillasXIdOficina($id);
        echo "<option value=\"1\">Seleccione una opcion</option>";
        foreach ($geo as $key => $value) {
            echo "<option value=\"" . $value->getID() . "\">" . $value->getDESCRIPCION()." ". $value->getNU_TAQUILLA() . "</option>";
        }
        break;    
    default:
        break;
}
?>
