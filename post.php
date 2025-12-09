<?php 
include 'includes/db.php';

// Validar si viene un slug en la URL
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    
    // Consulta segura (Prepared Statement) para evitar hackeos SQL
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE slug = :slug");
    $stmt->execute(['slug' => $slug]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Si no existe el post, redirigir al blog o mostrar error 404
if (!$post) {
    header("Location: blog.php");
    exit;
}

// Incluimos header DESPUÉS de la lógica para poder cambiar el título de la página (SEO)
$pageTitle = $post['title']; 
include 'includes/header.php'; 
?>

<main style="max-width: 800px; margin: 4rem auto; padding: 0 20px;">
    
    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" 
         alt="<?php echo htmlspecialchars($post['title']); ?>" 
         style="width: 100%; height: auto; border-radius: 8px; border: 2px solid var(--c-green-dark); margin-bottom: 2rem;">

    <h1 style="font-family: var(--f-title); font-size: 4rem; color: var(--c-white); line-height: 1; margin-bottom: 10px;">
        <?php echo htmlspecialchars($post['title']); ?>
    </h1>
    <p style="color: var(--c-green-main); margin-bottom: 2rem; font-family: var(--f-title); font-size: 1.2rem;">
        📅 <?php echo date("d F, Y", strtotime($post['created_at'])); ?>
    </p>

    <div class="post-content" style="font-size: 1.1rem; line-height: 1.8; color: #ddd;">
        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
    </div>

    <div style="margin-top: 4rem; border-top: 1px solid #444; padding-top: 2rem;">
        <a href="blog.php" class="btn btn--secondary">← Volver al Blog</a>
    </div>

</main>

<?php include 'includes/footer.php'; ?>