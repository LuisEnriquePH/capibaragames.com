<?php include 'includes/header.php'; ?>

    <section class="hero">
        <div class="hero__overlay"></div>
        <video class="hero__video" src="assets/uploads/videos/0321.mp4" autoplay loop muted playsinline></video>
        
        <div class="hero__content">
            <h1 class="hero__title">CAPIBARA GAMES</h1>
            <h2 class="hero__slogan">NO SE TRATA DE ENCAJAR, SE TRATA DE SER.</h2>
        </div>
    </section>

    <section class="updates" id="updates">
        <h2 class="section-title">ÚLTIMAS NOVEDADES</h2>
        
        <div class="cards-grid">
            
            <article class="card card--video">
                <div class="card__header">
                    <span class="badge badge--youtube">NUEVO VIDEO</span>
                </div>
                <div class="card__media" id="youtube-container">
                    <div class="placeholder-video">Cargando último video...</div>
                </div>
                <div class="card__body">
                    <h3 class="card__title">Devlog: Avances en Void Box</h3>
                    <a href="https://www.youtube.com/@CapibaraGamesDev" target="_blank" class="btn btn--primary">Ver en YouTube</a>
                </div>
            </article>

            <article class="card card--blog">
                <div class="card__header">
                    <span class="badge badge--blog">BLOG</span>
                </div>
                <div class="card__media">
                    <img src="assets/uploads/images/Logotipo.png" alt="Blog Post Image" class="card__img">
                </div>
                <div class="card__body">
                    <h3 class="card__title">Diseñando sistemas de inventario</h3>
                    <p class="card__excerpt">Descubre cómo gestionamos los items en nuestro último proyecto usando Godot.</p>
                    <a href="#" class="btn btn--secondary">Leer Artículo</a>
                </div>
            </article>

            <article class="card card--game">
                <div class="card__header">
                    <span class="badge badge--game">JUEGO</span>
                </div>
                <div class="card__media">
                    <img src="https://placehold.co/600x400/333/85D13E?text=Void+Box" alt="Void Box Game" class="card__img">
                </div>
                <div class="card__body">
                    <h3 class="card__title">Void Box</h3>
                    <p class="card__excerpt">Una experiencia roguelite en desarrollo.</p>
                    <a href="https://capibaragamesitchio.itch.io/" target="_blank" class="btn btn--accent">Jugar Ahora</a>
                </div>
            </article>

        </div>
    </section>

<?php include 'includes/footer.php'; ?>