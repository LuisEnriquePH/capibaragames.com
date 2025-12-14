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

<main class="post-container">
    
    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" 
         alt="<?php echo htmlspecialchars($post['title']); ?>" 
         class="post-banner-img">

    <h1 class="font-title fs-4 text-white lh-1 mb-1">
        <?php echo htmlspecialchars($post['title']); ?>
    </h1>
    <p class="text-green mb-2 font-title fs-12">
        📅 <?php echo date("d F, Y", strtotime($post['created_at'])); ?>
    </p>

    <div class="post-content fs-1 lh-18 text-light-grey">
        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
    </div>

    <div class="mt-4" style="border-top: 1px solid #444; padding-top: 2rem;">
        <a href="blog.php" class="btn btn--secondary">← Volver al Blog</a>
    </div>

</main>

<?php include 'includes/footer.php'; ?>