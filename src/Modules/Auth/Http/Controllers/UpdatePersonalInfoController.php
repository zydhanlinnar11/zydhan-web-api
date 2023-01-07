<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\UpdatePersonalInfoRequest;

class UpdatePersonalInfoController extends Controller
{
    public function update(UpdatePersonalInfoRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $user->setName($request->getName());
        $user->setEmail($request->getEmail());
        $user->save();

        return response()->json([], 204);
    }
}