<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepository;
use App\Http\Requests\CreateUserRequest;
use Auth;

class AuthController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->userRepository = $userRepository;
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {

        $loginSuccess = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$loginSuccess) {
            return redirect()->back()->withErrors([
                'message' => trans('auth.failed')
            ]);
        }

        return redirect()->route('home')->with([
            'message' => trans('auth.success'),
        ]);
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(CreateUserRequest $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
        ]);

        $result = $this->userRepository->create($data);

        if ($result['status']) {
            return redirect()->route('get.login')->with([
                'message' => trans('auth.register.success'),
            ]);
        }
        
        return redirect()->route('get.register')->withErrors([
            'message' => trans('auth.register.fail'),
        ]);
    }

    public function getLogout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->route('get.login');
    }

}
