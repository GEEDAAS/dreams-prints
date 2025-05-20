// Función para activar el modo de edición del contenido "Acerca de"
function enableEditMode() {
    const content = document.querySelector('.about-content'); // Selecciona el contenedor editable
    content.contentEditable = true;  // Habilita la edición del contenido
    content.focus();                 // Coloca el cursor en el contenido editable
    document.querySelector('.save-button').style.display = 'block';  // Muestra el botón de guardar
    document.querySelector('.edit-button').style.display = 'none';   // Oculta el botón de editar
}

// Función para guardar los cambios realizados en el contenido
function saveChanges() {
    const content = document.querySelector('.about-content'); // Selecciona el contenido
    localStorage.setItem('aboutContent', content.innerHTML); // Guarda el contenido en localStorage
    content.contentEditable = false; // Desactiva la edición
    document.querySelector('.save-button').style.display = 'none';  // Oculta el botón de guardar
    document.querySelector('.edit-button').style.display = 'block'; // Muestra nuevamente el botón de editar
}

// Evento que se ejecuta cuando el documento está completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    const savedContent = localStorage.getItem('aboutContent'); // Intenta obtener contenido guardado
    if (savedContent) {
        document.querySelector('.about-content').innerHTML = savedContent; // Si existe, lo carga en pantalla
    }
});
