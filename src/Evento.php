<?php
namespace Dsw\CalendarioEvento;

require_once '../vendor/autoload.php';


class Evento {

    private string $titulo;
    private string $descripcion;
    private \DateTime $fecha;
    private Ponente $ponente;

    public function __construct(string $titulo, string $descripcion, \DateTime $fecha, Ponente $ponente) {
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

    public function getFecha(): \DateTime {
        return $this->fecha;
    }

    public function getPonente(): Ponente {
        return $this->ponente;
    }
}