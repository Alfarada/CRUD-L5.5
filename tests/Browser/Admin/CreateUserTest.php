<?php

namespace Tests\Browser;

use App\{User,Skill};
use App\Model\Profession;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_be_created()
    {
        $profession = factory(Profession::class)->create();
        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->browse(function ( Browser $browser) use ($profession, $skillA, $skillB) {
            $browser->visit('usuarios/nuevo')
                ->assertSeeIn('h4','Crear usuario')
                ->type('name', 'Alfredo')
                ->type('email', 'hi@example.com')
                ->type('password', 'laravel')
                ->type('bio', 'programador')
                ->select('profession_id', $profession->id)
                ->type('twitter', 'https://twitter.com/Alfarada')
                ->check("skills[{$skillA->id}]")
                ->check("skills[{$skillB->id}]")
                ->radio('role','user')
                ->press('Crear Usuario')
                ->assertPathIs('/usuarios')
                ->assertSee('Alfredo')
                ->assertSee('hi@example.com');
        });

        $this->assertCredentials([
            'name' => 'Alfredo',
            'email' => 'hi@example.com',
            'password' => 'laravel',
            'role' => 'user'
        ]);

        $user = User::findByEmail('hi@example.com');

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'programador',
            'twitter' => 'https://twitter.com/Alfarada',
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

    }
}
