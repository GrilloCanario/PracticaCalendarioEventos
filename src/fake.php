<?php
namespace Dsw\CalendarioEvento;

use Faker\Factory;
use Faker\Generator;
use Carbon\Carbon;

class DatosFalsos {

    private Generator $faker;
    private array $titulos;
    private array $tiposEventos;
    private array $temas;

    public function __construct()
    {
        // Faker configurado en español
        $this->faker = Factory::create('es_ES');
        
        // Títulos académicos y profesionales
        $this->titulos = [
            "Dr.",
            "Dra.",
            "Ing.",
            "Lic.",
            "Tec.",
            "Prof.",
            "Sr.",
            "Sra.",
            "Mtro.",
            "Arq.",
            "PhD",
            "Coach",
            "Consultor",
            "Especialista",
            "Científico",
        ];

        // Tipos de eventos
        $this->tiposEventos = [
            "Conferencia sobre",
            "Seminario de",
            "Taller práctico de",
            "Mesa redonda sobre",
            "Charla motivacional acerca de",
            "Foro internacional de",
            "Clase magistral sobre",
            "Presentación de proyecto de",
            "Webinar acerca de",
            "Hackathon de",
            "Workshop de",
            "Panel de expertos en",
            "Jornada técnica de",
            "Simposio sobre",
            "Bootcamp de",
        ];

        // Temas de eventos
        $this->temas = [
            "Inteligencia Artificial",
            "Desarrollo Web Moderno",
            "Ciberseguridad y Privacidad",
            "Blockchain y Criptomonedas",
            "Computación en la Nube",
            "Diseño de Interfaces y UX",
            "Internet de las Cosas (IoT)",
            "Machine Learning para principiantes",
            "Robótica Educativa",
            "Programación en Python",
            "Optimización del Rendimiento Web",
            "Automatización de Procesos",
            "Ética en la Tecnología",
            "Gestión de Proyectos Ágiles",
            "Bases de Datos NoSQL",
            "Metodologías DevOps",
            "Realidad Virtual y Aumentada",
            "Ciencia de Datos Aplicada",
            "Arquitectura de Software",
            "Testing y Calidad del Código",
        ];
    }
    
    // Genera un array de ponentes falsos
    public function generarPonentes(int $ponenteNumber): array
    {
        $ponentes = [];
        for ($i = 0; $i < $ponenteNumber; $i++) {
            $ponentes[] = new Ponente(
                titulo:     $this->faker->randomElement($this->titulos),
                nombre:     $this->faker->firstName(),
                apellido:   $this->faker->lastName()
            );
        }
        return $ponentes;
    }

    // Genera un array de eventos falsos
    public function generarEventos(int $eventNumber, int $ponenteNumber, string $fechaInicio, string $fechaFin): array
    {
        // Generar ponentes
        $ponentes = $this->generarPonentes($ponenteNumber);

        $eventos = [];
        for ($i = 0; $i < $eventNumber; $i++) {
            $fechaInicioCarbon = Carbon::createFromFormat('Y-m-d', $fechaInicio);
            $fechaFinCarbon = Carbon::createFromFormat('Y-m-d', $fechaFin);
            $fechaEvento = Carbon::createFromTimestamp(
                // Generar una fecha aleatoria entre la fecha de inicio y la fecha de fin
                // carbon::numberBetween(fecha1, fecha2)
                $this->faker->numberBetween($fechaInicioCarbon->timestamp, $fechaFinCarbon->timestamp)
            );
            
            $eventos[] = new Evento(
                titulo:         $this->faker->randomElement($this->tiposEventos) . " " . $this->faker->randomElement($this->temas),
                descripcion:    $this->faker->paragraph(3),
                fecha:          $fechaEvento,
                ponente:        $this->faker->randomElement($ponentes)
            );
        }

        // Ordenar eventos por fecha (descendente)
        usort($eventos, fn($a, $b) => $b->getFecha()->timestamp - $a->getFecha()->timestamp);

        // Ordenar eventos por fecha (ascendente)
        // usort($eventos, fn($a, $b) => $a->getFecha()->timestamp - $b->getFecha()->timestamp);

        return $eventos;
    }


    public function getTitulos(): array
    {
        return $this->titulos;
    }


    public function getTiposEventos(): array
    {
        return $this->tiposEventos;
    }


    public function getTemas(): array
    {
        return $this->temas;
    }
};

?>