<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $activeTag = $request->query('tag');

        $projects = Project::with(['images', 'tags'])
            ->when($activeTag, function ($query, $activeTag) {
                $query->whereHas('tags', fn ($query) => $query->where('name', $activeTag));
            })
            ->latest()
            ->get();

        return view('portfolio.home', [
            'title' => 'Portfolio',
            'projects' => $projects,
            'tags' => Tag::orderBy('name')->get(),
            'activeTag' => $activeTag,
        ]);
    }
}
