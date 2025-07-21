<?php

namespace App\repositories;
use App\repositories\CamperRepository;

class CamperRepositoryJsonImpl implements CamperRepository
{
    public function findById(int $id): ?object
    {
        return (object)[
            "id" => $id,
            "nombre" => "Maicol Rios",
            "edad" => 18,
            "documento" => "100987651",
            "tipo_documento" => "Cédula",
            "nivel_ingles" => 2,
            "nivel_programacion" => 1,
            "created_at" => "2025-07-17 12:49:28",
            "updated_at" => "2025-07-17 12:49:28"
        ];
    }

    public function getAll(): array
    {
        return json_decode('
        
        [
                {
                    "id": 1,
                    "nombre": "Maicol Rios",
                    "edad": 18,
                    "documento": "100987651",
                    "tipo_documento": "Cédula",
                    "nivel_ingles": 2,
                    "nivel_programacion": 1,
                    "created_at": "2025-07-17 12:49:28",
                    "updated_at": "2025-07-17 12:49:28"
                },
                {
                    "id": 2,
                    "nombre": "Luis Miguel Audifonos",
                    "edad": 23,
                    "documento": "123456678",
                    "tipo_documento": "Cédula",
                    "nivel_ingles": 3,
                    "nivel_programacion": 4,
                    "created_at": "2025-07-17 12:49:28",
                    "updated_at": "2025-07-17 12:49:28"
                }
        ]
        
        ');
    }

    public function create(array $data): ?object
    {
        return (object)[
            "id" => 0,
            "nombre" => "Maicol Rios",
            "edad" => 18,
            "documento" => "100987651",
            "tipo_documento" => "Cédula",
            "nivel_ingles" => 2,
            "nivel_programacion" => 1,
            "created_at" => "2025-07-17 12:49:28",
            "updated_at" => "2025-07-17 12:49:28"
        ];
    }

    public function update(): object
    {
        return (object)[
            "id" => 0,
            "nombre" => "Maicol Rios",
            "edad" => 18,
            "documento" => "100987651",
            "tipo_documento" => "Cédula",
            "nivel_ingles" => 2,
            "nivel_programacion" => 1,
            "created_at" => "2025-07-17 12:49:28",
            "updated_at" => "2025-07-17 12:49:28"
        ];
    }
}
