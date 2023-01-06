<?php

namespace Modules\OAuth\Http\Controllers;

use Laravel\Passport\ClientRepository;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;

class ClientInfoController
{
    use HandlesOAuthErrors;

    /**
     * The authorization server.
     *
     * @var \League\OAuth2\Server\AuthorizationServer
     */
    protected $server;

    /**
     * Create a new controller instance.
     *
     * @param  \League\OAuth2\Server\AuthorizationServer  $server
     * @return void
     */
    public function __construct(AuthorizationServer $server)
    {
        $this->server = $server;
    }

    public function info(ServerRequestInterface $psrRequest,
                              ClientRepository $clients)
    {
        /** @var \League\OAuth2\Server\RequestTypes\AuthorizationRequest $authRequest */
        $authRequest = $this->withErrorHandling(function () use ($psrRequest) {
            return $this->server->validateAuthorizationRequest($psrRequest);
        });

        $client = $clients->find($authRequest->getClient()->getIdentifier());

        return response()->json([
            'client_id' => $client->id,
            'client_name' => $client->name,
        ]);
    }
}
