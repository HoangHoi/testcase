<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class AuthTest extends TestCase
{

//    use DatabaseTransactions;
    public function testPostLogin()
    {
        $this->createUserData();
        $dataPass = $this->getDataLoginPass();
        $dataFail = $this->getDataLoginFail();
        foreach ($dataPass as $data) {
            $this->userLogout();
            $this->postLoginPass($data);
        }

        foreach ($dataFail as $data) {
            $this->userLogout();
            $this->postLoginFail($data);
        }
    }

    public function testGetLogin()
    {
        $this->createUserData();
        $dataPass = $this->getDataLoginPass();
        $dataFail = $this->getDataLoginFail();
        foreach ($dataPass as $data) {
            $this->getLoginPass($data);
        }

        foreach ($dataFail as $data) {
            $this->getLoginFail($data);
        }
    }

    public function getLogin($param)
    {
        $this->userLogout();
        $this->visit('login')
        ->type($param['email'], 'email')
        ->type($param['password'], 'password')
        ->press('Login');
    }

    public function getLoginPass($param)
    {
        $this->getLogin($param);
        $this->seePageIs('home');
        $this->assertTrue(Auth::guard()->check());
    }

    public function getLoginFail($param)
    {
        $this->getLogin($param);
        $this->seePageIs('login');
        $this->assertFalse(Auth::guard()->check());
    }

    public function testGetRegister()
    {
        $this->userLogout();
        $this->createUserData();
        $dataPass = $this->getDataRegisterPass();
        $dataFail = $this->getDataRegisterFail();
        foreach ($dataPass as $data) {
            $this->getRegisterPass($data);
        }

        foreach ($dataFail as $data) {
            $this->getRegisterFail($data);
        }
    }

    public function testGetLogout()
    {
        $this->userLogout();
        $this->getLoginPass($this->getDataLoginPass()[0]);
        $this->visit('logout');
        $this->seePageIs('login');
        $this->assertFalse(Auth::guard()->check());
    }

    public function getRegister($param)
    {
        $this->visit('/register')
        ->type($param['name'], 'name')
        ->type($param['email'], 'email')
        ->type($param['password'], 'password')
        ->type($param['password_confirmation'], 'password_confirmation')
        ->press('Register');
    }

    public function getRegisterPass($param)
    {
        $this->getRegister($param);
        $this->seePageIs('login');
    }

    public function getRegisterFail($param)
    {
        $this->getRegister($param);
        $this->seePageIs('register');
    }

    public function testPostRegister()
    {
        $this->createUserData();
        $dataPass = $this->getDataRegisterPass();
        Auth::guard()->logout();
        foreach ($dataPass as $data) {
            $this->postRegisterPass($data);
        }
    }

    public function postRegisterPass($param)
    {
        $this->post('register', $param);
        $this->assertRedirectedToRoute('get.login');
    }

    public function postLoginPass($data)
    {
        $this->post('login', $data);
        $this->assertTrue(Auth::guard()->check());
        $this->assertRedirectedToRoute('home');
    }

    public function postLoginFail($data)
    {
        $this->post('login', $data);
        $this->assertFalse(Auth::guard()->check());
    }

    public function userLogout()
    {
        return Auth::guard()->logout();
    }

    public function createUserData()
    {
        User::query()->truncate();
        User::insert([
            [
                'name' => 'test1',
                'email' => 'test1@gmail.com',
                'password' => bcrypt('test1'),
            ],
            [
                'name' => 'test2',
                'email' => 'test2@gmail.com',
                'password' => bcrypt('test2'),
            ]
        ]);
    }

    public function getDataLoginPass()
    {
        return [
            [
                'email' => 'test1@gmail.com',
                'password' => 'test1'
            ],
            [
                'email' => 'test2@gmail.com',
                'password' => 'test2'
            ],
        ];
    }

    public function getDataLoginFail()
    {
        return [
            [
                'email' => 'test1@gmail.com',
                'password' => '12345'
            ],
            [
                'email' => 'test2@gmail.com',
                'password' => 'abcdef'
            ],
            [
                'email' => '',
                'password' => 'test2'
            ],
            [
                'email' => '',
                'password' => ''
            ],
        ];
    }

    public function getDataRegisterPass()
    {
        return [
            [
                'name' => 'test3',
                'email' => 'test3@gmail.com',
                'password' => 'test3333',
                'password_confirmation' => 'test3333',
            ],
            [
                'name' => 'test44444',
                'email' => 'test4@gmail.com',
                'password' => 'test44444',
                'password_confirmation' => 'test44444',
            ],
        ];
    }

    public function getDataRegisterFail()
    {
        return [
            [
                'name' => 'test',
                'email' => 'abc',
                'password' => '',
                'password_confirmation' => '',
            ],
            [
                'name' => 'test1',
                'email' => 'test1@gmail.com',
                'password' => 'test1234',
                'password_confirmation' => 'test1234',
            ],
            [
                'name' => 'test555',
                'email' => 'test5@gmail.com',
                'password' => 'test',
                'password_confirmation' => 'test123',
            ],
        ];
    }

}
