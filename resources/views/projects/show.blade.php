<x-base-layout :title="$project->title">
    <div class="container form-page">
        <a href="{{ route('home') }}#projects" class="btn btn-outline">&larr; Terug naar projecten</a>

        <h1>{{ $project->title }}</h1>
        
        @if ($project->images->isNotEmpty())
            <div class="project-show-gallery">
                @foreach ($project->images as $image)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($image->path) }}" alt="{{ $project->title }}" class="project-show-image">
                @endforeach
            </div>
        @elseif ($project->image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($project->image) }}" alt="{{ $project->title }}" class="project-show-image">
        @endif

        @if ($project->description)
            <p class="section-text">{{ $project->description }}</p>
        @endif

        @if ($project->tags->isNotEmpty())
            <div class="tag-list">
                @foreach ($project->tags as $tag)
                    <a href="{{ route('home', ['tag' => $tag->name]) }}#projects" class="tag-badge">{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        @auth
            <div class="form-actions">
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">Bewerken</a>
                <a href="{{ route('projects.delete', $project) }}" class="btn btn-outline">Verwijderen</a>
            </div>
        @endauth
    </div>
</x-base-layout>
