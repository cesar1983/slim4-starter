<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CountryAction
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {

        $countries = [
            ['id' => 1, 'name' => 'Brazil'],
            ['id' => 2, 'name' => 'EUA'],
        ];

        $response->getBody()->write(json_encode($countries));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
