<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Repositories\Eloquents\UserRepository;

class UserRepositoryTest extends TestCase
{

    private $user;
    private $userRepository;

    public function __construct()
    {
        $this->user = new User;
    }

    public function testConstruct()
    {
        $this->userRepository = new UserRepository(new User);
        $this->assertTrue($this->userRepository instanceof UserRepository);

        return $this->userRepository;
    }

    /**
     * 
     * @depends testConstruct
     * @return void
     */
    public function testShowAll($userRepository)
    {
        $this->userRepository = $userRepository;
        $this->createUserData();
        $data = $this->userRepository->showAll();
        $this->assertInternalType('array', $data);
        $this->assertEquals(2, count($data));
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

}
