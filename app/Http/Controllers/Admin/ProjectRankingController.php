<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Http\Controllers\Controller;

class ProjectRankingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::orderedByEvaluationAverage();

        return view('admin.projects.ranking.index', [
            'projects' => $projects
        ]);
    }
}
