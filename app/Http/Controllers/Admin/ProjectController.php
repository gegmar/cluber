<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUpdateProject;
use App\Project;

class ProjectController extends Controller
{
    public function create(CreateUpdateProject $request)
    {
        $project = new Project();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();
        return redirect()->route('admin.events.dashboard')
                        ->with('status', 'Created Project successfully!');
    }

    public function get(Project $project)
    {
        return view('admin.events.manage-project', [
            'project' => $project
        ]);
    }

    public function update(Project $project, CreateUpdateProject $request)
    {
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();
        return redirect()->route('admin.events.dashboard')
                        ->with('status', 'Updated Project successfully!');
    }

    public function delete(Project $project)
    {
        // check if events are associate with the to be deleted project
        // if yes do not delete and send back with errors
        if( $project->events()->exists() )
        {
            return redirect()->route('admin.events.project.get', $project)
                        ->with('status', 'Error on deletion: Project has events!');
        }
        $project->delete();
        return redirect()->route('admin.events.dashboard')
                        ->with('status', 'Deleted Project successfully!');
    }

    public function archive(Project $project)
    {
        $project->is_archived = true;
        $project->save();
        return redirect()->route('admin.events.dashboard')
                        ->with('status', 'Archived successfully!');
    }

    public function restore(Project $project)
    {
        $project->is_archived = false;
        $project->save();
        return redirect()->route('admin.events.dashboard')
                        ->with('status', 'Restored successfully!');
    }
}
