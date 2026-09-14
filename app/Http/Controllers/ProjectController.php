<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function create(): View
    {
        return view('projects.create');
    }

    public function show(Project $project): View
    {
        return view('projects.show', [
            'project' => $project->load(['images', 'tags']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        $project = Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        $this->storeImages($project, $request->file('images', []));
        $this->syncTags($project, $validated['tags'] ?? null);

        return redirect()->route('home')->with('status', 'Project aangemaakt.');
    }

    public function edit(Project $project): View
    {
        return view('projects.edit', [
            'project' => $project,
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['integer', 'exists:project_images,id'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        $project->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        $this->syncTags($project, $validated['tags'] ?? null);

        if (! empty($validated['remove_images'])) {
            $project->images()
                ->whereIn('id', $validated['remove_images'])
                ->get()
                ->each(function (ProjectImage $image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                });
        }

        $this->storeImages($project, $request->file('images', []));

        return redirect()->route('home')->with('status', 'Project bijgewerkt.');
    }

    public function delete(Project $project): View
    {
        return view('projects.delete', [
            'project' => $project,
        ]);
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        $request->validate([
            'confirm_title' => ['required', 'string', Rule::in([$project->title])],
        ], [
            'confirm_title.in' => 'De ingevoerde naam komt niet overeen met de projectnaam.',
        ]);

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        $this->pruneUnusedTags();

        return redirect()->route('home')->with('status', 'Project verwijderd.');
    }

    /**
     * @param  array<int, \Illuminate\Http\UploadedFile>  $images
     */
    private function storeImages(Project $project, array $images): void
    {
        $position = $project->images()->max('position') + 1;

        foreach ($images as $image) {
            $project->images()->create([
                'path' => $image->store('projects', 'public'),
                'position' => $position++,
            ]);
        }
    }

    private function syncTags(Project $project, ?string $tagsInput): void
    {
        $names = collect(explode(',', $tagsInput ?? ''))
            ->map(fn (string $name) => trim($name))
            ->filter()
            ->unique(fn (string $name) => strtolower($name));

        $tagIds = $names->map(function (string $name) {
            return Tag::firstOrCreate(['name' => $name])->id;
        });

        $project->tags()->sync($tagIds);

        $this->pruneUnusedTags();
    }

    private function pruneUnusedTags(): void
    {
        Tag::doesntHave('projects')->delete();
    }
}
