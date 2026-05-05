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

<!-- Estilos Markdown estilo GitHub / Obsidian -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown-dark.min.css">
<style>
    .markdown-body {
        box-sizing: border-box;
        margin: 0 auto;
        padding: 30px;
        background: rgba(20, 20, 30, 0.45); /* Glassmorphism background */
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        font-family: var(--f-body, 'Roboto', sans-serif);
    }
    .markdown-body img {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }
    @media (max-width: 767px) {
        .markdown-body {
            padding: 15px;
        }
    }
</style>

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

    <div class="post-content markdown-body mt-4">
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