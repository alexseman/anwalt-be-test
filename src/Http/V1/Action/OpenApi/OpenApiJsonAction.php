<?php

declare(strict_types=1);

namespace App\Http\V1\Action\OpenApi;

use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Response\ApiResponse;
use App\Shared\Service\YamlParser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OpenApiJsonAction extends AbstractAction
{

    private string $projectDir;

    public function __construct(ApiResponse $response, string $projectDir)
    {
        parent::__construct($response);
        $this->projectDir = $projectDir;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $yaml = YamlParser::parse($this->projectDir . '/docs/OpenApi/v1/index.yaml');

        return new JsonResponse($yaml);
    }

}
