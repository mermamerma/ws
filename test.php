<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
include './clases/controlador/Citas.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $obj = new Citas();
        #$resultado = $obj->getSolicitante('V', '18581242');
        #$resultado = $obj->getCitasActivas("2016-03-01");
        $resultado = $obj->getCitasCanceladas("2015-11-12");  
        
        var_dump($resultado);
        ?>
    </body>
</html>
