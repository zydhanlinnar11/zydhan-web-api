<?php

namespace Modules\Auth\Domain\Services;

interface HashServiceInterface
{
    public function generate(string $text): string;
}