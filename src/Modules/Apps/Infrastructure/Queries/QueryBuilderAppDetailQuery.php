<?php

namespace Modules\Apps\Infrastructure\Queries;

use Illuminate\Support\Facades\DB;
use Modules\Apps\Transformers\AppDetail\AppDetail;
use Modules\Apps\Transformers\AppDetail\AppDetailQueryInterface;

class QueryBuilderAppDetailQuery implements AppDetailQueryInterface
{
    public function execute(string $id): ?AppDetail
    {
        $result = DB::table('apps')->select(['id', 'name', 'redirect_uri'])->where('id', $id)->get();

        if(!$result || $result->count() !== 1) return null;

        $appDetail = $result[0];

        return new AppDetail($appDetail->id, $appDetail->name, $appDetail->redirect_uri);
    }
}