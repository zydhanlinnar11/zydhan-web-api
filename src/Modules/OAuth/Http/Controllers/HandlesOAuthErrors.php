<?php

namespace Modules\OAuth\Http\Controllers;

use Modules\OAuth\Exceptions\OAuthServerException;
use Laravel\Passport\Http\Controllers\ConvertsPsrResponses;
use League\OAuth2\Server\Exception\OAuthServerException as LeagueException;

trait HandlesOAuthErrors
{
    use ConvertsPsrResponses;

    /**
     * Perform the given callback with exception handling.
     *
     * @param  \Closure  $callback
     * @return mixed
     *
     * @throws \Laravel\Passport\Exceptions\OAuthServerException
     */
    protected function withErrorHandling($callback)
    {
        try {
            return $callback();
        } catch (LeagueException $e) {
            $data = $e->getPayload();
            $data['message'] = $e->getMessage();
            $data['redirect_uri'] = $e->getRedirectUri();
            throw new OAuthServerException($e, response()->json($data, $e->getHttpStatusCode()));
        }
    }
}
