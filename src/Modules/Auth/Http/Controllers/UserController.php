<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\SocialProvider;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Facade\Auth;
use Modules\Auth\Http\Requests\ChangePasswordRequest;
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

    public function unlinkSocialAccount(Request $request, SocialProvider $social_provider)
    {
        $user = Auth::user($request);
        if ($social_provider === SocialProvider::GOOGLE) {
            $user->unlinkGoogleAccount();
        } else {
            $user->unlinkGithubAccount();
        }

        $this->userRepository->save($user);
        return response()->json(null);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user($request);
        $validated = $request->validated();
        $current_password = $validated['current_password'];
        $new_password = $validated['new_password'];

        if(!$user->isPasswordCorrect($current_password)) {
            abort(403);
        }

        $user->changePassword($new_password);
        return response()->json(null);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email'),
        );
        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['message' => __($status)])
                    : response()->json(['message' => __($status)], 400);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->changePassword($password);
                
                $this->userRepository->save($user);
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? response()->json(['message' => __($status)])
                    : response()->json(['message' => __($status)], 400);
    }
}
