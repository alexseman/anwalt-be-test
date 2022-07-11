<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Read\Dto;

use App\Domain\Todo\Service\Dto\ReadTodo;
use Symfony\Component\HttpFoundation\Request;

class ReadRequest extends ReadTodo
{

    public function __construct(Request $request)
    {
        $id = (int)$request->get('id');
        parent::__construct($id);
    }
}
