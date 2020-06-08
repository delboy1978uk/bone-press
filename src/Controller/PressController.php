<?php declare(strict_types=1);

namespace Bone\Press\Controller;

use Bone\Controller\Controller;
use Bone\Exception;
use Bone\Press\Form\PageForm;
use Bone\Server\SessionAwareInterface;
use Bone\Server\Traits\HasSessionTrait;
use Bone\View\Helper\Paginator;
use Del\Icon;
use Del\Press\Cms;
use Doctrine\Common\Collections\ArrayCollection;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PressController extends Controller implements SessionAwareInterface
{
    use HasSessionTrait;

    /** @var Cms $cms */
    private $cms;

    /** @var int $numPerPage */
    private $numPerPage = 10;

    /** @var Paginator $paginator */
    private $paginator;

    /**
     * PressController constructor.
     * @param Cms $cms
     */
    public function __construct(Cms $cms)
    {
        $this->cms = $cms;
        $this->paginator = new Paginator();
    }


    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function indexAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $posts = $this->cms->getPageRepository()->findAll();
        $total = count($posts);

        $this->paginator->setUrl('/cms?page=:page');
        $page = isset($request->getQueryParams()['page']) ? $request->getQueryParams()['page'] : 1;
        $this->paginator->setCurrentPage($page);
        $this->paginator->setPageCountByTotalRecords($total, $this->numPerPage);

        $posts = new ArrayCollection($this->cms->getPageRepository()->findBy([], null, $this->numPerPage, ($page *  $this->numPerPage) - $this->numPerPage));

        $body = $this->view->render('press::index', [
            'posts' => $posts,
            'paginator' => $this->paginator->render(),
        ]);

        return new HtmlResponse($body);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function addPostAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $userId = $this->getSession()->get('user');
        $page = $this->cms->createPage();
        $page->setUserId($userId);
        $this->cms->updatePage($page);
        $id = $page->getId();

        return new RedirectResponse('/cms/edit-post/' . $id);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function editPostAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $id = $request->getAttribute('id');

        if (! $page = $this->cms->fetchPage($id)) {
            throw new Exception('Page not found', 404);
        }

        $form = new PageForm('page');
        $form->getField('title')->setValue($page->getTitle());
        $slug = $page->getSlug();
        $form->getField('slug')->setValue($slug);
        $published = $page->isPublished() ? 1: 0;
        $form->getField('published')->setValue($published);

        $body = $this->view->render('press::edit', [
            'form' => $form->render()
        ]);

        return new HtmlResponse($body);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function handleEditPostAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $message = null;

        if (! $page = $this->cms->fetchPage($id)) {
            throw new Exception('Page not found', 404);
        }

        $form = new PageForm('page');
        $data = $request->getParsedBody();
        $form->populate($data);

        if ($form->isValid()) {
            $data = $form->getValues();
            $page->setTitle($data['title']);
            $slug = $data['slug'];
            $slug = strpos($slug, '/') === 0 ? substr($slug, 1) : $slug;
            $page->setSlug($slug);
            $page->setIsPublished(($data['published'] == 1));
            $this->cms->updatePage($page);
            $message = ['Page successfully updated', 'success'];
        }

        $body = $this->view->render('press::edit', [
            'form' => $form->render(),
            'message' => $message,
        ]);

        return new HtmlResponse($body);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function viewPostAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $slug = $request->getAttribute('slug');
        $message = null;

        if (! $page = $this->cms->fetchPage($slug)) {
            throw new Exception('Page not found', 404);
        }

        $body = $this->view->render('press::view', [
            'post' => $page,
        ]);

        return new HtmlResponse($body);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function deletePostAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $message = null;

        if (! $page = $this->cms->fetchPage($id)) {
            throw new Exception('Page not found', 404);
        }

        if ($request->getMethod() === 'POST') {
            $this->cms->deletePage($page);
            $message = [Icon::WARNING . ' Post deleted', 'success'];
        }

        $body = $this->view->render('press::delete', [
            'message' => $message,
            'post' => $page,
        ]);

        return new HtmlResponse($body);
    }
}
