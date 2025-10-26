<?php
require_once '../vendor/autoload.php';
require_once '../src/fake.php';
require_once '../src/Calendario.php';
use Dsw\CalendarioEvento\DatosFalsos;
use Dsw\CalendarioEvento\Calendario;

if($_POST) {
    $numPonentes = (int)$_POST['num-ponentes'];
    $numEventos = (int)$_POST['num-eventos'];
    $fechaInicio = $_POST['fecha-inicio'];
    $fechaFin = $_POST['fecha-final'];
    $formato = $_POST['formato'];

        // Crear instancia de la clase
    $generador = new DatosFalsos();
    // Generar los eventos
    $eventos = $generador->generarEventos($numEventos, $numPonentes, $fechaInicio, $fechaFin);

    // Generar los datos y el calendario
    $calendario = new Calendario($eventos);

    // Procesar según el formato solicitado
    echo $calendario->generar($formato, $fechaInicio, $fechaFin);
} else {
    echo "NO se ha recibido los datos del formulario";
}
?>