<?php

namespace Modules\OAuth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laravel\Passport\Passport;
use phpseclib3\Crypt\PublicKeyLoader;
use Modules\OAuth\Entities\OpenIdProvider;

class OpenIDConfigurationController extends Controller
{
    /**
     * The OpenID Provider's JWKs information can be retrieved.
     * 
     * @return JsonResponse
     */
    public function jwks()
    {
        $publicKeyString = file_get_contents(Passport::keyPath('./oauth-public.key'));
        $publicKey = PublicKeyLoader::loadPublicKey($publicKeyString);
        return response()->json(json_decode($publicKey->toString('JWK'), true));
    }

    /**
     * The OpenID Provider's configuration information can be retrieved.
     * 
     * @param OpenIdProvider $openIdProvider
     * 
     * @return JsonResponse
     */
    public function index(OpenIdProvider $openIdProvider)
    {
        $config = [
            'issuer' => $openIdProvider->getIssuer(),
            'authorization_endpoint' => $openIdProvider->getAuthorizationEndpoint(),
            'token_endpoint' => $openIdProvider->getTokenEndpoint(),
            'userinfo_endpoint' => $openIdProvider->getUserInfoEndpoint(),
            'jwks_uri' => $openIdProvider->getJwksUri(),
            'scopes_supported' => $openIdProvider->getScopesSupported(),
            'response_types_supported' => $openIdProvider->getResponseTypesSupported(),
            'response_modes_supported' => $openIdProvider->getResponseModesSupported(),
            'grant_types_supported' => $openIdProvider->getGrantTypesSupported(),
            'subject_types_supported' => $openIdProvider->getSubjectTypesSupported(),
            'id_token_signing_alg_values_supported' => $openIdProvider->getIdTokenSigningAlgValuesSupported(),
            'request_uri_parameter_supported' => $openIdProvider->getRequestUriParameterSupported(),
        ];

        return response()->json(array_filter($config, function($item) {
            return $item !== NULL;
        }));
    }
}
