<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\StoreSocialMediaRequest;
use Modules\Admin\Http\Requests\UpdateSocialMediaRequest;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return SocialMedia::all(['id', 'name', 'created_at', 'socialite_name']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Admin\Requests\StoreSocialMediaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSocialMediaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SocialMedia  $social_medium
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SocialMedia $social_medium)
    {
        return $social_medium;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Admin\Http\Requests\UpdateSocialMediaRequest  $request
     * @param  \App\Models\SocialMedia  $social_medium
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSocialMediaRequest $request, SocialMedia $social_medium)
    {
        $social_medium->setName($request->getName());
        $social_medium->setSocialiteName($request->getSocialiteName());
        $social_medium->setClientId($request->getClientId());
        $social_medium->setClientSecret($request->getClientSecret());
        $social_medium->save();

        return response()->json([], 204);
    }
}
