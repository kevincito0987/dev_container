<?php

namespace App\repositories;
use PDO;
use App\repositories\CamperRepository;
use PhpParser\Node\Stmt;

class CamperRepositoryImpl implements CamperRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findById(int $id): ?object
{
    $stmt = $this->db->prepare(" SELECT
            id,
            nombre,
            edad,
            documento,
            tipo_documento,
            CASE
                WHEN nivel_ingles >= 1 AND nivel_ingles <= 2 THEN 'BAJO'
                WHEN nivel_ingles > 2 AND nivel_ingles <= 4  THEN 'MEDIO'
                WHEN nivel_ingles > 4 THEN 'ALTO'
                ELSE 'NO DEFINIDO'
            END AS skill_ingles, -- Alias for the calculated English level
            CASE
                WHEN nivel_programacion < 2 THEN 'BAJO'
                WHEN nivel_programacion >= 2 AND nivel_programacion <= 3 THEN 'MEDIO'
                WHEN nivel_programacion > 3 THEN 'ALTO'
                ELSE 'NO DEFINIDO'
            END AS skill_programacion -- Alias for the calculated Programming level
        FROM
            campers
        WHERE
            id = ?
    ");
    $stmt->execute([$id]);
    $response = $stmt->fetch(PDO::FETCH_ASSOC);
    return $response ? (object)$response : (object)["message" => "No se encontro el camper"];
}

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT
            id,
            nombre,
            edad,
            documento,
            tipo_documento,
            CASE
                WHEN nivel_ingles >= 1 AND nivel_ingles <= 2 THEN 'BAJO'
                WHEN nivel_ingles > 2 AND nivel_ingles <= 4  THEN 'MEDIO'
                WHEN nivel_ingles > 4 THEN 'ALTO'
                ELSE 'NO DEFINIDO'
            END AS skill_ingles, -- Alias for the calculated English level
            CASE
                WHEN nivel_programacion < 2 THEN 'BAJO'
                WHEN nivel_programacion >= 2 AND nivel_programacion <= 3 THEN 'MEDIO'
                WHEN nivel_programacion > 3 THEN 'ALTO'
                ELSE 'NO DEFINIDO'
            END AS skill_programacion -- Alias for the calculated Programming level
        FROM
            campers
        ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): ?object
    {
        $stmt = $this->db->prepare("INSERT INTO campers(nombre,edad,documento,tipo_documento,nivel_ingles,nivel_programacion) VALUES(?,?,?,?,?,?)");
        $stmt->execute([
            $data['nombre'],
            $data['edad'],
            $data['documento'],
            $data['tipo_documento'],
            $data['nivel_ingles'],
            $data['nivel_programacion'],
        ]);
        if ($this->db->lastInsertId() > 0) {
            $data['id'] = $this->db->lastInsertId();
        }
        return (object)$data;
    }

    public function update(array $data, int $id): object
    {
        $stmt = $this->db->prepare("UPDATE campers SET nombre = ?, edad = ?, documento = ?, tipo_documento = ?, nivel_ingles = ?, nivel_programacion = ? WHERE id = $id");
        $stmt->execute([
            $data['nombre'],
            $data['edad'],
            $data['documento'],
            $data['tipo_documento'],
            $data['nivel_ingles'],
            $data['nivel_programacion'],
        ]);
        return (object)["message" => "Camper actualizado"];
    }

    public function delete(array $args,int $id): object
    {
        $camperToDelete = $this->findById($id);

        if (!$camperToDelete) {
            return (object)["message" => "El camper con ID {$id} no fue encontrado.", "status" => "error"];
        }
            $stmt = $this->db->prepare("DELETE FROM campers WHERE id = ?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                return (object)[
                    "message" => "Camper con ID {$id} eliminado exitosamente.",
                    "camper" => (object)$camperToDelete, // Convert the array back to object for response
                    "status" => "success"
                ];
            } else {
                return (object)["message" => "No se pudo eliminar el camper con ID {$id} (ya fue eliminado o no se encontró en el momento de la eliminación).", "status" => "error"];
            }
    }
}
