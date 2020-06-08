<?php declare(strict_types=1);

namespace Bone\Press\Controller;

use Bone\Controller\Controller;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PressController extends Controller
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function indexAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $body = $this->view->render('press::index', []);

        return new HtmlResponse($body);
    }
}
