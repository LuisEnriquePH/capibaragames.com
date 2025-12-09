<?php 
include 'includes/header.php'; 
include 'includes/db.php'; 

try {
    // Pedimos los posts ordenados por fecha
    $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error cargando artículos.";
}
?>

<section class="page-header">
    <h1 class="page-header__title">BLOG & DEVLOGS</h1>
</section>

<main class="updates" style="margin-top: 2rem;">
    
    <?php if (isset($error)): ?>
        <p style="text-align: center; color: var(--c-highlight);"><?php echo $error; ?></p>
    <?php elseif (empty($posts)): ?>
        <p style="text-align: center; color: #888;">Aún no hay artículos publicados.</p>
    <?php else: ?>
        
        <div class="cards-grid">
            
            <?php foreach ($posts as $post): ?>
                <article class="card card--blog">
                    <div class="card__header">
                        <span class="badge badge--blog">ARTÍCULO</span>
                    </div>
                    
                    <div class="card__media">
                        <a href="post.php?slug=<?php echo htmlspecialchars($post['slug']); ?>">
                            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($post['title']); ?>" 
                                 class="card__img">
                        </a>
                    </div>
                    
                    <div class="card__body">
                        <h3 class="card__title">
                            <a href="post.php?slug=<?php echo htmlspecialchars($post['slug']); ?>" style="text-decoration:none; color:inherit;">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h3>
                        
                        <p class="card__excerpt">
                            <?php echo htmlspecialchars(substr($post['excerpt'], 0, 100)) . '...'; ?>
                        </p>
                        
                        <div style="margin-top: auto;">
                            <span style="display:block; font-size: 0.8rem; color: #666; margin-bottom: 10px;">
                                Publicado: <?php echo date("d/m/Y", strtotime($post['created_at'])); ?>
                            </span>
                            
                            <a href="post.php?slug=<?php echo htmlspecialchars($post['slug']); ?>" 
                               class="btn btn--secondary" 
                               style="width: 100%; text-align: center; display: block;">
                                Leer Artículo
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</main>

<?php include 'includes/footer.php'; ?>