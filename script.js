// Déplacement du curseur personnalisé
const cursor = document.querySelector('.cursor');

document.addEventListener('mousemove', (e) => {
    cursor.style.left = e.clientX + 'px';
    cursor.style.top = e.clientY + 'px';
});

// Effet d'agrandissement sur les liens
document.querySelectorAll('a, .project-card').forEach(link => {
    link.addEventListener('mouseenter', () => {
        cursor.style.transform = 'scale(4)';
        cursor.style.background = 'rgba(255, 62, 0, 0.1)';
    });
    link.addEventListener('mouseleave', () => {
        cursor.style.transform = 'scale(1)';
        cursor.style.background = 'transparent';
    });
});

// Effet de Parallaxe sur le titre
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const heroContent = document.querySelector('.hero-content');
    
    if (heroContent) {
        // Le titre descend presque à la même vitesse que le scroll
        const val = scrolled * 0.9;
        heroContent.style.transform = `translateY(${val}px)`;
        
        // On réduit très légèrement l'opacité sans le faire disparaître
        heroContent.style.opacity = `${1 - (scrolled / 5000)}`;
    }
});
// ... (Garder le code du curseur précédent) ...

// Mise à jour de l'heure locale dans le footer
function updateTime() {
    const timeElement = document.getElementById('local-time');
    const now = new Date();
    const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
    timeElement.textContent = `VOTRE ZONE : ${now.toLocaleTimeString('fr-FR', options)}`;
}
setInterval(updateTime, 1000);

// Animation au scroll (Simple Intersection Observer)
const observerOptions = { threshold: 0.2 };
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = "1";
            entry.target.style.transform = "translateY(0)";
        }
    });
}, observerOptions);

document.querySelectorAll('.project-item').forEach(item => {
    item.style.opacity = "0";
    item.style.transform = "translateY(50px)";
    item.style.transition = "all 0.8s ease-out";
    observer.observe(item);
});