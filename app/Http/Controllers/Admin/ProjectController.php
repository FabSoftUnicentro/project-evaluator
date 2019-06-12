<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::with('members')->get();

        return view('admin.projects.index', [
            'projects' => $projects
        ]);
    }

    /**
     *
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'members' => 'array|distinct|nullable'
        ]);

        try {
            $project = new Project($request->only(['name']));

            $project->save();

            $members = $request->only(['members']);

            if ($members) {
                foreach ($members as $member) {
                    $project->members()->attach($member);
                }
            }

            $project->save();

            return response()->json($project->toArray());
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param Project $project
     */
    public function show(Project $project)
    {

    }

    /**
     * @param Project $project
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Project $project)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'members' => 'array|distinct|nullable'
        ]);

        try {
            $project->update($request->only(['name']));

            $members = $request->only(['members']);

            if ($members) {
                foreach ($members as $member) {
                    $project->members()->attach($member);
                }
            }

            $project->save();

            return response()->json($project->toArray());
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();

            return response()->json($project->toArray());
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
