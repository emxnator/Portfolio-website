<x-base-layout title="Project verwijderen">
    <div class="container form-page">
        <h1>Project verwijderen</h1>
        <p class="section-text">Weet je zeker dat je "{{ $project->title }}" wilt verwijderen? Dit kan niet ongedaan worden gemaakt.</p>

        <form method="POST" action="{{ route('projects.destroy', $project) }}">
            @csrf
            @method('DELETE')

            <div class="form-group">
                <label for="confirm_title">Typ "{{ $project->title }}" om te bevestigen</label>
                <input type="text" id="confirm_title" name="confirm_title" value="{{ old('confirm_title') }}" autocomplete="off" required>
                @error('confirm_title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Verwijderen</button>
                <a href="{{ route('home') }}#projects" class="btn btn-outline">Annuleren</a>
            </div>
        </form>
    </div>
</x-base-layout>
