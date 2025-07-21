<?php

namespace App\models;
use App\models\Persona;
use App\models\Asistencia;


class Camper extends Persona implements Asistencia
{
    public int $skillIngles = 0;
    public int $skillProgramacion = 0;

    /**
     * Logica para crear un Camper
     * @param string $nombre Define el nombre del Camper sin la logica de la validacion de 20 caracteres
     * @param string $documento Documento del camper
     * @param int $edad Edad del camper representado en valores enteros
     */
    public function __construct(string $nombre, string $documento, int $edad, string $tipoDocumento, int $skillIngles = 0, int $skillProgramacion = 0)
    {
        parent::__construct(0, $nombre, $edad, $documento, $tipoDocumento); // Siempre necesario....
        $this->skillIngles = $skillIngles;
        $this->skillProgramacion = $skillProgramacion;
    }

    public function MarcarIngreso(string $metodo): string
    {
        return "{$this->nombre} marco el Ingreso con {$metodo}";
    }

    public function MarcarSalida(string $metodo): string
    {
        return "{$this->nombre} marco Salida con {$metodo}";
    }

    private function marcarAsistencia() {}

    public function esMayor(): bool
    {
        return $this->edad >= 18;
    }


    /**
     * Asignar el nombre del Camper, validando que cumpla con el minimo de 5 caracteres.....
     * @param string $nombre Define el nuevo nombre del Camper
     */

    public function setNombre(string $nombre): void
    {
        if (strlen($nombre) >= 5) {
            $this->nombre = $nombre;
        } else {
            echo 'Error al asignar el nombre al Camper';
        }
    }

    public function getNombre(): string
    {
        return "__" . strtoupper(parent::getNombre()) . "__";
    }

    public function getInfoDocumento(): string
    {
        return "{$this->getTipoDocumento()} : {$this->getDocumento()}";
    }

    public function informacion(): array
    {
        return [
            'nombre' => $this->nombre ?? 'NN',
            'edad' => $this->edad ?? 0,
            'documento' => $this->documento ?? 'NN',
            'tipoDocumento' => $this->tipoDocumento
        ];
    }
}
