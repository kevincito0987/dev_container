<?php

namespace App\models;
use App\models\Persona;
use App\models\Asistencia;

class Empleado extends Persona implements Asistencia
{
    private string $cargo;
    private int $sueldo; // $$

    public function __construct(
        int $id,
        string $nombre,
        int $edad,
        string $documento,
        string $tipo,
        string $cargo,
        int $sueldoRemunerado,
    ) {
        parent::__construct($id, $nombre, $edad, $documento, $tipo);
        $this->sueldo = $sueldoRemunerado;
        $this->cargo = $cargo;
    }

    public function MarcarIngreso(string $metodo): string
    {
        return "El empleado: {$this->nombre} marco el Ingreso con {$metodo}";
    }

    public function MarcarSalida(string $metodo): string
    {
        return "El empleado: {$this->nombre} marco Salida con {$metodo}";
    }

    public function esMayor(): bool
    {
        return $this->edad >= 18;
    }

    public function getSueldo(): int
    {
        return $this->sueldo;
    }

    public function getCargo(): string
    {
        return $this->cargo;
    }
}
