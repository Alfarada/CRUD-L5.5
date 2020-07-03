<?php

namespace App\Http\ViewComponents;

use App\{User, Skill};
use App\Model\Profession;
use Illuminate\Contracts\Support\Htmlable;

class UserFields implements Htmlable
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toHtml()
    {
        return view('users._fields',[
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
            'roles' => trans('users.roles'),
            'user' => $this->user
        ]);
    }
}
