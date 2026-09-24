<x-base-layout title="Berichten">
    <div class="container form-page">
        <div class="messages-header">
            <h1>Berichten</h1>
            <a href="{{ route('home') }}" class="btn btn-outline">&larr; Terug naar site</a>
        </div>

        @forelse ($messages as $message)
            <div class="message-card">
                <div class="message-card-header">
                    <strong>{{ $message->name }}</strong>
                    <span class="message-card-date">{{ $message->created_at->format('d-m-Y H:i') }}</span>
                </div>
                <a href="mailto:{{ $message->email }}" class="message-card-email">{{ $message->email }}</a>
                <p class="message-card-body">{{ $message->message }}</p>
            </div>
        @empty
            <p class="section-text">Nog geen berichten ontvangen.</p>
        @endforelse
    </div>
</x-base-layout>
