<?php

declare(strict_types=1);

namespace App\Http\V1\Action\OpenApi;

use App\Http\V1\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OpenApiUIAction extends AbstractAction
{

    public function __invoke(Request $request): Response
    {
        return $this->render('openapi/standalone.html.twig', ['version' => 'v1']);
    }

}
