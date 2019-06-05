<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Project;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $evaluations = Evaluation::with(['project'])->createdBy($request->user())->get();

        return view('evaluation.index', [
            'evaluations' => $evaluations
        ]);
    }

    /**
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Project $project)
    {
        $this->authorize('evaluateProject', $project);

        return view('evaluation.create', [
            'project' => $project
        ]);
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('evaluateProject', $project);

        $this->validate($request, [
            'rating' => 'required|integer',
            'comment' => 'required|string'
        ]);

        try {
            Evaluation::create([
                'value' => $request->get('rating'),
                'comment' => $request->get('comment'),
                'user_id' => $request->user()->getKey(),
                'project_id' => $project->getKey()
            ]);

            return redirect()->route('home')->with([
                'alert-success' => 'Projeto avaliado com sucesso!'
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with([
                'alert-danger' => 'Falha ao avaliar projeto!'
            ]);
        }
    }
}
