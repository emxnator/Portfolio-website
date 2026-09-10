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
            <h1>Hallo, ik ben <span class="text-accent">Nazar</span></h1>
            <p>Software Developer student</p>
            <div class="hero-actions">
                <a href="#projects" class="btn btn-primary">Mijn projecten</a>
            </div>
        </div>
    </section>

    <section id="about" class="section container">
        <h2>Over mij</h2>
        <p class="section-text">
            Vertel hier iets over jezelf: wat je doet, welke ervaring je hebt
            en wat je inspireert in de ontwikkeling.
        </p>
    </section>

    <section id="skills" class="section section-alt">
        <div class="container">
            <h2>Vaardigheden</h2>
            <div class="skills-grid">
                @foreach (['PHP', 'Laravel', 'CSS'] as $skill)
                    <div class="skill-card">{{ $skill }}</div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="projects" class="section container">
        <h2>Projecten</h2>
        <div class="projects-grid">
            @for ($i = 1; $i <= 4; $i++)
                <div class="project-card">
                    <h3>Project {{ $i }}</h3>
                    <p>Korte beschrijving van het project en de gebruikte technologieën.</p>
                </div>
            @endfor
        </div>
    </section>

    <section id="contact" class="contact-section">
        <div class="container contact-content">
            <h2>Neem contact op</h2>
            <p>Ik bespreek graag een nieuw project of voorstel.</p>
            <a href="mailto:you@example.com" class="btn btn-light">you@example.com</a>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            &copy; {{ date('Y') }} Mijn Portfolio. Alle rechten voorbehouden.
        </div>
    </footer>
</x-base-layout>