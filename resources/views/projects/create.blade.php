<x-base-layout title="Nieuw project">
    <div class="container form-page">
        <h1>Nieuw project</h1>

        <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Titel</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Beschrijving</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" id="tags" name="tags" value="{{ old('tags') }}" placeholder="bijv. Laravel, PHP, Frontend">
                <p class="form-hint">Scheid meerdere tags met een komma.</p>
                @error('tags')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="images">Afbeeldingen</label>
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
