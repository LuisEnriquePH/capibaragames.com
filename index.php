<?php 
include 'includes/db.php'; // Conexión a la BD
include 'includes/header.php'; 

// 1. OBTENER ÚLTIMO JUEGO
try {
    $stmtGame = $pdo->query("SELECT * FROM games ORDER BY release_date DESC LIMIT 1");
    $latestGame = $stmtGame->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $latestGame = null;
}

// 2. OBTENER ÚLTIMO POST (BLOG)
try {
    $stmtPost = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 1");
    $latestPost = $stmtPost->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $latestPost = null;
}
?>

    <!-- Video de Fondo (Solo Home) -->
    <div id="home-video-bg">
        <div class="hero__overlay"></div>
        <video class="hero__video" src="assets/uploads/videos/0321.mp4" autoplay loop muted playsinline></video>
    </div>

    <!-- Contenido Principal Home (Sobre el video) -->
    <div class="home-content">
        
        <div class="hero__content">
            <h1 class="hero__title">ÚLTIMAS NOVEDADES</h1>
        </div>

        <section class="updates" id="updates">
        
        <div class="cards-grid">
            
            <article class="card card--video">
                <div class="card__header">
                    <span class="badge badge--youtube">NUEVO VIDEO</span>
                </div>
                <div class="card__media" id="youtube-container">
                    <div class="placeholder-video">Cargando último video...</div>
                </div>
                <div class="card__body">
                    <h3 class="card__title" id="youtube-title">Cargando video...</h3>
                    <div class="mt-auto">
                        <span id="youtube-date" class="post-meta-date">
                            <!-- Fecha cargada por JS -->
                        </span>
                        <a href="https://www.youtube.com/@CapibaraGamesDev" target="_blank" class="btn btn--primary w-100 text-center d-block">Ver Canal</a>
                    </div>
                </div>
            </article>

            <?php if ($latestPost): ?>
            <article class="card card--blog">
                <div class="card__header">
                    <span class="badge badge--blog">BLOG</span>
                </div>
                <div class="card__media">
                    <a href="post.php?slug=<?php echo htmlspecialchars($latestPost['slug']); ?>">
                        <img src="<?php echo htmlspecialchars($latestPost['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($latestPost['title']); ?>" 
                             class="card__img">
                    </a>
                </div>
                    <div class="card__body">
                        <h3 class="card__title">
                            <a href="post.php?slug=<?php echo htmlspecialchars($latestPost['slug']); ?>">
                                <?php echo htmlspecialchars($latestPost['title']); ?>
                            </a>
                        </h3>
                        
                        <p class="card__excerpt">
                            <?php echo htmlspecialchars(substr($latestPost['excerpt'], 0, 100)) . '...'; ?>
                        </p>
                        
                        <div class="mt-auto">
                            <span class="post-meta-date">
                                Publicado: <?php echo date("d/m/Y", strtotime($latestPost['created_at'])); ?>
                            </span>
                            
                            <a href="post.php?slug=<?php echo htmlspecialchars($latestPost['slug']); ?>" 
                               class="btn btn--secondary w-100 text-center d-block">
                                Leer Artículo
                            </a>
                        </div>
                    </div>
            </article>
            <?php else: ?>
                <article class="card card--blog">
                    <div class="card__body"><p>Próximamente nuevos artículos...</p></div>
                </article>
            <?php endif; ?>

            <?php if ($latestGame): ?>
            <article class="card card--game">
                <div class="card__header">
                    <span class="badge badge--game">JUEGO NUEVO</span>
                </div>
                <div class="card__media">
                    <img src="<?php echo htmlspecialchars($latestGame['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($latestGame['title']); ?>" 
                         class="card__img">
                </div>
                <div class="card__body">
                    <h3 class="card__title"><?php echo htmlspecialchars($latestGame['title']); ?></h3>
                    <p class="card__excerpt">
                        <?php echo htmlspecialchars(substr($latestGame['description'], 0, 90)) . '...'; ?>
                    </p>
                    
                    <div class="card-action-area">
                        <p class="post-meta-date">
                            Lanzamiento: <?php echo date("d/m/Y", strtotime($latestGame['release_date'])); ?>
                        </p>
                        
                        <a href="<?php echo htmlspecialchars($latestGame['itchio_url']); ?>" 
                           target="_blank" 
                           class="btn btn--accent w-100 text-center d-block">
                           Jugar Ahora
                        </a>
                    </div>
                </div>
            </article>
            <?php else: ?>
                <article class="card card--game">
                    <div class="card__body"><p>Próximamente nuevos juegos...</p></div>
                </article>
            <?php endif; ?>

        </div>
    </section>

    </div> <!-- Fin .home-content -->

<?php include 'includes/footer.php'; ?>