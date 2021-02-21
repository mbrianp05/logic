<?php

namespace Mbrianp\FuncCollection\Logic;

use Mbrianp\FuncCollection\DIC\DIC;
use Mbrianp\FuncCollection\Http\RedirectResponse;
use Mbrianp\FuncCollection\Http\Response;
use Mbrianp\FuncCollection\View\TemplateManager;

abstract class AbstractController
{
    public function __construct(private string $templates_dir, protected DIC $dependenciesContainer)
    {
    }

    public function render(string $file, array $variables = [], Response $response = null): Response
    {
        $vm = new TemplateManager($this->dependenciesContainer, $this->templates_dir);

        if (null == $response) {
            $response = new Response();
        }

        $response->response = $vm->render($file, $variables);

        return $response;
    }

    public function redirect(string $name, array $params = []): Response
    {
        $url = $this->dependenciesContainer->getService('kernel.routing')->generateUrl($name, $params);

        return new RedirectResponse($url);
    }
}