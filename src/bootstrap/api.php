<?php

use App\Route;

$route = new Route($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$route->handle();
