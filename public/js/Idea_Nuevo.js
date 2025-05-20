// Arreglo que almacenará las ideas en el cliente (no persistente)
let ideas = [];

// Función para abrir un modal específico y cerrar los demás
function abrirModal(id) {
  document.querySelectorAll('.modal').forEach(m => m.style.display = 'none');
  document.getElementById(id).style.display = 'flex';
}

// Carga dinámicamente el ID y el título de la idea a eliminar dentro del modal
function cargarIdEliminar(id, titulo) {
  document.getElementById('input-id-idea').value = id;
  document.getElementById('titulo-idea-a-eliminar').innerText = "Título: " + titulo;
  document.getElementById('modal-eliminar').style.display = 'block';
}

// Cierra cualquier modal si se hace clic fuera del contenido
window.onclick = function (event) {
  if (event.target.classList.contains('modal')) {
    event.target.style.display = "none";
  }
}

// Agrega una nueva idea al arreglo y la muestra
function agregarIdea() {
  const titulo = document.getElementById('tituloAgregar').value.trim();
  const descripcion = document.getElementById('descripcionAgregar').value.trim();
  const categoria = document.getElementById('categoriaAgregar').value.trim();
  const imagenInput = document.getElementById('imagenAgregar');

  if (!titulo || !descripcion) return alert('Todos los campos son obligatorios.');

  const idea = { titulo, descripcion, categoria };

  // Si se selecciona una imagen, la convierte a base64
  if (imagenInput.files && imagenInput.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      idea.imagen = e.target.result;
      ideas.push(idea);
      mostrarIdeas(ideas);
    };
    reader.readAsDataURL(imagenInput.files[0]);
  } else {
    idea.imagen = null;
    ideas.push(idea);
    mostrarIdeas(ideas);
  }

  // Cierra el modal tras agregar
  document.getElementById('modalAgregar').style.display = 'none';
}

// Filtra ideas por título y categoría y actualiza el listado
function buscarIdea() {
  const titulo = document.getElementById('buscarTitulo').value.trim().toLowerCase();
  const categoria = document.getElementById('buscarCategoria').value.trim().toLowerCase();

  const resultados = ideas.filter(idea =>
    (!titulo || idea.titulo.toLowerCase().includes(titulo)) &&
    (!categoria || idea.categoria.toLowerCase().includes(categoria))
  );

  mostrarIdeas(resultados);
  document.getElementById('modalBuscar').style.display = 'none';
}

// Elimina una idea por título y actualiza el listado
function eliminarIdea() {
  const tituloEliminar = document.getElementById('tituloEliminar').value.trim().toLowerCase();
  ideas = ideas.filter(idea => idea.titulo.toLowerCase() !== tituloEliminar);
  mostrarIdeas(ideas);
  document.getElementById('modalEliminar').style.display = 'none';
}

// Muestra una lista de ideas en tarjetas
function mostrarIdeas(lista) {
  const contenedor = document.getElementById('ideas-contenedor');
  contenedor.innerHTML = '';
  if (lista.length === 0) {
    contenedor.innerHTML = '<p>No hay ideas para mostrar.</p>';
    return;
  }

  lista.forEach(idea => {
    const card = document.createElement('div');
    card.className = 'idea-card';
    card.innerHTML = `
      ${idea.imagen ? `<img src="${idea.imagen}" style="width:100%; height:auto; border-radius:8px;">` : ''}
      <h4>${idea.titulo}</h4>
      <p>${idea.descripcion}</p>
      <small><strong>Categoría:</strong> ${idea.categoria}</small>
    `;
    contenedor.appendChild(card);
  });
}

// Cierra un modal por ID
function cerrarModal(id) {
  document.getElementById(id).style.display = 'none';
}
