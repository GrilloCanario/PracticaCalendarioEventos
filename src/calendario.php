<?php
namespace Dsw\CalendarioEvento;

require_once __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;
use Dompdf\Dompdf;

class Calendario
{
    private array $eventos;
    private Carbon $ahora;

    public function __construct(array $eventos)
    {
        $this->eventos = $eventos;
        $this->ahora = Carbon::now();
    }

    public function generar(string $formato, ?string $fechaInicio = null, ?string $fechaFin = null)
{
    $formato = strtolower($formato);

    switch ($formato) {
        case 'html':
            return $this->generarHTML();
        case 'pdf':
            return $this->generarPDF($fechaInicio, $fechaFin);
        case 'csv':
            return $this->generarCSV();
        default:
            return $this->generarHTML();
    }
}


    private function generarHTML()
    {
        // Construir el HTML directamente en una variable
        $html = '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Calendario de Eventos</title>
                <style>
                    .evento-pasado {
                        text-decoration: line-through;
                        background-color: #f0f0f0;
                        color: #999;
                    }

                    .evento-futuro {
                        background-color: #e8f5e8;
                    }

                    .evento-hoy {
                        background-color: #fff3cd;
                        font-weight: bold;
                    }

                    table {
                        border-collapse: collapse;
                        width: 100%;
                        margin: 20px 0;
                    }

                    th,
                    td {
                        border: 1px solid #ddd;
                        padding: 12px;
                        text-align: left;
                    }

                    th {
                        background-color: #f2f2f2;
                    }

                    .tiempo-faltante {
                        color: #666;
                    }
                </style>
            </head>
            <body>
                <h1>Calendario de Eventos</h1>
                <p><strong>Fecha y hora actual:</strong> ' . $this->ahora->format('d/m/Y H:i:s') . '</p>

                <table>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Tiempo faltante</th>
                        <th>Ponente</th>
                    </tr>';

        foreach ($this->eventos as $evento) {
            $fechaEvento = $evento->getFecha();
            $tiempoFaltante = $this->obtenerTiempoFaltante($fechaEvento);
            $claseCSS = $this->obtenerClaseCSS($fechaEvento);

            $html .= '
                    <tr class="' . $claseCSS . '">
                        <td>' . htmlspecialchars($evento->getTitulo()) . '</td>
                        <td>' . htmlspecialchars($evento->getDescripcion()) . '</td>
                        <td>' . $fechaEvento->format('d/m/Y H:i') . '</td>
                        <td class="tiempo-faltante">' . $tiempoFaltante . '</td>
                        <td>' . $evento->getPonente()->getTitulo() . ' ' . $evento->getPonente()->getNombre() . ' ' . $evento->getPonente()->getApellido() . '</td>
                    </tr>';
        }

        $html .= '
                </table>
            </body>
            </html>';

        // Devolver el HTML como variable
        return $html;
    }

    private function generarPDF(?string $fechaInicio = null, ?string $fechaFin = null)
{
    $dompdf = new Dompdf();
    $dompdf->loadHtml($this->generarHTML());
    $dompdf->setPaper('A4');
    $dompdf->render();

    $nombreArchivo = 'calendario-eventos';
    if ($fechaInicio && $fechaFin) {
        $nombreArchivo .= '-' . $fechaInicio . '-to-' . $fechaFin;
    }
    $nombreArchivo .= '.pdf';

    // Importante: limpiar el buffer antes de enviar headers
    if (ob_get_length()) {
        ob_end_clean();
    }

    $dompdf->stream($nombreArchivo, ['Attachment' => true]);
}

    private function generarCSV()
    {

        // Crear CSV con punto y coma como separador
        // \n para saltos de línea
        $csv = "Título;Descripción;Fecha;Tiempo Faltante;Ponente;";

        foreach ($this->eventos as $evento) {
            // Obtener los datos del evento
            $fechaEvento = $evento->getFecha();
            $tiempoFaltante = $this->obtenerTiempoFaltante($fechaEvento);
            $ponente = $evento->getPonente()->getTitulo() . ' ' .
                $evento->getPonente()->getNombre() . ' ' .
                $evento->getPonente()->getApellido();

            // borrar saltos de linea y puntos y comas para evitar romper el formato CSV
            // Reemplazar \n, \r y ; por espacio o coma
            // \n y \r son saltos de línea, ; por , ya que es el separador del CSV,
            // str_replace busca y reemplaza en una cadena - str_replace([buscar], [reemplazar], cadena)
            $titulo = str_replace(["\n", "\r", ";"], [" ", " ", ","], $evento->getTitulo());
            $descripcion = str_replace(["\n", "\r", ";"], [" ", " ", ","], $evento->getDescripcion());
            $ponenteLimpio = str_replace(["\n", "\r", ";"], [" ", " ", ","], $ponente);

            // Añadir líneas al CSV
            $csv .= $titulo . ';';
            $csv .= $descripcion . ';';
            // format para dar formato dd/mm/YYYY HH:ii
            $csv .= $fechaEvento->format('d/m/Y H:i') . ';';
            $csv .= $tiempoFaltante . ';';
            $csv .= $ponenteLimpio . ";\n";
        }

        echo $csv;
    }

