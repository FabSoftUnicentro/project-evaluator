<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectEvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $evaluations = $project->evaluations()->with('user')->get();

        return view('admin.projects.evaluations.index', [
            'evaluations' => $evaluations,
            'project' => $project,
        ]);
    }
}
