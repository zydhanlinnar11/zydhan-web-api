<?php

namespace Modules\Apps\Transformers\AppDetail;

interface AppDetailQueryInterface
{
    public function execute(): ?AppDetail;
}