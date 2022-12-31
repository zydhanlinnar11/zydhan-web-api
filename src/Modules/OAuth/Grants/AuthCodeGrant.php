<?php

namespace Modules\OAuth\Grants;

use DateInterval;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\AuthCodeGrant as LeagueAuthCodeGrant;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Modules\OAuth\Entities\IdToken;
use Modules\OAuth\ResponseTypes\BearerTokenResponse;
use Psr\Http\Message\ServerRequestInterface;

final class AuthCodeGrant extends LeagueAuthCodeGrant
{
    use OpenIdConnectGrant;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        AuthCodeRepositoryInterface $authCodeRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository,
        DateInterval $authCodeTTL,
        DateInterval $idTokenTTL,
    ) {
        parent::__construct($authCodeRepository, $refreshTokenRepository, $authCodeTTL);

        $this->idTokenTTL = $idTokenTTL;
    }

    /**
     * {@inheritdoc}
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        DateInterval $accessTokenTTL
    ) {
        /** @var BearerTokenResponse $response */
        $response = parent::respondToAccessTokenRequest($request, $responseType, $accessTokenTTL);
        
        list($clientId) = $this->getClientCredentials($request);

        $client = $this->getClientEntityOrFail($clientId, $request);
        $encryptedAuthCode = $this->getRequestParameter('code', $request, null);
        try {
            $authCodePayload = \json_decode($this->decrypt($encryptedAuthCode));
            $scopes = $this->scopeRepository->finalizeScopes(
                $this->validateScopes($authCodePayload->scopes),
                $this->getIdentifier(),
                $client,
                $authCodePayload->user_id
            );
        } catch (\LogicException $e) {
            throw OAuthServerException::invalidRequest('code', 'Cannot decrypt the authorization code', $e);
        }

        $filteredOpenIdScope = array_filter($scopes, function($scope) {
            return $scope->getIdentifier() === 'openid';
        });

        if(!empty($filteredOpenIdScope)) {
            $idToken = new IdToken(
                issuer: $this->issuer,
                subject: $authCodePayload->user_id,
                audience: $authCodePayload->client_id,
                expiration: (new \DateTimeImmutable())->add($this->idTokenTTL)
            );

            $response->setIdToken($idToken);
        }
        
        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthorizationRequest(ServerRequestInterface $request)
    {
        $validatedRequest = parent::validateAuthorizationRequest($request);
        
        $redirectUri = $this->getQueryStringParameter(
            'redirect_uri',
            $request
        );

        if (is_null($redirectUri)) {
            throw OAuthServerException::invalidRequest('redirect_uri');
        }

        return $validatedRequest;
    }
}