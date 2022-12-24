<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Routing\Controller;
use Modules\Auth\Transformers\SocialMediaList;

class SocialMediaListController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return SocialMediaList::collection(SocialMedia::all());
    }
}
