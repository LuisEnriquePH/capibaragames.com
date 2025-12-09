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

<main class="updates" style="margin-top: 2rem;">
    
    <?php if (isset($error)): ?>
        <div style="text-align: center; color: var(--c-highlight); font-size: 1.5rem;">
            ⚠️ <?php echo $error; ?>
        </div>
    <?php else: ?>
        
        <div class="cards-grid">
            
            <?php foreach ($games as $game): ?>
                <article class="card card--game">
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
                        
                        <div style="margin-top: auto; width: 100%;">
                            <p style="font-size: 0.9rem; color: #888; margin-bottom: 10px;">
                                Lanzamiento: <?php echo date("d/m/Y", strtotime($game['release_date'])); ?>
                            </p>
                            
                            <a href="<?php echo htmlspecialchars($game['itchio_url']); ?>" 
                               target="_blank" 
                               class="btn btn--accent" 
                               style="width: 100%; text-align: center; display: block;">
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