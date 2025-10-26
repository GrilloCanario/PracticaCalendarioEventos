<?php
namespace Dsw\CalendarioEvento;
require_once '../vendor/autoload.php';

class Ponente {
    public function __construct(
        private string $titulo,
        private string $nombre,
        private string $apellido
    ) {}

    public function getTitulo(): string {
        return $this->titulo;
    }
    public function getNombre(): string {
        return $this->nombre;
    }
    public function getApellido(): string {
        return $this->apellido;
    }
}