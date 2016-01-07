<?php
include("../include/inc_sesion_existe.phtml");
include('../clases/class.php');


$usuarioControl = new UsuarioControl();
$opcionControl = new OpcionControl();

switch ($_GET['param']) 
{     
    case 2:
        $usuario    = $_REQUEST['usuario'];
        $nombre     = $_REQUEST['nombre'];
        $apellido   = $_REQUEST['apellido'];
        $inicial    = $_REQUEST['inicial'];  
        $activo     = 'N';        
        $bandera = $usuarioControl->insertUsuario($usuario, $clave, $nivel, $nombre, $apellido, $activo, $inicial, $id_taquilla, $web, $oficina_id);        
        
        break;
    case 3:
        $id         = $_REQUEST['id'];
        $usuario    = $_REQUEST['usuario'];
        $nombre     = $_REQUEST['nombre'];
        $apellido   = $_REQUEST['apellido'];
        $inicial    = $_REQUEST['inicial']; 
        $usuarioControl->updateUsuario($id, $usuario, $nivel, $nombre, $apellido, $activo, $inicial, $id_taquilla, $web);
        break;
    case 4:
        $resultado = $usuarioControl->resetClaveUsuario($_GET['id_usuario'], $_GET['usuario']); 
        echo $resultado;
        break;
    case 5:
        $id = $_GET['id'];
        $geo = $oficinaControl->listarGeograficoCombo($id);                
        echo "<option value=\"1\">Seleccione una opcion</option>";
        foreach ($geo as $key => $value) {
            echo "<option value=\"" . $value['id'] . "\">" . $value['nombre'] . "</option>";
        }
        break;
    case 6: /*Activar o Desactivar Usuario*/        
        $resultado = false;
        //$usuarios = new UsuarioControl();
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
        //echo $resultado;
        break;
     case 7:         
        //$usuarios = new UsuarioControl();
        $resultado = $usuarioControl->completarUpdateUsuario($_GET['id_usuario'], $_GET['taquilla'], $_GET['web'], $_GET['nivel'], $_GET['oficina'], $_GET['activo']);
        if($resultado)
        {
            $usuarioControl->elimRolesUsuario($_GET['id_usuario']);
            $resultado = $usuarioControl->asigRolesUsuario($_GET['id_usuario']);
        }        
        echo $resultado;
        break;
     case 8:       
        $rolesUsuarios = $opcionControl->listarOpciones($_GET['id_usuario']);  
        $resultado = $rolesUsuarios;
        echo $resultado;
        break;   
    case 9:       
//      $usuarioControl->elimRolesUsuario($_GET['id_usuario']);
        $resultado = $usuarioControl->asigRolesUsuario($_GET['id_usuario']);
        echo $resultado;
        break;
    case 10:       
        $resultado = $usuarioControl->listarUsuariosID($_GET['id_usuario']);
        //$v = json_encode(object_to_array($resultado));
        echo json_encode($resultado);
        break;
    default:
        echo json_encode($usuarioControl->listarUsuariosGrid());    
        break;
}
?>