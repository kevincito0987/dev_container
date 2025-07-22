<?php

namespace App;
use App\http\factories\ControllerFactory;


class Route
{
    private string $metodo;
    private string $recurso;
    private array $parametros;

    public function __construct(string $requestUri, string $method)
    {
        $uri = explode('/', trim($requestUri, '/'));
        $this->metodo = strtoupper($method);
        $this->recurso = strtolower($uri[0]);
        $this->parametros = isset($uri[1]) ? array_slice($uri, 1) : [];
    }

    public function handle()
    {
        header('Content-Type: application/json');

        $controller = ControllerFactory::create($this->recurso);

        if (!array_key_exists($this->metodo, $controller::$dispatch)) {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido', 'code' => 405, 'errorUrl' => 'https://http.cat/405']);
            exit;
        }
        $funcion = $controller::$dispatch[$this->metodo];

        if (!method_exists($controller, $funcion)) {
            http_response_code(501);
            echo json_encode(['error' => 'Metodo no implementado', 'code' => 501, 'errorUrl' => 'https://http.cat/501']);
            exit;
        }
        //localhost:8081/camper/123/reporte/enero?filter=edad
        //$args = [
        // "params" => [123,reporte, enero],
        // "data" => [],
        // "query" => [filter => edad]
        //]
        $data = file_get_contents('php://input', true) ?
            json_decode(file_get_contents('php://input', true), true) :
            [];
            $controller->$funcion([
                "params" => $this->parametros,
                "data" => $data ?? []
            ]);        
        exit;
    }
}
