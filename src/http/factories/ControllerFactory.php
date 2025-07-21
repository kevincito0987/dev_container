<?php

namespace App\http\factories;
use App\http\controllers\CrudController;
use App\http\controllers\CamperController;
use App\http\controllers\ProductoController;
use App\repositories\CamperRepositoryImpl;
use App\core\DatabasePDO;


class ControllerFactory
{

    public static function create(string $path): CrudController
    {
        //CamperController es un CrudController
        //ProductoController es un CrudController
        switch ($path) {
            case 'producto':
                return new ProductoController();
            case 'camper':
                $repository = new CamperRepositoryImpl(DatabasePDO::getConnection());
                //$repository = new CamperRepositoryJsonImpl();
                return new CamperController($repository);
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Recurso no encontrado', 'code' => 404, 'errorUrl' => 'https://http.cat/404']);
                exit;
        }
    }
}
