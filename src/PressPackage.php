<?php

declare(strict_types=1);

namespace Bone\Press;

use Barnacle\Container;
use Barnacle\EntityRegistrationInterface;
use Barnacle\RegistrationInterface;
use Bone\Controller\Init;
use Bone\Press\Controller\PressApiController;
use Bone\Press\Controller\PressController;
use Bone\Router\Router;
use Bone\Router\RouterConfigInterface;
use Bone\View\ViewEngine;
use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use League\Route\Strategy\JsonStrategy;

class PressPackage implements RegistrationInterface, RouterConfigInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        /** @var ViewEngine $viewEngine */
        $viewEngine = $c->get(ViewEngine::class);
        $viewEngine->addFolder('press', __DIR__ . '/View/Press/');

        $c[PressController::class] = $c->factory(function (Container $c) {
            return Init::controller(new PressController(), $c);
        });

        $c[PressApiController::class] = $c->factory(function (Container $c) {
            return new PressApiController();
        });
    }

    /**
     * @param Container $c
     * @param Router $router
     * @return Router
     */
    public function addRoutes(Container $c, Router $router): Router
    {
        $router->map('GET', '/cms', [PressController::class, 'indexAction']);

        $factory = new ResponseFactory();
        $strategy = new JsonStrategy($factory);
        $strategy->setContainer($c);

        $router->group('/api', function (RouteGroup $route) {
            $route->map('GET', '/cms', [PressApiController::class, 'indexAction']);
        })
        ->setStrategy($strategy);

        return $router;
    }
}

