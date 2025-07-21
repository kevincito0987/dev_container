<?php

namespace App\models;
interface Asistencia
{
    public function MarcarIngreso(string $metodo): string;
    public function MarcarSalida(string $metodo): string;
}
