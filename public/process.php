<?php

if($_POST){
    $numPonentes = (int)$_POST['num-ponentes'];
    $numEventos = (int)$_POST['num-eventos'];
    $fechaInicio = $_POST['fecha-inicio'];
    $fechaFin = $_POST['fecha-final'];
    $formato = $_POST['formato'];
} else {
    echo "NO se ha recibido los datos del formulario";
}
?>