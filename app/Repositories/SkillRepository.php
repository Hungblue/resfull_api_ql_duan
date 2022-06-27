<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserSkill;
use App\Repositories\Repository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class SkillRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\UserSkill::class;
    }
    public function getAllSkill()
    {
        $skill = $this->getAll();
        return $skill;
    }
    public function getSkill($id)
    {
        $user = User::find($id);
        $skill = UserSkill::where('user_id', $user->id)->get();
        $skill->load('nameSkill');
        return $skill;
    }
}
