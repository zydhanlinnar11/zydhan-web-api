<?php

namespace Modules\Blog\Transformers\PortfolioPosts;

use Modules\Blog\Transformers\HomePosts\PortfolioPostResource;

interface PortfolioPostsQueryInterface
{
    /**
     * @return PortfolioPostResource[]
     */
    public function execute();
}