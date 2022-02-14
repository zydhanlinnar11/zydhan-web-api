<?php

namespace Domain\Auth\Services;

interface HashServiceInterface
{
    public function generate(string $text): string;
}