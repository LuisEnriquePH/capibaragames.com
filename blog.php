<?php 
include 'includes/header.php'; 
include 'includes/db.php'; 

// 1. OBTENER POSTS
$posts = [];
try {
    if ($pdo) {
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    $error = "Error cargando artículos.";
}
?>

<section class="page-header">
    <h1 class="page-header__title">BLOG & DEVLOGS</h1>
</section>

<main class="updates mt-2">
    
    <?php if (isset($error)): ?>
        <p class="text-center text-highlight"><?php echo $error; ?></p>
    <?php elseif (empty($posts)): ?>
        <p class="text-center text-grey">Aún no hay artículos publicados.</p>
    <?php else: ?>
        
        <!-- Lista vertical de artículos -->
        <div class="blog-list">
            
            <?php foreach ($posts as $post): ?>
                <article class="card card--horizontal">
                    <div class="card__header">
                        <span class="badge badge--blog">ARTÍCULO</span>
                    </div>
                    
                    <div class="card__media">
                        <a href="post.php?slug=<?php echo htmlspecialchars($post['slug']); ?>">
                            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" loading="lazy" 
                                 alt="<?php echo htmlspecialchars($post['title']); ?>" 
                                 class="card__img">
                        </a>
                    </div>
                    
                    <div class="card__body">
                        <h3 class="card__title">
                            <a href="post.php?slug=<?php echo htmlspecialchars($post['slug']); ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h3>
                        
                        <p class="card__excerpt">
                            <?php echo htmlspecialchars(substr($post['excerpt'], 0, 100)) . '...'; ?>
                        </p>
                        
                        <div class="mt-auto">
                            <span class="post-meta-date">
                                Publicado: <?php echo date("d/m/Y", strtotime($post['created_at'])); ?>
                            </span>
                            
                            <a href="post.php?slug=<?php echo htmlspecialchars($post['slug']); ?>" 
                               class="btn btn--secondary w-100 text-center d-block">
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