<?php

use Dom\NamedNodeMap;

require_once "src/db.php";


$method = $_SERVER['REQUEST_METHOD'];


//res localhost:8081/filter=datos

$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$id = $uri[1] ?? null;


// Check if the request is for the 'filter' endpoint
$recurso = $uri[0];

header( 'Content-Type: application/json');

if ($recurso !== 'products') {
    // If not, return a 404 Not Found response
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "Recurso no encontrado",
        "code" => 404,
        "url_error" => "https://http.cat/status/404"
    ]);
    exit;
} 

// Realizar consulta a la base de datos

switch ($method) {
    case 'GET':
        $stmt = $pdo->prepare("SELECT * FROM PRODUCTS");
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($response);
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO PRODUCTS (name, description, price, created_at) VALUES (:name, :description, :price, :created_at)");
        $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':created_at' => date('Y-m-d H:i:s')
        ]);
        http_response_code(201);
        $data['id'] = $pdo->lastInsertId();
        break;
    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "ID del producto es requerido",
                "code" => 400,
                "url_error" => "https://http.cat/status/400"
            ]);
            exit;
        }
        // Actualizar producto
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE PRODUCTS SET id = ?, name = ?,  price = ?  WHERE id = ?");
        $stmt->execute([
            $data['id'],
            $data['name'],
            $data['price'],
            $id,
        ]);
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Producto actualizado correctamente"
        ]);
        break;
    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "ID del producto es requerido",
                "code" => 400,
                "url_error" => "https://http.cat/status/400"
            ]);
            exit;
        }
        
        // Obtener el producto antes de eliminarlo
        $stmt = $pdo->prepare("SELECT * FROM PRODUCTS WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // Eliminar producto
        $stmt = $pdo->prepare("DELETE FROM PRODUCTS WHERE id = ?");
        $stmt->execute([
            $data['id'] = $id
        ]);

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Producto eliminado correctamente",
            "id" => $id,
            "name" => $data['name'] ?? null,
            "price" => $data['price'] ?? null,
        ]);
        exit;
    default:
        http_response_code(405);
        echo json_encode([
            "status" => "error",
            "message" => "Método no permitido",
            "code" => 405,
            "url_error" => "https://http.cat/status/405"
        ]);
        exit;
}


?>