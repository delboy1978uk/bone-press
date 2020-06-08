<?php

declare(strict_types=1);

namespace Bone\Press\Controller;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PressApiController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        return new JsonResponse([
            'drink' => 'grog',
            'pieces' => 'of eight',
            'shiver' => 'me timbers',
        ]);
    }
}
