<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\{User, Skill};
use App\Model\Profession;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Alfredo',
        'email' => 'sabryrodriguez@gmail.com',
        'password' => '123456',
        'bio' => 'Programador de laravel y Vue',
        'profession_id' => '',
        'twitter' => 'https://twitter.com/silecnce',
        'role' => 'user'
    ];

    /** @test */
    function it_loads_the_new_user_page()
    {
        $profession = factory(Profession::class)->create();

        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear Usuario')
            ->assertViewHas('professions', function ($professions) use ($profession) {
                return $professions->contains($profession);
            })
            ->assertViewHas('skills', function ($skills) use ($skillA, $skillB) {
                return $skills->contains($skillA) && $skills->contains($skillB);
            });
    }

    /** @test */
    function it_creates_a_new_user()
    {
        $profession = factory(Profession::class)->create();

        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();
        $skillC = factory(Skill::class)->create();

        $this->post('/usuarios/', $this->withData([
            'skills' => [$skillA->id, $skillB->id],
            'profession_id' => $profession->id
        ]))
            ->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'sabryrodriguez@gmail.com',
            'password' => '123456',
            'role' => 'user'
        ]);

        $user = User::findByEmail('sabryrodriguez@gmail.com');

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de laravel y Vue',
            'twitter' => 'https://twitter.com/silecnce',
            'user_id' => $user->id,
            'profession_id' => $profession->id
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillA->id
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillB->id
        ]);

        $this->assertDatabaseMissing('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillC->id
        ]);
    }

    /** @test */
    function the_user_is_redirected_to_the_previus_page_when_the_validation_fails()
    {
        $this->handleValidationExceptions();

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [])
            ->assertRedirect('usuarios/nuevo');

        $this->assertDatabaseEmpty('users');
    }
}
