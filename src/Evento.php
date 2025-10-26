<?php
namespace Dsw\CalendarioEvento;

require_once __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

class Evento {

    private string $titulo;
    private string $descripcion;
    private Carbon $fecha;
    private Ponente $ponente;

    public function __construct(string $titulo, string $descripcion, Carbon $fecha, Ponente $ponente) {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->ponente = $ponente;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

     public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function getFecha(): Carbon {
        return $this->fecha;
    }

    public function getPonente(): Ponente {
        return $this->ponente;
    }
}