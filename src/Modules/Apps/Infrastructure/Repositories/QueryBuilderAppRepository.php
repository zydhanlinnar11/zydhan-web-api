<?php

namespace Modules\Apps\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Apps\Domain\Models\Entity\App;
use Modules\Apps\Domain\Repositories\AppRepositoryInterface;

class QueryBuilderAppRepository implements AppRepositoryInterface
{
    public function save(App $app): App
    {
        DB::table('apps')->updateOrInsert([
            'id' => $app->getId()->getId()
        ], [
            'id' => $app->getId()->getId(),
            'name' => $app->getName(),
            'redirect_uri' => $app->getRedirectURI(),
        ]);

        return $app;
    }
}