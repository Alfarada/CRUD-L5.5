<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\{Skill, User};
use App\Model\Profession;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Alfredo',
        'email' => 'sabryrodriguez@gmail.com',
        'password' => '123456',
        'profession_id' => '',
        'bio' => 'Programador de laravel y Vue',
        'twitter' => 'https://twitter.com/silecnce',
        'role' => 'user'
    ];

    /** @test */

    function the_twitter_field_is_optional()
    {
        $this->post('/usuarios', $this->withData([
            'twitter' => null
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de laravel y Vue',
            'twitter' => null,
            'user_id' => User::findByEmail('sabryrodriguez@gmail.com')->id
        ]);
    }

    /** @test */

    function the_role_field_is_optional()
    {
        $this->post('/usuarios', $this->withData([
            'role' => null
        ]))->assertRedirect('usuarios');

        $this->assertDatabaseHas('users', [
            'email' => 'sabryrodriguez@gmail.com',
            'role' => 'user'
        ]);
    }

    /** @test */

    function the_role_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->post('/usuarios', $this->withData([
            'role' => 'invalid-role'
        ]))->assertSessionHasErrors('role');

        $this->assertDatabaseEmpty('users');
    }


    /** @test */

    function the_profession_id_field_is_optional()
    {
        $this->post('/usuarios/', $this->withData([
            'profession_id' => '',
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456'
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de laravel y Vue',
            'user_id' => User::findByEmail('sabryrodriguez@gmail.com')->id,
            'profession_id' => null
        ]);
    }

    /** @test */

    function the_email_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->withData([
                'email' => ''
            ]))
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */

    function the_password_is_required()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->withData([
                'password' => ''
            ]))->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['password']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_profession_must_be_valid()
    {
        $this->withExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->withData([
                'profession_id' => '999'
            ]))
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function only_not_deleted_professions_can_be_selected()
    {
        $deletedProfession = factory(Profession::class)->create([
            'deleted_at' => now()->format('Y-m-d')
        ]);

        $this->withExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->withData([
                'profession_id' => $deletedProfession->id
            ]))
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_skills_must_be_an_array()
    {
        $this->handleValidationExceptions();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->withData([
                'skills' => 'PHP, JS'
            ]))
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['skills']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function the_skills_must_be_valid()
    {
        $this->handleValidationExceptions();

        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', $this->withData([
                'skills' => [$skillA->id, $skillB->id + 1]
            ]))
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['skills']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function it_load_the_edit_user_page()
    {
        $user = factory(User::class)->create();

        $this->get("/usuarios/{$user->id}/editar")
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
    function the_name_is_required()
    {
        $this->handleValidationExceptions();

        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => '',
                'email' => 'sabryrodriguez@gmail.com',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', ['email' => 'sabryrodriguez@gmail.com']);
    }

    /** @test */

    function the_email_must_be_valid()
    {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Alfredo Yepez',
                'email' => 'correo-no-valido',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', ['name' => 'Alfredo Yepez']);
    }

    /** @test */

    function the_email_must_be_unique()
    {   
        $this->handleValidationExceptions();

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

    function the_password_is_optional()
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

    function the_users_email_can_stay_the_same()
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


}
