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
            created_at,
            updated_at,
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
            $data['nivel_programacion']
        ]);
        if ($this->db->lastInsertId() > 0) {
            $data['id'] = $this->db->lastInsertId();
        }
        return (object)$data;
    }

    public function update(array $data, int $id): object
    {
        $stmt = $this->db->prepare("UPDATE campers SET nombre = ?, edad = ?, documento = ?, tipo_documento = ?, nivel_ingles = ?, nivel_programacion = ?, created_at = NOW(), updated_at = NOW() WHERE id = $id");
        $stmt->execute([
            $data['nombre'],
            $data['edad'],
            $data['documento'],
            $data['tipo_documento'],
            $data['nivel_ingles'],
            $data['nivel_programacion'],
            $data['created_at'],
            $data['updated_at'],
        ]);
        return (object)["message" => "Camper actualizado"];
    }

    public function delete(array $data, int $id): array
{
    // Verificar si el camper existe
    $stmt = $this->db->prepare("SELECT * FROM campers WHERE id = $id");
    $stmt->execute();
    $response = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$response) {
        // Si el camper no existe, devolver un mensaje de error
        return [
            "status" => "error",
            "message" => "No se encontró el camper con ID $id",
        ];
    }

    // Eliminar el camper
    $stmt = $this->db->prepare("DELETE FROM campers WHERE id = $id");
    $stmt->execute();

    // Reordenar los IDs
    $stmt = $this->db->prepare("
        SET @count = 0;
        UPDATE campers SET id = (@count := @count + 1);
        ALTER TABLE campers AUTO_INCREMENT = 1;
    ");
    $stmt->execute();

    // Devolver la información del camper eliminado
    return [
        "status" => "success",
        "message" => "Camper eliminado y IDs reordenados",
        "camper" => (object)$response,
    ];
}
}
