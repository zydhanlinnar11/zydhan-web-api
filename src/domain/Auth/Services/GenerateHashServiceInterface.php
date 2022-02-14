<?php

namespace Domain\Auth\Services;

interface GenerateHashServiceInterface
{
    public function generate(string $text): string;
}