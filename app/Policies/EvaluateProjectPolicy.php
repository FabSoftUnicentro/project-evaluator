<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluateProjectPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function evaluateProject(User $user, Project $project)
    {
        $evaluation = Evaluation::where([
            ['user_id', '=', $user->getKey()],
            ['project_id', '=', $project->getKey()]
        ])->count();

        return $evaluation === 0 && is_null($project->members()->find($user->getKey()));
    }
}
