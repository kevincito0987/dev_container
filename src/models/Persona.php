<?php
namespace App\models;
abstract class Persona
{
    private int $id;
    protected string $nombre;
    protected int $edad;
    protected string $documento;
    protected string $tipoDocumento;

    public function __construct(int $id, string $nombre, int $edad, string $documento, string $tipo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->documento = $documento;
        $this->tipoDocumento = $tipo;
    }

    public abstract function esMayor(): bool;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = htmlspecialchars(trim($nombre));
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setEdad(int $edad): void
    {
        $this->edad = $edad;
    }

    public function getEdad(): int
    {
        return $this->edad;
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }

    public function getTipoDocumento(): string
    {
        return $this->tipoDocumento;
    }
}
