<?php
include("../include/inc_sesion_existe.phtml");
include('../clases/class.php');
$oficinaControl = new OficinaControl();
switch ($_GET['param']) {
    case -1:

        // Verifica que la oficina este configurada True o no False
        if ($oficinaControl->verficarOficina($_GET['id_oficina'])) {
            echo json_encode($oficinaControl->enabledOficina($_GET['id_oficina']));
        } else {
            echo json_encode($oficinaControl->getOficinaById($_GET['id_oficina']));
        }

        break;
    case 2:

        $nombre = $_REQUEST['nombre'];
        $direccion = $_REQUEST['direccion'];
        $telefono = $_REQUEST['telefono'];
        $correo = $_REQUEST['correo'];
        $nombre_contacto = $_REQUEST['nombre_contacto'];
        $oficinaControl->addOficina($nombre, $direccion, $telefono, $correo, $nombre_contacto);
        break;
    case 3:
        $id = $_REQUEST['id'];
        $nombre = $_REQUEST['nombre'];
        $direccion = $_REQUEST['direccion'];
        $telefono = $_REQUEST['telefono'];
        $correo = $_REQUEST['correo'];
        $nombre_contacto = $_REQUEST['nombre_contacto'];
        $oficinaControl->updateOficina($id, $nombre, $direccion, $telefono, $correo, $nombre_contacto);
        break;
    case 4:

        $parroquia = $_GET['parroquia'];
        $id_oficina = $_GET['id_oficina'];
        $cant_citas_tit = $_GET['cant_citas_tit'];
        $cant_citas_apo = $_GET['cant_citas_apo'];
        $claveweb = $_GET['claveweb'];
        $cant_taq_tit = $_GET['cant_taq_tit'];
        $cant_taq_apo = $_GET['cant_taq_apo'];
        $pantallatexto = $_GET['pantallatexto'];
        $feriados = $_GET['feriados'];
        $estatus = $_GET['estatus'];
        $horario1 = $_GET['horario1'];
        if ($oficinaControl->verficarOficina($_GET['id_oficina'])) {
            $tipo = 1;
        } else {
            $tipo = 0;
        }
        echo json_encode($oficinaControl->configurarOficina($parroquia, $id_oficina, $cant_citas_tit, $cant_citas_apo, $claveweb, $cant_taq_tit, $cant_taq_apo, $pantallatexto, $feriados, $estatus, $horario1, $tipo));
        break;
    case 5:
        $id = $_GET['id'];
        $geo = $oficinaControl->listarGeograficoCombo($id);
        echo "<option value=\"1\">Seleccione una opcion</option>";
        foreach ($geo as $key => $value) {
            echo "<option value=\"" . $value['id'] . "\">" . $value['nombre'] . "</option>";
        }
        break;
    case 6:

        // Verifica que la oficina este configurada True o no False
        if ($oficinaControl->verficarOficina($_GET['id_oficina'])) {
            echo json_encode(object_to_array($oficinaControl->getOficinaById($_GET['id_oficina'])));
        } else {
            echo false;
        }

        break;
    default:
//        $result= $oficinas->listarOficinas();
        echo json_encode($oficinaControl->listarOficinasGrid());
        break;
}

function object_to_array($data) {
    if (is_array($data) || is_object($data)) {
        $result = array();

        foreach ($data as $key => $value) {
            $result[$key] = object_to_array($value);
        }

        return $result;
    }

    return $data;
}

?>
