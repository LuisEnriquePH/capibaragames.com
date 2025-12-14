<?php 
include 'includes/header.php'; 
include 'includes/db.php'; // Tu conexión a la BD

// Consulta segura a la base de datos
try {
    // Pedimos todos los juegos ordenados por fecha (del más nuevo al más viejo)
    $stmt = $pdo->query("SELECT * FROM games ORDER BY release_date DESC");
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Si falla, guardamos el error para mostrarlo (solo en desarrollo)
    $error = "Error cargando juegos."; 
}
?>

<section class="page-header">
    <h1 class="page-header__title">MIS JUEGOS</h1>
</section>

<main class="games-container">
    
    <?php if (isset($error)): ?>
        <div class="text-center text-highlight fs-15">
            ⚠️ <?php echo $error; ?>
        </div>
    <?php else: ?>
        
        <div class="games-grid">
            
            <?php foreach ($games as $game): ?>
                <article class="card card--game card--compact">
                    <div class="card__header">
                        <span class="badge badge--game">JUEGO</span>
                    </div>
                    
                    <div class="card__media">
                        <img src="<?php echo htmlspecialchars($game['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($game['title']); ?>" 
                             class="card__img">
                    </div>
                    
                    <div class="card__body">
                        <h3 class="card__title"><?php echo htmlspecialchars($game['title']); ?></h3>
                        <p class="card__excerpt"><?php echo htmlspecialchars($game['description']); ?></p>
                        
                        <div class="card-action-area">
                            <p class="post-meta-date">
                                Lanzamiento: <?php echo date("d/m/Y", strtotime($game['release_date'])); ?>
                            </p>
                            
                            <a href="<?php echo htmlspecialchars($game['itchio_url']); ?>" 
                               target="_blank" 
                               class="btn btn--accent w-100 text-center d-block">
                                Jugar Ahora
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
            </div>

    <?php endif; ?>

</main>

<?php include 'includes/footer.php'; ?>