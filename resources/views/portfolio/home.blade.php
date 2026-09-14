<x-base-layout :title="$title ?? 'Portfolio'">
    <header class="site-header">
        <nav class="nav container">
            <a href="#" class="nav-brand">Mijn Portfolio</a>
            <ul class="nav-links">
                <li><a href="#about">Over mij</a></li>
                <li><a href="#skills">Vaardigheden</a></li>
                <li><a href="#projects">Projecten</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="container hero-content">
            <h1>Hallo, ik ben Nazar</h1>
            <p>Software Developer student</p>
            <div class="hero-actions">
                <a href="#projects" class="btn btn-primary">Mijn projecten</a>
            </div>
        </div>
    </section>

    <section id="about" class="section container">
        <h2>Over mij</h2>
        <p class="section-text">
            PLACEHOLDER.
        </p>
    </section>

    <section id="skills" class="section section-alt">
        <div class="container">
            <h2>Vaardigheden</h2>
            <div class="skills-grid">
                @foreach (['PHP', 'Laravel', 'CSS', 'C#'] as $skill)
                    <div class="skill-card">{{ $skill }}</div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="projects" class="section container">
        <h2>Projecten</h2>

        @if ($tags->isNotEmpty())
            <div class="tag-filter">
                <a href="{{ route('home') }}#projects" class="tag-badge {{ $activeTag ? '' : 'tag-badge-active' }}">Alle</a>
                @foreach ($tags as $tag)
                    <a href="{{ route('home', ['tag' => $tag->name]) }}#projects" class="tag-badge {{ $activeTag === $tag->name ? 'tag-badge-active' : '' }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <div class="projects-grid">
            @forelse ($projects as $project)
                <div class="project-card">
                    @if ($project->coverImage())
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($project->coverImage()) }}" alt="{{ $project->title }}" class="project-card-image">
                    @endif
                    <h3><a href="{{ route('projects.show', $project) }}" class="stretched-link">{{ $project->title }}</a></h3>
                    @if ($project->description)
                        <p>{{ $project->description }}</p>
                    @endif
                    @if ($project->tags->isNotEmpty())
                        <div class="tag-list">
                            @foreach ($project->tags as $tag)
                                <span class="tag-badge">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="project-card-actions">
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline">Bewerken</a>
                        <a href="{{ route('projects.delete', $project) }}" class="btn btn-outline">Verwijderen</a>
                    </div>
                </div>
            @empty
                <p class="section-text">Geen projecten gevonden voor deze tag.</p>
            @endforelse
        </div>
        <div class="hero-actions">
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Nieuw project</a>
        </div>
    </section>

    <section id="contact" class="contact-section">
        <div class="container contact-content">
            <h2>Neem contact op</h2>
            <a href="mailto:example@example.com" class="btn btn-light">example@example.com</a>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            &copy; {{ date('Y') }} Mijn Portfolio. Alle rechten voorbehouden.
        </div>
    </footer>
</x-base-layout>