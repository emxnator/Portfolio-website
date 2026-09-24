<x-base-layout title="Inloggen">
    <div class="container form-page">
        <h1>Inloggen</h1>

        @if ($errors->any())
            <div class="form-group">
                @foreach ($errors->all() as $error)
                    <p class="form-error">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="form-group">
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>

            <div class="form-group">
                <label class="form-checkbox-label">
                    <input type="checkbox" name="remember" value="1"> Onthoud mij
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Inloggen</button>
                <a href="{{ route('home') }}" class="btn btn-outline">Annuleren</a>
            </div>
        </form>
    </div>
</x-base-layout>
