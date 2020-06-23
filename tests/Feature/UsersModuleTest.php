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
        $this->withoutExceptionHandling();
        
        $this->post('/usuarios/', $this->getValidData())
            ->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de laravel y Vue',
            'twitter' => 'https://twitter.com/silecnce',
            'user_id' => User::findByEmail('sabryrodriguez@gmail.com')->id
        ]);
    }

    /** @test */
    //El campo twitter es opcional

    function the_twitter_field_is_optional()
    {   
        $this->withoutExceptionHandling();
        
        $this->post('/usuarios/', $this->getValidData([
            'twitter' => null
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de laravel y Vue',
            'twitter' => null ,
            'user_id' => User::findByEmail('sabryrodriguez@gmail.com')->id
        ]);
    }

    /** @test */

    function the_name_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->getValidData([
                'name' => ''
            ]))->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo  name obligatorio']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */

    function the_email_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->getValidData([
                'email' => ''
            ]))
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }

     /** @test */
    
    function the_email_most_be_valid()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->getValidData([
                'email' => 'correo-no-valido'
            ]))
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }

     /** @test */
    
    function the_email_most_be_unique()
    {
        factory(User::class)->create([
            'email' => 'sabryrodriguez@gmail.com'
        ]);

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->getValidData([
                'email' => 'sabryrodriguez@gmail.com'
            ]))
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

          $this->assertEquals(1,User::count());
    }

    /** @test */
    
    function the_password_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->getValidData([
                'password' => ''
            ]))->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['password']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function it_load_the_edit_user_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->get("/usuarios/{$user->id}/editar") // usuarios/5/editar
                ->assertStatus(200)
                ->assertViewIs('users.edit')
                ->assertSee('Editar Usuario')
                ->assertViewHas('user', function ($viewUser) use ($user) {
                    return $viewUser->id === $user->id;
                });
    }

    /** @test */
    function it_updates_a_new_user()
    {
        $user = factory(User::class)->create();

        $this->withoutExceptionHandling();

        $this->put("/usuarios/{$user->id}", [
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ]);         
    }

    /** @test */
    function the_name_is_required_when_update_the_user()
    {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}",[
                'name' => '',
                'email' => 'sabryrodriguez@gmail.com',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', ['email' => 'sabryrodriguez@gmail.com']);
    }

     /** @test */
    
     function the_email_most_be_valid_when_updating_the_user()
     {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}",[
                'name' => 'Alfredo Yepez',
                'email' => 'correo-no-valido',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', ['name' => 'Alfredo Yepez']);
     }
 
      /** @test */
     
     function the_email_most_be_unique_when_updating_the_user()
     {
        factory(User::class)->create([
            'email' => 'existing-email@example.com',
        ]);

        $user = factory(User::class)->create([
             'email' => 'sabryrodriguez@gmail.com'
        ]);
 
        $this->from("usuarios/{$user->id}/editar ")
             ->put("usuarios/{$user->id}", [
             'name' => 'Alfredo',
             'email' => 'existing-email@example.com',
             'password' => '123456'
        ])->assertRedirect("usuarios/{$user->id}/editar ")
           ->assertSessionHasErrors(['email']);
     }
 
     /** @test */
     
     function the_password_is_optional_when_updating_the_user()
     {
        $oldPassword = 'CLAVE_ANTERIOR';

        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword)
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
             'name' => 'Alfredo',
             'email' => 'sabryrodriguez@gmail.com',
             'password' => ''
        ])
        ->assertRedirect("usuarios/{$user->id}"); //(users.show)
 
        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => $oldPassword         //Muy importante
        ]);
     }
 
      /** @test */
     
      function the_users_email_can_stay_the_same_when_updating_the_user()
      {
 
         $user = factory(User::class)->create([
             'email' => 'sabryrodriguez@gmail.com'
         ]);
 
         $this->from("usuarios/{$user->id}/editar")
             ->put("usuarios/{$user->id}", [
              'name' => 'Jesus Yepez',
              'email' => 'sabryrodriguez@gmail.com',
              'password' => '12345678'
         ])
         ->assertRedirect("usuarios/{$user->id}");
  
         $this->assertDatabaseHas('users', [
             'name' => 'Jesus Yepez',
             'email' => 'sabryrodriguez@gmail.com'
         ]);
      }

      /** @test*/

    function it_deletes_a_user()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->delete("usuarios/{$user->id}")
            ->assertRedirect('usuarios');

        $this->assertDatabaseMissing('users' , [
            'id' => $user->id
        ]);
    }

    protected function getValidData (array $custom = [])
    {
        return array_filter(array_merge([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456',
            'bio' => 'Programador de laravel y Vue',
            'twitter' => 'https://twitter.com/silecnce'
        ], $custom));
    }

}
