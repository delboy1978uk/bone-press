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
use Bone\User\Http\Middleware\SessionAuth;
use Bone\View\ViewEngine;
use Del\Press\Cms;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use League\Route\Strategy\JsonStrategy;

class PressPackage implements RegistrationInterface, RouterConfigInterface, EntityRegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        $c[Cms::class] = $c->factory(function (Container $c) {
            $entityManager = $c->get(EntityManager::class);

            return new Cms($entityManager);
        });

        /** @var ViewEngine $viewEngine */
        $viewEngine = $c->get(ViewEngine::class);
        $viewEngine->addFolder('press', __DIR__ . '/View/Press/');

        $c[PressController::class] = $c->factory(function (Container $c) {
            $cms = $c->get(Cms::class);

            return Init::controller(new PressController($cms), $c);
        });

        $c[PressApiController::class] = $c->factory(function (Container $c) {
            $cms = $c->get(Cms::class);

            return Init::controller(new PressApiController($cms), $c);
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
        $router->map('GET', '/cms/new-post', [PressController::class, 'addPostAction']);
        $router->map('GET', '/cms/edit-post/{id:number}', [PressController::class, 'editPostAction']);
        $router->map('POST', '/cms/edit-post/{id:number}', [PressController::class, 'handleEditPostAction']);
        $router->map('GET', '/cms/delete-post/{id:number}', [PressController::class, 'deletePostAction']);
        $router->map('POST', '/cms/delete-post/{id:number}', [PressController::class, 'deletePostAction']);
        $router->map('GET', '/posts/{slug}', [PressController::class, 'viewPostAction']);

        $factory = new ResponseFactory();
        $strategy = new JsonStrategy($factory);
        $strategy->setContainer($c);

        $router->group('/api', function (RouteGroup $route) use ($c) {
            $route->map('POST', '/cms/add-block/{id:number}', [PressApiController::class, 'addBlockAction'])
            ->middleware($c->get(SessionAuth::class));
        })->setStrategy($strategy);

        return $router;
    }

    function getEntityPath(): string
    {
        return __DIR__ . '/../../press/src/';
    }


}

