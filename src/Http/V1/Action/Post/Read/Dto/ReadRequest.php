<?php

namespace App\Http\V1\Action\Post\Read\Dto;

use App\Domain\Post\Service\Dto\ReadPost;
use Symfony\Component\HttpFoundation\Request;

class ReadRequest extends ReadPost
{

    public function __construct(Request $request)
    {
        $id = $request->get('id');
        parent::__construct($id);
    }
}
