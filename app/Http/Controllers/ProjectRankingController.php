<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectRankingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::orderedByEvaluationAverage();

        return view('admin.home', [
            'projects' => $projects
        ]);
    }
}
