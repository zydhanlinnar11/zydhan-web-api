<?php

namespace Modules\OAuth\Entities;

final class OpenIdProvider
{
    /**
     * @param string $issuer
     * @param string $authorizationEndpoint
     * @param string $tokenEndpoint
     * @param string $jwksUri
     * @param string[] $responseTypesSupported
     * @param string[] $subjectTypesSupported
     * @param string[] $idTokenSigningAlgValuesSupported
     * @param string $userInfoEndpoint
     * @param string[]|null $scopesSupported
     * @param ?string $responseModesSupported,
     * @param ?string $grantTypesSupported,
     * @param ?bool $requestUriParameterSupported
     */
    public function __construct(
        private string $issuer,
        private string $authorizationEndpoint,
        private string $tokenEndpoint,
        private string $jwksUri,
        private array $responseTypesSupported,
        private array $subjectTypesSupported,
        private array $idTokenSigningAlgValuesSupported,
        private ?string $userInfoEndpoint = NULL,
        private ?array $scopesSupported = NULL,
        private ?array $responseModesSupported = NULL, 
        private ?array $grantTypesSupported = NULL,
        private ?bool $requestUriParameterSupported = NULL
    ) { }
    
    public function getIssuer(): string
    {
        return $this->issuer;
    }
    
    public function getAuthorizationEndpoint(): string
    {
        return $this->authorizationEndpoint;
    }
    
    public function getTokenEndpoint(): string
    {
        return $this->tokenEndpoint;
    }
    
    public function getJwksUri(): string
    {
        return $this->jwksUri;
    }
    
    /**
     * @return string[]
     */
    public function getResponseTypesSupported(): array
    {
        return $this->responseTypesSupported;
    }
    
    /**
     * @return string[]
     */
    public function getSubjectTypesSupported(): array
    {
        return $this->subjectTypesSupported;
    }
    
    /**
     * @return string[]
     */
    public function getIdTokenSigningAlgValuesSupported(): array
    {
        return $this->idTokenSigningAlgValuesSupported;
    }
    
    public function getUserInfoEndpoint(): ?string
    {
        return $this->userInfoEndpoint;
    }
    
    /**
     * @return string[]|null
     */
    public function getScopesSupported(): array
    {
        return $this->scopesSupported;
    }
    
    /**
     * @return string[]|null
     */
    public function getResponseModesSupported(): ?array
    {
        return $this->responseModesSupported;
    }
    
    /**
     * @return string[]|null
     */
    public function getGrantTypesSupported(): ?array
    {
        return $this->grantTypesSupported;
    }
    
    public function getRequestUriParameterSupported(): ?bool
    {
        return $this->requestUriParameterSupported;
    }
}