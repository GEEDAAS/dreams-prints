// Lista de ideas disponible en memoria (se usaría si estuviera poblada desde el backend)
let ideas = [];

// Función para abrir un modal por ID y cerrar los demás si están abiertos
function abrirModal(id) {
  document.querySelectorAll('.modal').forEach(m => m.style.display = 'none'); // Oculta todos los modales
  document.getElementById(id).style.display = 'flex'; // Muestra el modal solicitado
}

// Cierra el modal si se hace clic fuera del contenido (en el fondo)
window.onclick = function (event) {
  if (event.target.classList.contains('modal')) {
    event.target.style.display = "none";
  }
}

// Cierra un modal específico por ID
function cerrarModal(id) {
  document.getElementById(id).style.display = 'none';
}

// Filtra las ideas por título y categoría y actualiza la vista
function buscarIdea() {
  const titulo = document.getElementById('buscarTitulo').value.trim().toLowerCase();
  const categoria = document.getElementById('buscarCategoria').value.trim().toLowerCase();

  const resultados = ideas.filter(idea =>
    (!titulo || idea.titulo.toLowerCase().includes(titulo)) &&
    (!categoria || idea.categoria.toLowerCase().includes(categoria))
  );

  mostrarIdeas(resultados);         // Muestra los resultados filtrados
  cerrarModal('modalBuscar');      // Cierra el modal de búsqueda
}

// Elimina una idea de la lista en base al título ingresado
function eliminarIdea() {
  const tituloEliminar = document.getElementById('tituloEliminar').value.trim().toLowerCase();
  ideas = ideas.filter(idea => idea.titulo.toLowerCase() !== tituloEliminar); // Filtra las ideas excluyendo la eliminada
  mostrarIdeas(ideas);            // Actualiza la vista
  cerrarModal('modalEliminar');   // Cierra el modal de eliminación
}

// Muestra un listado de ideas en tarjetas HTML
function mostrarIdeas(lista) {
  const contenedor = document.getElementById('ideas-contenedor');
  contenedor.innerHTML = ''; // Limpia el contenido actual

  // Si no hay resultados, muestra mensaje
  if (lista.length === 0) {
    contenedor.innerHTML = '<p>No hay ideas para mostrar.</p>';
    return;
  }

  // Recorre cada idea y la muestra en tarjeta
  lista.forEach(idea => {
    const card = document.createElement('div');
    card.className = 'idea-card';
    card.innerHTML = `
      ${idea.imagen ? `<img src="${idea.imagen}">` : ''}
      <h4>${idea.titulo}</h4>
      <p>${idea.descripcion}</p>
      <small><strong>Categoría:</strong> ${idea.categoria}</small>
    `;
    contenedor.appendChild(card);
  });
}
