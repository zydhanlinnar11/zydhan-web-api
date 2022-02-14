<?php

namespace App\Auth\Http\Controllers;

use App\Auth\Services\RegisterUser\RegisterUserRequest;
use App\Auth\Services\RegisterUser\RegisterUserService;
use App\Http\Controllers\Controller;
use Domain\Auth\Exceptions\AbstractDomainException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private RegisterUserService $registerUserService
    ) { }

    public function register(Request $request) {
        $validated = $this->validate($request, RegisterUserRequest::validationRule);

        try {
            $registerUserRequest = new RegisterUserRequest(
                name: $validated['name'],
                email: $validated['email'],
                username: $validated['username'],
                password: $validated['password'],
            );
    
            $this->registerUserService->execute($registerUserRequest);
    
            return response()->json(['status' => 'success', 'data' => null]);
        } catch(AbstractDomainException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }
    }
}
