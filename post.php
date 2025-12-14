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
// Si no existe el post, mostrar 404
if (!$post) {
    http_response_code(404);
    include 'includes/header.php';
    echo '<main class="post-container text-center py-4">
            <h1 class="text-green fs-4">404</h1>
            <p class="text-white fs-2 mb-2">Vaya, este artículo no existe o se ha perdido en el ciberespacio.</p>
            <a href="blog.php" class="btn btn--secondary">Volver al Blog</a>
          </main>';
    include 'includes/footer.php';
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
        <?php 
            require 'includes/Parsedown.php';
            $Parsedown = new Parsedown();
            echo $Parsedown->text($post['content']); 
        ?>
    </div>

    <div class="mt-4 pt-2 border-top-dark">
        <a href="blog.php" class="btn btn--secondary">← Volver al Blog</a>
    </div>

</main>

<?php include 'includes/footer.php'; ?>