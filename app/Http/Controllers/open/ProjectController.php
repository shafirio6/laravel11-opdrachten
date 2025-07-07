<?php

namespace App\Http\Controllers\open;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::paginate(10);
        return view('open.projects.index', ['projects'=> $projects]);
    }
}
