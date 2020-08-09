<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsersAction
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        $users = [
            ['id' => 1, 'name' => 'César'],
            ['id' => 2, 'name' => 'Juca'],
        ];

        $response->getBody()->write(json_encode($users));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
