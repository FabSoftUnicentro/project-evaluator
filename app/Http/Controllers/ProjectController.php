<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $projectsNotEvaluated = Project::notEvaluatedBy($request->user())->get();

        return view('home', [
            'projectsNotEvaluated'=> $projectsNotEvaluated
        ]);
    }
}
