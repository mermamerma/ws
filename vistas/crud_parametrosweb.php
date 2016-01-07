<?php

include('../clases/class.php');
$pControl = new ParametrosWebControl();
switch ($_GET['param']) {
    case 1:
        $id = $_GET['id'];
        $horario = $_GET['horario'];
        $dia_nocita = $_GET['dia_nocita'];
        $maxdoctitular = $_GET['maxdoctitular'];
        $maxdocapoderado = $_GET['maxdocapoderado'];
        $diasmostrar = $_GET['diasmostrar'];
        $diasmaximo = $_GET['diasmaximo'];
        $dias_recordarcitas = $_GET['dias_recordarcitas'];
        $maxcitas_porapoderado = $_GET['maxcitas_porapoderado'];
        $mincitas_titular = $_GET['mincitas_titular'];
        $mincitas_apoderado = $_GET['mincitas_apoderado'];
        $pControl->updateParametrosWeb($id, $horario1, $dia_nocita, $maxdoctitular, $maxdocapoderado, $diasmostrar, $fecha_activo, $diasmaximo, $dias_recordarcita, $maxcitas_porapoderado, $mincitas_titular, $mincitas_apoderado);
        break;

    default:


//        $result= $oficinas->listarOficinas();


        break;
}
?>