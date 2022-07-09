<?php

namespace App\Http\V1\Action\Post\Delete\Dto;

use App\Domain\Post\Service\Dto\DeletePost;
use Symfony\Component\HttpFoundation\Request;

class DeleteRequest extends DeletePost
{

    public function __construct(Request $request)
    {
        $id = $request->get('id');
        parent::__construct($id);
    }
}
