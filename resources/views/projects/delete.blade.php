<x-base-layout title="Project verwijderen">
    <div class="container form-page">
        <h1>Project verwijderen</h1>
        <p class="section-text">Weet je zeker dat je "{{ $project->title }}" wilt verwijderen? Dit kan niet ongedaan worden gemaakt.</p>

        <form method="POST" action="{{ route('projects.destroy', $project) }}" id="delete-project-form">
            @csrf
            @method('DELETE')

            <div class="form-group">
                <label for="confirm_title">Typ "{{ $project->title }}" om te bevestigen</label>
                <input type="text" id="confirm_title" name="confirm_title" value="{{ old('confirm_title') }}" data-expected-title="{{ $project->title }}" autocomplete="off" required>
                <p class="form-error" id="confirm-title-error" hidden>De ingevoerde naam komt niet overeen met de projectnaam.</p>
                @error('confirm_title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="confirm-delete-button">Verwijderen</button>
                <a href="{{ route('home') }}#projects" class="btn btn-outline">Annuleren</a>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const form = document.getElementById('delete-project-form');
            const input = document.getElementById('confirm_title');
            const error = document.getElementById('confirm-title-error');
            const expectedTitle = input.dataset.expectedTitle;

            form.addEventListener('submit', function (event) {
                if (input.value !== expectedTitle) {
                    event.preventDefault();
                    error.hidden = false;
                }
            });

            input.addEventListener('input', function () {
                error.hidden = true;
            });
        })();
    </script>
</x-base-layout>
