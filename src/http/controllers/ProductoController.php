<?php

namespace App\http\controllers;

class ProductoController extends CrudController
{
    public static array $dispatch = [
        "GET" => "get",
        "POST" => "create",
        "PUT" => "update",
        "DELETE" => "delete"
    ];

    public function get()
    {
        echo json_encode(['response' => 'Recurso producto get desde el controller']);
    }

    public function create()
    {
        echo json_encode(['response' => 'Recurso producto create']);
    }

    public function update()
    {
        echo json_encode(['response' => 'Recurso producto update']);
    }

    public function delete()
    {
        echo json_encode(['response' => 'Recurso producto delete']);
    }
}
