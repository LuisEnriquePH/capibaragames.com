    </div><!-- #main-content -->

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="Volver arriba" title="Volver arriba">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>
        </svg>
    </button>

    <footer class="footer">
        <p>© <?php echo date("Y"); ?> Capibara Games - Diseñado por Luis Enrique Piña Hernandez</p>
    </footer>

    <script src="js/main.js?v=<?php echo filemtime('js/main.js'); ?>"></script>
    
    <!-- Back to Top Script -->
    <script>
        // Back to top button
        const backToTopBtn = document.getElementById('back-to-top');
        if (backToTopBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            });
            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
        
        // Toggle aria-expanded on menu
        const menuToggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.header__nav');
        if (menuToggle && nav) {
            menuToggle.addEventListener('click', () => {
                const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
                menuToggle.setAttribute('aria-expanded', !isExpanded);
            });
        }
    </script>
</body>
</html>