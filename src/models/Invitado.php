<?php

namespace App\models;
use App\models\Persona;

class Invitado extends Persona
{
    private string $nombreInvito;
    private string $nombreAutorizo;

    public function __construct(
        int $id,
        string $nombre,
        int $edad,
        string $documento,
        string $tipo,
        string $nombreInvito,
        string $nombreAutorizo,
    ) {
        parent::__construct($id, $nombre, $edad, $documento, $tipo);
        $this->nombreInvito = $nombreInvito;
        $this->nombreAutorizo = $nombreAutorizo;
    }

    public function esMayor(): bool
    {
        return $this->edad >= 18;
    }

    public function getNombreDeQuienAutorizo(): string
    {
        return $this->nombreAutorizo;
    }

    public function getNombreDeQuienInvito(): string
    {
        return $this->nombreInvito;
    }
}
