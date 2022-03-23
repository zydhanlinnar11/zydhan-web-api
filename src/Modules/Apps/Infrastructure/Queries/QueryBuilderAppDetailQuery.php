<?php

namespace Modules\Apps\Infrastructure\Queries;

use Illuminate\Support\Facades\DB;
use Modules\Apps\Transformers\AppDetail\AppDetail;
use Modules\Apps\Transformers\AppDetail\AppDetailQueryInterface;

class QueryBuilderAppDetailQuery implements AppDetailQueryInterface
{
    public function execute(): ?AppDetail
    {
        $result = DB::table('apps')->select(['id', 'name', 'redirect_uri'])->get();

        if(!$result || $result->count() !== 1) return null;

        return new AppDetail($result[0]['id'], $result[0]['name'], $result[0]['redirect_uri']);
    }
}