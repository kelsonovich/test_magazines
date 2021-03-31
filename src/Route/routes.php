<?php

    use App\App\App;
    use App\Route\Route;

    App::addRoute(new Route('magazine', 'list', 'GET'));
    App::addRoute(new Route('magazine', 'add', 'POST'));
    App::addRoute(new Route('magazine', 'update', 'POST'));
    App::addRoute(new Route('magazine', 'delete', 'POST'));

    App::addRoute(new Route('author', 'list', 'GET'));
    App::addRoute(new Route('author', 'add', 'POST'));
    App::addRoute(new Route('author', 'update', 'POST'));
    App::addRoute(new Route('author', 'delete', 'POST'));