    // Función para obtener el tiempo faltante
    function obtenerTiempoFaltante($fechaEvento)
    {
        // Calcular la diferencia en minutos usando Carbon
        // Si es positivo, el evento es en el futuro
        // Si es negativo, el evento ya pasó
        // Al final se usa true para que devuelva el valor normal. Si se pone false devuelve negativo para eventos futuros y positivos para eventos pasados
        $diferencia = $fechaEvento->diffInMinutes($this->ahora, false);

        // Determinar si el evento es en el futuro, pasado o actual
        // abs para valores absolutos y evitar negativos
        // Si $diferencia = -120, con abs($diferencia) = 120, pudiendo calcular las horas como 120/60 = 2 horas
        // Sin abs(): -120/60 = -2 
        // Despues en el if interno se compara si es negativo o positivo sin abs() para saber si es futuro o pasado
        if (abs($diferencia) < 5) {
            // menos de 5 minutos
            return "Empezando...";
        } elseif (abs($diferencia) < 60) {
            // menos de 60 minutos
            $minutos = abs($diferencia);
            if ($diferencia > 0) {
                // round() para evitar decimales. Si no saldria: "En 10.5455132 minutos". 
                //La parte final es simplemente para añadir el plural o el singular, sobra.
                return "En " . round($minutos) . " minuto" . ($minutos != 1 ? "s" : "");
                // versión corta:
                // return "En " . $minutos . " minutos";
            } else {
                return "Hace " . round($minutos) . " minuto" . ($minutos != 1 ? "s" : "");
            }
        } elseif (abs($diferencia) < (60 * 24)) {
            // menos de 24 horas
            $horas = round(abs($diferencia) / 60);
            if ($diferencia > 0) {
                return "En " . $horas . " hora" . ($horas != 1 ? "s" : "");
            } else {
                return "Hace " . $horas . " hora" . ($horas != 1 ? "s" : "");
            }
        } elseif (abs($diferencia) < (60 * 24 * 7)) {
            // menos de 7 días
            $dias = round(abs($diferencia) / (60 * 24));
            if ($diferencia > 0) {
                return "En " . $dias . " día" . ($dias != 1 ? "s" : "");
            } else {
                return "Hace " . $dias . " día" . ($dias != 1 ? "s" : "");
            }
        } elseif (abs($diferencia) < (60 * 24 * 30)) {
            // menos de 30 días
            $semanas = round(abs($diferencia) / (60 * 24 * 7));
            if ($diferencia > 0) {
                return "En " . $semanas . " semana" . ($semanas != 1 ? "s" : "");
            } else {
                return "Hace " . $semanas . " semana" . ($semanas != 1 ? "s" : "");
            }
        } else {
            // Más de 30 días
            $meses = round(abs($diferencia) / (60 * 24 * 30));
            if ($diferencia > 0) {
                return "En " . $meses . " mes" . ($meses != 1 ? "es" : "");
            } else {
                return "Hace " . $meses . " mes" . ($meses != 1 ? "es" : "");
            }
        }
    }

    // Diferenciar clase CSS según la fecha del evento
    function obtenerClaseCSS($fechaEvento)
    {
        // Si el evento es en el futuro, pasado o hoy
        // Usar métodos de Carbon isPast() e isSameDay()
        // isSameDay() compara solo la fecha con el día actual.
        // isPast() devuelve true si la fecha es anterior a la actual
        if ($fechaEvento->isSameDay($this->ahora)) {
            return "evento-hoy";
        } elseif ($fechaEvento->isPast()) {
            return "evento-pasado";
        } else {
            return "evento-futuro";
        }
    }
}