<x-base-layout title="Project bewerken">
    <div class="container form-page">
        <h1>Project bewerken</h1>

        <form method="POST" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Titel</label>
                <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required>
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Beschrijving</label>
                <textarea id="description" name="description">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" id="tags" name="tags" value="{{ old('tags', $project->tags->pluck('name')->implode(', ')) }}" placeholder="bijv. Laravel, PHP, Frontend">
                <p class="form-hint">Scheid meerdere tags met een komma.</p>
                @error('tags')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Huidige afbeeldingen</label>
                @forelse ($project->images as $image)
                    <div class="form-image-item">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($image->path) }}" alt="{{ $project->title }}" class="form-image-preview">
                        <label class="form-image-remove">
                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}">
                            Verwijderen
                        </label>
                    </div>
                @empty
                    <p class="section-text">Nog geen afbeeldingen toegevoegd.</p>
                @endforelse
            </div>

            <div class="form-group">
                <label for="images">Nieuwe afbeeldingen toevoegen</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple>
                @error('images.*')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Opslaan</button>
                <a href="{{ route('home') }}#projects" class="btn btn-outline">Annuleren</a>
            </div>
        </form>
    </div>
</x-base-layout>
