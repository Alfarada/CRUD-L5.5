<?php

namespace Tests\Browser;

use App\Model\Profession;
use App\Skill;
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

        $this->browse(function ( Browser $browser, $browser2, $browser3) use ($profession, $skillA, $skillB) {
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
                ->press('Crear Usuario');

                $browser2->visit('/usuarios')
                    ->assertSee('Alfredo')
                    ->assertSee('hi@example.com');
        });
    }
}
