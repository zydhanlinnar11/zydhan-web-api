<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use League\OAuth2\Server\Exception\OAuthServerException as LeagueException;

class OAuthServerException extends Exception
{
    /**
     * The response to render.
     *
     * @var \Illuminate\Http\JsonResponse
     */
    protected $response;

    /**
     * Create a new OAuthServerException.
     *
     * @param  \League\OAuth2\Server\Exception\OAuthServerException  $e
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return void
     */
    public function __construct(LeagueException $e, JsonResponse $response)
    {
        parent::__construct($e->getMessage(), $e->getCode(), $e);

        $this->response = $response;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $this->response;
    }

    /**
     * Get the HTTP response status code.
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->response->getStatusCode();
    }
}
