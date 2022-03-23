<?php

namespace Modules\Apps\Domain\Models\Entity;

use Modules\Apps\Domain\Models\Value\AppId;

class App
{
    public function __construct(
        private AppId $id,
        private string $name,
        private string $redirectURI,
    ) { }

    public function getId(): AppId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRedirectURI(): string
    {
        return $this->redirectURI;
    }

    public function changeName(string $name)
    {
        $this->name = $name;
    }

    public function changeRedirectURI(string $name)
    {
        $this->name = $name;
    }
}