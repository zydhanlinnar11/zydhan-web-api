<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Facade\Auth;
use Modules\Auth\Http\Requests\UpdateUserInfoRequest;
use Modules\Auth\Transformers\UserResource;

class UserController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) { }

    /**
     * Show the specified resource.
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        $user = Auth::user($request);

        return (new UserResource($user))->toArray($request);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateUserInfoRequest $request
     * @return Response
     */
    public function update(UpdateUserInfoRequest $request)
    {
        $user = Auth::user($request);
        $user->changeName($request->input('name'));
        $user->changeEmail($request->input('email'));

        $this->userRepository->save($user);
        return response()->json(null);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
