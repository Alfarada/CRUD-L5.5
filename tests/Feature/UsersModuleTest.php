<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Model\Profession;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test */
    function it_loads_the_users_list_page()
    {
        
        factory(User::class)->create([
            'name' => 'Bob',
        ]);

        factory(User::class)->create([
            'name' => 'Ted' 
        ]);

        $this->get('/usuarios')
        		->assertStatus(200)
        		->assertSee('listado de usuarios')
                ->assertSee('Bob')
                ->assertSee('Ted');
    }
    
    /** @test */
    function it_display_the_users_details()
    {
        $user = factory(User::class)->create([
            'name' => 'Alfredo Yepez'
        ]);

    	$this->get('/usuarios/'.$user->id) //usuario 5
    			->assertStatus(200)
    			->assertSee('Alfredo Yepez');
    }

    /**
    * @test */
    function it_show_a_default_message_if_the_users_list_is_empty()
    {
        //DB::table('users')->truncate();

        $this->get('/usuarios')
                ->assertStatus(200)
                ->assertSee('No hay usuarios registrados');
    }

     /** @test */
    function it_load_the_new_user_page()
    {
        $this->get('/usuarios/nuevo')
                ->assertStatus(200)
                ->assertSee('Crear Usuario');
    }

     /** @test */
    function it_displays_a_404_error_if_the_user_is_not_found()
    {
    	$this->get('/usuarios/999')
    			->assertStatus(404)
    			->assertSee('Página no encontrada');
    }

    /** @test */
    function it_creates_a_new_user()
    {
        $this->post('/usuarios/', [
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ])->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ]);         
    }

    /** @test */

    function the_name_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => '',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['name' => 'El campo  name obligatorio']);

//        $this->assertDatabaseMissing('users', [
//            'email' => 'sabryrodriguez@gmail.com',
//        ]);

          $this->assertEquals(0,User::count());
    }

    /** @test */

    function the_email_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => 'Alfredo',
            'email' => '',
            'password' => '123456'
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['email']);

          $this->assertEquals(0,User::count());
    }

     /** @test */
    
    function the_email_most_be_valid()
    {
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => 'Alfredo',
            'email' => 'correo-no-valido',
            'password' => '123456'
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['email']);

          $this->assertEquals(0,User::count());
    }

     /** @test */
    
    function the_email_most_be_unique()
    {
        factory(User::class)->create([
            'email' => 'sabryrodriguez@gmail.com'
        ]);

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['email']);

          $this->assertEquals(1,User::count());
    }

    /** @test */
    
    function the_password_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => ''
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['password']);

          $this->assertEquals(0,User::count());
    }

    

}
