<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    // use DatabaseMigrations;
    /**
     * A registration page test.
     *
     * @return void
     */
    public function testRegisterPageStatus()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }
    
    /**
     * A new user registration test.
     *
     * @return string
     */
    public function testNewUserRegistration()
    {
        $username = 'username';
        $this->visit('/register')
             ->type('TestUser', 'name')
             ->type($username, 'username')
             ->type('tester@tester.ru', 'email')
             ->type('testpassword', 'password')
             ->type('testpassword', 'password_confirmation')
             ->press('Регистрация')
             ->see(__('system.registration_success'));
        
        return $username;
    }
    
    /**
     * A new user registration with duplicated username test.
     * @depends testNewUserRegistration
     *
     * @param $username
     *
     * @return void
     */
    public function testDuplicateUsername($username)
    {
        $this->visit('/register')
             ->type('TestUser', 'name')
             ->type($username, 'username')
             ->type('tester@tester.ru', 'email')
             ->type('testpassword', 'password')
             ->type('testpassword', 'password_confirmation')
             ->press('Регистрация')
             ->see(__('system.errors_occurred'));
        $this->removeUser('tester');
    }
    
    protected function removeUser($username)
    {
        if ($user = User::where('username', '=', $username)->first()) {
            try{
                $user->delete();
            } catch (\Exception $e){
            
            }
        }
    }
    
    /**
     * A new user registration test.
     *
     * @return void
     */
    public function testShortPassword()
    {
        
        $this->visit('/register')
             ->type('TestUser', 'name')
             ->type('tester', 'username')
             ->type('tester@tester.ru', 'email')
             ->type('test', 'password')
             ->type('test', 'password_confirmation')
             ->press('Регистрация')
             ->see(__('system.errors_occurred'));
        $this->removeUser('tester');
        
    }
    
    /**
     * A new user registration test.
     *
     * @return void
     */
    public function testWrongEmail()
    {
        $this->visit('/register')
             ->type('TestUser', 'name')
             ->type('tester', 'username')
             ->type('tester', 'email')
             ->type('testpassword', 'password')
             ->type('testpassword', 'password_confirmation')
             ->press('Регистрация')
             ->see(__('system.errors_occurred'));
        $this->removeUser('tester');
        
    }
}
