<?php

declare(strict_types=1);

namespace App\Http\V1\Action;

use App\Http\V1\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractAction extends AbstractController
{
    protected ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    abstract public function __invoke(Request $request): Response;
}
