<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Delete\Dto;

use App\Domain\Todo\Service\Dto\DeleteTodo;
use Symfony\Component\HttpFoundation\Request;

class DeleteRequest extends DeleteTodo
{

    public function __construct(Request $request)
    {
        $id = (int)$request->get('id');
        parent::__construct($id);
    }
}
