<?php 
$pageTitle = "Test DaisyUI - Capibara Games";
$metaDescription = "Página de prueba para el nuevo diseño con DaisyUI";
include 'includes/header-daisyui.php'; 
?>

<main id="main-content" class="min-h-screen max-w-7xl mx-auto px-4 py-8">
    <div class="prose lg:prose-xl max-w-none">
        <h1 class="font-title text-5xl text-primary mb-8">
            DaisyUI Test Page
        </h1>
        
        <div class="alert alert-info mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>This is a test page to validate the DaisyUI implementation with Capibara theme.</span>
        </div>

        <h2 class="font-title text-3xl text-secondary mb-4">Color Palette Test</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-primary text-primary-content p-4 rounded-lg">
                <div class="font-bold">Primary</div>
                <div class="text-sm">#85D13E</div>
            </div>
            <div class="bg-secondary text-secondary-content p-4 rounded-lg">
                <div class="font-bold">Secondary</div>
                <div class="text-sm">#4B0082</div>
            </div>
            <div class="bg-accent text-accent-content p-4 rounded-lg">
                <div class="font-bold">Accent</div>
                <div class="text-sm">#FFD700</div>
            </div>
            <div class="bg-neutral text-neutral-content p-4 rounded-lg">
                <div class="font-bold">Neutral</div>
                <div class="text-sm">#333333</div>
            </div>
        </div>

        <h2 class="font-title text-3xl text-secondary mb-4">Button Examples</h2>
        
        <div class="flex flex-wrap gap-4 mb-8">
            <button class="btn btn-primary">Primary Button</button>
            <button class="btn btn-secondary">Secondary Button</button>
            <button class="btn btn-accent">Accent Button</button>
            <button class="btn btn-ghost">Ghost Button</button>
            <button class="btn btn-outline btn-primary">Outline Primary</button>
        </div>

        <h2 class="font-title text-3xl text-secondary mb-4">Card Example</h2>
        
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="card bg-base-100 shadow-xl">
                <figure><img src="https://picsum.photos/400/300?random=1" alt="Test" class="h-48 w-full object-cover"/></figure>
                <div class="card-body">
                    <h3 class="card-title text-primary">Test Game Card</h3>
                    <p>This is a sample game card using DaisyUI components.</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary btn-sm">Play Now</button>
                    </div>
                </div>
            </div>
            
            <div class="card bg-base-100 shadow-xl">
                <figure><img src="https://picsum.photos/400/300?random=2" alt="Test" class="h-48 w-full object-cover"/></figure>
                <div class="card-body">
                    <h3 class="card-title text-secondary">Blog Post Card</h3>
                    <p>This is a sample blog post card.</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-secondary btn-sm">Read More</button>
                    </div>
                </div>
            </div>
            
            <div class="card bg-base-100 shadow-xl">
                <figure><img src="https://picsum.photos/400/300?random=3" alt="Test" class="h-48 w-full object-cover"/></figure>
                <div class="card-body">
                    <h3 class="card-title text-accent">Video Card</h3>
                    <p>This is a sample video/YouTube card.</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-accent btn-sm">Watch</button>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="font-title text-3xl text-secondary mb-4">Badges</h2>
        
        <div class="flex flex-wrap gap-2 mb-8">
            <span class="badge badge-primary badge-lg">NEW VIDEO</span>
            <span class="badge badge-secondary badge-lg">BLOG</span>
            <span class="badge badge-accent badge-lg">FEATURED</span>
            <span class="badge badge-ghost badge-lg">Draft</span>
        </div>

        <h2 class="font-title text-3xl text-secondary mb-4">Typography Test</h2>
        
        <div class="space-y-4 mb-8">
            <p class="font-title text-4xl text-primary">CAPIBARA GAMES</p>
            <p class="font-body text-xl">This is Roboto body text at XL size.</p>
            <p class="font-body">This is regular Roboto body text for paragraphs and content.</p>
            <p class="font-body text-sm text-base-content/70">This is small text for metadata and captions.</p>
        </div>

        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>DaisyUI is working correctly with the custom Capibara theme!</span>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
