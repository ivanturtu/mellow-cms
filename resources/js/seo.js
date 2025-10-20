// SEO Optimizations JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Lazy loading implementation
    if ('IntersectionObserver' in window) {
        const lazyImages = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for browsers without IntersectionObserver
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            img.classList.add('loaded');
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Invio in corso...';
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }, 5000);
            }
        });
    });

    // Performance monitoring
    if ('performance' in window) {
        window.addEventListener('load', function() {
            setTimeout(() => {
                const perfData = performance.getEntriesByType('navigation')[0];
                if (perfData) {
                    console.log('Page Load Time:', perfData.loadEventEnd - perfData.loadEventStart, 'ms');
                }
            }, 0);
        });
    }

    // Add structured data for breadcrumbs
    const breadcrumbs = document.querySelectorAll('.breadcrumb-item');
    if (breadcrumbs.length > 0) {
        const breadcrumbData = {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": []
        };

        breadcrumbs.forEach((item, index) => {
            const link = item.querySelector('a');
            breadcrumbData.itemListElement.push({
                "@type": "ListItem",
                "position": index + 1,
                "name": item.textContent.trim(),
                "item": link ? link.href : null
            });
        });

        const script = document.createElement('script');
        script.type = 'application/ld+json';
        script.textContent = JSON.stringify(breadcrumbData);
        document.head.appendChild(script);
    }

    // Add skip to content link for accessibility
    const skipLink = document.createElement('a');
    skipLink.href = '#main-content';
    skipLink.textContent = 'Salta al contenuto principale';
    skipLink.className = 'skip-link';
    skipLink.style.cssText = 'position: absolute; top: -40px; left: 6px; background: #000; color: #fff; padding: 8px; text-decoration: none; z-index: 1000;';
    document.body.insertBefore(skipLink, document.body.firstChild);

    // Add main content ID if not present
    const mainContent = document.querySelector('main, #main, .main-content');
    if (mainContent && !mainContent.id) {
        mainContent.id = 'main-content';
    }

    // Optimize images on load
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        if (!img.loading) {
            img.loading = 'lazy';
        }
    });

    // Add alt text to images without it
    images.forEach(img => {
        if (!img.alt) {
            img.alt = 'Immagine';
        }
    });

    // Preload critical resources
    const criticalResources = [
        'https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&family=Sora:wght@100..800&display=swap',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'
    ];

    criticalResources.forEach(resource => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'style';
        link.href = resource;
        document.head.appendChild(link);
    });
});

// Service Worker registration for caching
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful');
            })
            .catch(function(err) {
                console.log('ServiceWorker registration failed');
            });
    });
}
