<?php

namespace Modules\OAuth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\OAuth\Exceptions\OAuthServerException;
use Laravel\Passport\Http\Controllers\ConvertsPsrResponses;
use League\OAuth2\Server\Exception\OAuthServerException as LeagueException;

trait HandlesOAuthErrors
{
    use ConvertsPsrResponses;

    /**
     * Generate a HTTP response.
     *
     * @param LeagueException $e
     *
     * @return JsonResponse
     */
    public function generateHttpResponse(LeagueException $e): JsonResponse
    {
        $payload = $e->getPayload();
        $redirectUri = $e->getRedirectUri();

        if ($redirectUri !== null) {
            $redirectUri .= (\strstr($redirectUri, '?') === false) ? '?' : '&';

            return response()->json([
                'status' => 'error',
                'data' => [
                    'action' => 'redirect',
                    'location' => $redirectUri . \http_build_query($payload),
                ]
            ], $e->getHttpStatusCode());
        }

        return response()->json([
            'status' => 'error',
            'data' => [
                'action' => 'display',
                'payload' => $payload,
            ]
        ], $e->getHttpStatusCode());
    }

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
            throw new OAuthServerException($e, $this->generateHttpResponse($e));
        }
    }
}
