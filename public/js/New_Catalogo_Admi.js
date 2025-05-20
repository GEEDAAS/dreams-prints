// Función para abrir un modal específico por su ID
function abrirModal(id) {
  // Cierra cualquier otro modal abierto
  document.querySelectorAll('.modal').forEach(m => m.style.display = 'none');
  // Muestra el modal solicitado
  document.getElementById(id).style.display = 'flex';
}

// Evento global para cerrar modales si se hace clic fuera del contenido
window.onclick = function (event) {
  // Si el clic ocurrió en un área con clase 'modal' (fondo), se cierra
  if (event.target.classList.contains('modal')) {
    event.target.style.display = "none";
  }
}

// Función para cerrar un modal dado su ID
function cerrarModal(id) {
  document.getElementById(id).style.display = 'none';
}

// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formAgregarProducto');
  
  // Verifica si el formulario existe en la vista actual
  if (form) {
    // Evento de envío del formulario para agregar producto
    form.addEventListener('submit', function (e) {
      e.preventDefault(); // Previene el envío tradicional del formulario

      const formData = new FormData(this); // Captura los datos del formulario

      // Envía la solicitud al backend para agregar el producto
      fetch('index.php?page=agregar_producto', {
        method: 'POST',
        body: formData
      })
      .then(res => res.text()) // Procesa la respuesta como texto
      .then(() => {
        alert('Producto agregado exitosamente'); // Muestra alerta de éxito
        location.reload(); // Recarga la página para ver el nuevo producto
      })
      .catch(err => {
        alert('Error al agregar producto'); // Muestra error si falla
        console.error(err);
      });
    });
  }
});

// Asocia el evento de clic a cada botón de edición de producto
document.querySelectorAll('.btn-editar').forEach(btn => {
  btn.addEventListener('click', () => {
    // Carga los datos del producto desde los atributos data-* del botón
    document.getElementById('edit-idProducto').value = btn.dataset.id;
    document.getElementById('edit-nombre').value = btn.dataset.nombre;
    document.getElementById('edit-descripcion').value = btn.dataset.descripcion;
    document.getElementById('edit-precio').value = btn.dataset.precio;
    document.getElementById('edit-categoria').value = btn.dataset.categoria;
    document.getElementById('edit-stock').value = btn.dataset.stock;

    // Muestra el modal de edición
    document.getElementById('modalEditarProducto').style.display = 'block';
  });
});

// Función para cerrar el modal de edición
function cerrarModalEditar() {
  document.getElementById('modalEditarProducto').style.display = 'none';
}

// Evento de envío del formulario de edición de producto
document.getElementById('formEditarProducto').addEventListener('submit', async function (e) {
  e.preventDefault(); // Previene el envío tradicional

  const formData = new FormData(this); // Captura los datos del formulario

  // Envía la solicitud al backend para actualizar el producto
  const response = await fetch('index.php?page=actualizar_producto', {
    method: 'POST',
    body: formData
  });

  const resultado = await response.text(); // Lee la respuesta del servidor
  alert(resultado); // Muestra mensaje al usuario
  location.reload(); // Recarga para ver los cambios aplicados
});
