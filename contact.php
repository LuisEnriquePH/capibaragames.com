<?php include 'includes/header.php'; ?>

<section class="page-header">
    <h1 class="page-header__title">CONTACTO</h1>
</section>

<main class="contact-container">
    
    <section class="contact-form-section">
        <article class="card card--text">
            <h2 class="card__title" style="color: var(--c-green-main);">ENVÍA UN MENSAJE</h2>
            <p style="margin-bottom: 20px;">¿Tienes una idea, un proyecto o simplemente quieres saludar? Escríbeme.</p>
            
            <form action="#" method="POST" class="form">
                <div class="form__group">
                    <label for="name" class="form__label">Nombre</label>
                    <input type="text" id="name" name="name" class="form__input" placeholder="Tu nombre" required>
                </div>

                <div class="form__group">
                    <label for="email" class="form__label">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form__input" placeholder="tucorreo@ejemplo.com" required>
                </div>

                <div class="form__group">
                    <label for="message" class="form__label">Mensaje</label>
                    <textarea id="message" name="message" class="form__textarea" placeholder="¿En qué puedo ayudarte?" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn--accent" style="width: 100%; border: none; cursor: pointer;">ENVIAR MENSAJE</button>
            </form>
        </article>
    </section>

    <aside class="contact-socials">
        
        <article class="card card--text">
            <h2 class="card__title" style="color: var(--c-highlight);">CONECTEMOS</h2>
            <p>También puedes encontrarme en estas plataformas:</p>
            
            <ul class="social-list">
                <li>
                    <a href="mailto:luisenriquepina.h@gmail.com" class="social-list__link">
                        <span class="icon-box">📧</span> luisenriquepina.h@gmail.com
                    </a>
                </li>
                <li>
                    <a href="https://discord.gg/QCk6A365s2" target="_blank" class="social-list__link">
                        <span class="icon-box">👾</span> Servidor de Discord
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/in/luis-enrique-pi%C3%B1a-hernandez-/" target="_blank" class="social-list__link">
                        <span class="icon-box">💼</span> LinkedIn
                    </a>
                </li>
                <li>
                    <a href="https://github.com/CAPIBARAGAMES" target="_blank" class="social-list__link">
                        <span class="icon-box">🐱</span> GitHub
                    </a>
                </li>
                <li>
                    <a href="https://x.com/LuisEnr38013315" target="_blank" class="social-list__link">
                        <span class="icon-box">✖️</span> Twitter / X
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/@CapibaraGamesDev" target="_blank" class="social-list__link">
                        <span class="icon-box">📺</span> YouTube
                    </a>
                </li>
            </ul>
        </article>

    </aside>

</main>

<?php include 'includes/footer.php'; ?>