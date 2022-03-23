<?php

namespace Modules\Apps\Domain\Repositories;

use Modules\Apps\Domain\Models\Entity\App;
use Modules\Apps\Domain\Models\Value\AppId;

interface AppRepositoryInterface
{
    public function save(App $app): App;
}