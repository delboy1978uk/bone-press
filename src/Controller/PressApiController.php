<?php declare(strict_types=1);

namespace Bone\Press\Controller;

use Bone\Controller\Controller;
use Bone\Exception;
use Bone\Press\Form\PageForm;
use Bone\Server\SessionAwareInterface;
use Bone\Server\Traits\HasSessionTrait;
use Bone\View\Helper\Paginator;
use Del\Icon;
use Del\Press\Block\Header;
use Del\Press\Block\Paragraph;
use Del\Press\Cms;
use Doctrine\Common\Collections\ArrayCollection;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PressApiController extends Controller implements SessionAwareInterface
{
    use HasSessionTrait;

    /** @var Cms $cms */
    private $cms;

    /**
     * PressController constructor.
     * @param Cms $cms
     */
    public function __construct(Cms $cms)
    {
        $this->cms = $cms;
    }

    /**
     * @return array
     */
    private function getBlockTypes(): array
    {
        $bundledBlockTypes = [
            Header::class,
            Paragraph::class,
        ];

        $customBlockTypes = [];

        return array_merge($bundledBlockTypes, $customBlockTypes);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     */
    public function getBlockTypesAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $data = [];
        $blocks = $this->getBlockTypes();

        foreach ($blocks as $block) {
            $ex = explode('\\', $block);
            $data[$block] = end($ex);
        }

        return new JsonResponse($data);
    }
}
