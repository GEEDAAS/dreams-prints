// Mostrar mensaje de bienvenida si el usuario ha iniciado sesión
document.addEventListener('DOMContentLoaded', function() {
    // Verifica si en localStorage hay una sesión activa
    const loggedIn = localStorage.getItem('loggedIn');
    const userName = localStorage.getItem('loggedInUser');

    // Si el usuario ha iniciado sesión y hay un nombre guardado
    if (loggedIn === 'true' && userName) {
        // Muestra el mensaje personalizado en el elemento con ID 'welcome-message'
        const welcomeMessage = document.getElementById('welcome-message');
        welcomeMessage.innerText = `¡Bienvenido, ${userName}!`;
    }
});

// Alterna la visibilidad del menú de navegación (usado en versión móvil)
function toggleMenu() {
    const nav = document.querySelector('.navigation');
    nav.classList.toggle('active'); // Agrega o remueve la clase 'active'
}
