<?php
namespace Dsw\CalendarioEvento; // Definir el namespace

use Carbon\Carbon; // Importar la clase Carbon
use Dsw\CalendarioEvento\Evento; // Importar la clase Evento
use Dsw\CalendarioEvento\Ponente; // Importar la clase Ponente
require '../vendor/autoload.php';

// -- PRUEBA -- Creo datos de prueba para ver que tal --
$events = [];
$ponentePrueba = new Ponente('Dr', 'Nombre', 'Apellido');
$events[] = new Evento("Evento de Prueba", "Descripción del evento de prueba", new \DateTime('2024-12-25'), $ponentePrueba); // añadido evento de prueba
$events[] = new Evento("Conferencia Tech", "Una conferencia sobre las últimas tendencias en tecnología.", new \DateTime('2024-11-15'), $ponentePrueba); //añadido otro evento para probar si funciona el foreach
$events[] = new Evento("Seminario de Salud", "Seminario enfocado en la salud y el bienestar.", new \DateTime('2025-12-10'), $ponentePrueba); //añadido otro evento para ver si funciona el if del foreach de fechas
$today = Carbon::now(); //variable para la fecha actual, por si se usa más de una vez
//-- PRUEBA FIN --


if($_POST){ //comprueba si se han recibido los datos del formulario (prueba)
    $numPonentes = (int)$_POST['num-ponentes'];
    echo "Número de ponentes: " . $numPonentes . "<hr>";
    $numEventos = (int)$_POST['num-eventos'];
    echo "Número de eventos: " . $numEventos . "<hr>";
    $fechaInicio = $_POST['fecha-inicio'];
    echo "Fecha de inicio: ".  "<hr>";
    $fechaFin = $_POST['fecha-final'];
    echo "Fecha de finalización: " . $fechaFin . "<hr>";
    $formato = $_POST['formato'];
    echo "Formato del evento: " . $formato . "<hr>";
    
} else { //si no se han recibido los datos del formulario pasa esto
    echo "NO se ha recibido los datos del formulario";
}

echo "<br><hr><ul>";
//foreach para mostrar los eventos creados (prueba)
foreach($events as $event) { 
    echo "<h1>Evento: </h1>";   
    $eventDate = Carbon::instance($event->getFecha()); //usamos getFecha para obtener la fecha del evento y lo guardamos en una variable
    $datestring = $event->getFecha()->format('Y-m-d');

    // Mostrar detalles del evento + ponentes (solo sería hacer un foreach para ponentes creo)
    echo "<li> <b>Título del evento:</b> ". $event->getTitulo() .", <b>Descripción del evento:</b> ". $event->getDescripcion() . ", <b>Fecha del evento:</b> ". $datestring . ", <b>Ponentes:</b> ". $ponentePrueba->getTitulo() . " " . $ponentePrueba->getNombre() . " " . $ponentePrueba->getApellido() .  "</li>";

    if ($eventDate->greaterThan($today)) { //si la fecha del evento es mayor que la fecha actual pasa eso
        $dias = $today->diffInDays($eventDate);
        echo "El evento ocurre en " . round($dias) . " días<hr>";

    } else {//si no pasa esto
        $dias = $eventDate->diffInDays($today);
        echo "El evento ocurrió hace " . round($dias) . " días<hr>";

    }
}
echo "<br></ul><hr>";

