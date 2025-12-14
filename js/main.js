document.addEventListener('DOMContentLoaded', () => {
    fetchLatestVideo();
});

async function fetchLatestVideo() {
    const container = document.getElementById('youtube-container');

    // Apuntamos a NUESTRO servidor, no a Google directamente
    const apiUrl = 'api/youtube.php';

    try {
        const response = await fetch(apiUrl);

        if (!response.ok) throw new Error('Error en el servidor backend');

        const data = await response.json();

        if (data.items && data.items.length > 0) {
            const video = data.items[0];
            const videoId = video.id.videoId;
            const title = video.snippet.title;
            const dateStr = video.snippet.publishedAt; // "2025-02-15T..."

            // Actualizar Título
            const titleEl = document.getElementById('youtube-title');
            if (titleEl) titleEl.innerText = title;

            // Actualizar Fecha
            const dateEl = document.getElementById('youtube-date');
            if (dateEl) {
                const dateObj = new Date(dateStr);
                // Formato: DD/MM/YYYY
                const formattedDate = dateObj.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                dateEl.innerText = `Publicado: ${formattedDate}`;
            }

            // Inyectamos el video
            container.innerHTML = `
                <iframe 
                    width="100%" 
                    height="100%" 
                    src="https://www.youtube.com/embed/${videoId}?rel=0" 
                    title="${title}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            `;
        } else {
            container.innerHTML = '<div class="placeholder-video">No hay videos disponibles.</div>';
        }

    } catch (error) {
        console.error("Error:", error);
        container.innerHTML = '<div class="placeholder-video">No se pudo cargar el video.</div>';
    }
}