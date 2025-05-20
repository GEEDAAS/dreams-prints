// Cierra el modal de configuración de producto
function cerrarConfiguracion() {
  document.getElementById('configModal').style.display = 'none';
}

// Alterna la visibilidad del carrito de compras
function toggleCarrito() {
  const carritoDiv = document.getElementById('carrito');
  carritoDiv.classList.toggle('oculto');
  cargarCarrito(); // Carga el contenido del carrito
}

// Calcula el precio total basado en las selecciones del usuario
function actualizarPrecio() {
  let total = 0;
  const producto = document.getElementById('producto');
  const dimension = document.getElementById('dimension');
  const material = document.getElementById('material');

  // Suma los precios asignados a las opciones seleccionadas
  if (producto && producto.selectedOptions[0].dataset.precio) {
    total += parseFloat(producto.selectedOptions[0].dataset.precio);
  }
  if (dimension && dimension.selectedOptions[0].dataset.precio) {
    total += parseFloat(dimension.selectedOptions[0].dataset.precio);
  }
  if (material && material.selectedOptions[0].dataset.precio) {
    total += parseFloat(material.selectedOptions[0].dataset.precio);
  }

  // Muestra el precio final en el modal
  document.getElementById('precio').textContent = "Precio: $" + total.toFixed(2);
}

// Envía la configuración seleccionada al backend para agregarla al carrito
function guardarConfiguracion() {
  const producto = document.getElementById('producto').value;
  const dimension = document.getElementById('dimension').value;
  const material = document.getElementById('material').value;
  const color = document.getElementById('color').value;
  const precioTexto = document.getElementById('precio').textContent;
  const precio = parseFloat(precioTexto.replace("Precio: $", ""));

  // Validación de campos vacíos
  if (!producto || !dimension || !material || !color) {
    alert("Por favor completa todos los campos.");
    return;
  }

  // Crea un formulario para enviar al servidor
  const formData = new FormData();
  formData.append('producto', producto);
  formData.append('dimension', dimension);
  formData.append('material', material);
  formData.append('color', color);
  formData.append('precio', precio);

  // Realiza la petición al servidor para agregar al carrito
  fetch('index.php?page=agregar_carrito', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    // Actualiza la vista del carrito con los nuevos datos
    document.getElementById('listaCarrito').innerHTML = data.html;
    document.getElementById('totalCarrito').textContent = data.total;
    document.getElementById('carrito-count').textContent = data.count;
    cerrarConfiguracion();
    document.getElementById('carrito').classList.remove('oculto');
  });
}

// Elimina un producto del carrito
function eliminarItem(index) {
  const formData = new FormData();
  formData.append('index', index);

  fetch('index.php?page=eliminar_carrito', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    document.getElementById('listaCarrito').innerHTML = data.html;
    document.getElementById('totalCarrito').textContent = data.total;
    document.getElementById('carrito-count').textContent = data.count;
    cerrarConfiguracion();
    document.getElementById('carrito').classList.remove('oculto');
  });
}

// Vacía todo el carrito
function vaciarCarrito() {
  fetch('index.php?page=vaciar_carrito', {
    method: 'POST'
  })
  .then(response => response.json())
  .then(data => {
    document.getElementById('listaCarrito').innerHTML = data.html;
    document.getElementById('totalCarrito').textContent = data.total;
    document.getElementById('carrito-count').textContent = data.count;
    cerrarConfiguracion();
    document.getElementById('carrito').classList.remove('oculto');
  });
}

// Carga el contenido actual del carrito desde el backend
function cargarCarrito() {
  fetch('index.php?page=mostrar_carrito')
    .then(response => response.json())
    .then(data => {
      document.getElementById('listaCarrito').innerHTML = data.html;
      document.getElementById('totalCarrito').textContent = data.total;
      document.getElementById('carrito-count').textContent = data.count;
    });
}

// Ejecuta la carga del carrito automáticamente al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  cargarCarrito();
});

// Abre el modal para configurar un producto específico
function abrirConfiguracion(nombreProducto) {
  const modal = document.getElementById('configModal');
  modal.style.display = 'block';

  const selectProducto = document.getElementById('producto');
  selectProducto.value = nombreProducto;
  selectProducto.disabled = true; // No permite cambiar el producto

  // Reinicia todos los campos
  document.getElementById('dimension').selectedIndex = 0;
  document.getElementById('material').selectedIndex = 0;
  document.getElementById('color').value = '';
  document.getElementById('precio').textContent = 'Precio: $0.00';
}
