<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Facade\Auth as FacadeAuth;
use Modules\Auth\App\Services\RegisterUser\RegisterUserRequest;
use Modules\Auth\App\Services\RegisterUser\RegisterUserService;
use Modules\Auth\Domain\Exceptions\AbstractDomainException;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Transformers\AuthenticatedUserResource;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private RegisterUserService $registerUserService
    ) { }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(RegisterUserRequest::validationRule);

        try {
            $registerUserRequest = new RegisterUserRequest(
                name: $validated['name'],
                email: $validated['email'],
                password: $validated['password'],
            );

            $this->registerUserService->execute($registerUserRequest);

            return response()->json(['status' => 'success', 'data' => null], 201);
        } catch(AbstractDomainException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        } catch(\Exception $e) {
            if (env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error.'], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function login(LoginRequest $request) {
        try {
            if(Auth::attempt($request->safe(['email', 'password']))) {
                return response()->json(['status' => 'success', 'data' => null], 200);
            }

            return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        } catch(\Exception $e) {
            if (env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error.'], 500);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return response()->json(['status' => 'success', 'data' => null]);
    }

    public function getAuthenticatedUser(Request $request) {
        return (new AuthenticatedUserResource(FacadeAuth::user($request)))->toArray($request);
    }
}
