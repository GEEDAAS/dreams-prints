// Variable que guarda el método actual seleccionado
let metodoActual = 'tarjeta';

// Función para alternar entre los métodos de pago visuales (tarjeta <-> efectivo)
function cambiarMetodo() {
    const tarjeta = document.getElementById('metodo-tarjeta');
    const efectivo = document.getElementById('metodo-efectivo');

    // Si actualmente es tarjeta, se cambia a efectivo
    if (metodoActual === 'tarjeta') {
        tarjeta.classList.add('hidden');
        efectivo.classList.remove('hidden');
        metodoActual = 'efectivo';
    } else {
        // Si actualmente es efectivo, se regresa a tarjeta
        tarjeta.classList.remove('hidden');
        efectivo.classList.add('hidden');
        metodoActual = 'tarjeta';
    }
}

// Evento que se ejecuta al cargar completamente el DOM
document.addEventListener("DOMContentLoaded", function () {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    // Calcula el total sumando precios de cada ítem
    const total = carrito.reduce((sum, item) => sum + item.precio, 0);

    // Renderiza la lista de productos seleccionados
    const detalles = document.getElementById("detalles-compra");
    detalles.innerHTML = "<h3>Detalles de la compra:</h3><ul>" +
        carrito.map(item =>
            `<li><strong>${item.nombre}</strong> - ${item.dimension}, ${item.material}, ${item.color} - $${item.precio.toFixed(2)}</li>`
        ).join("") + "</ul>";

    // Muestra el total a pagar
    document.getElementById("monto-a-pagar").innerHTML = "<h3>Total a pagar: $" + total.toFixed(2) + "</h3>";

    // Si el método efectivo está visible, muestra el código de barras
    const efectivoDiv = document.getElementById("metodo-efectivo");
    const barra = document.getElementById("codigo-barras");
    if (!efectivoDiv.classList.contains("hidden")) {
        barra.classList.remove("hidden");
    }

    // Carga las tarjetas guardadas desde localStorage (si existen)
    const tarjetas = JSON.parse(localStorage.getItem("tarjetasGuardadas")) || [];
    if (tarjetas.length > 0) {
        const tarjetaForm = document.querySelector("#metodo-tarjeta .form");
        const selector = document.createElement("select");

        selector.innerHTML = '<option disabled selected>Selecciona una tarjeta guardada</option>' +
            tarjetas.map(t => `<option>${t.nombre} - ****${t.numeroTarjeta.slice(-4)}</option>`).join("");

        tarjetaForm.insertBefore(selector, tarjetaForm.firstChild);
    }
});

// Versión más completa de la función cambiarMetodo con código de barras incluido
function cambiarMetodo() {
    const tarjeta = document.getElementById('metodo-tarjeta');
    const efectivo = document.getElementById('metodo-efectivo');
    const barra = document.getElementById("codigo-barras");

    if (tarjeta.classList.contains('hidden')) {
        tarjeta.classList.remove('hidden');
        efectivo.classList.add('hidden');
        barra.classList.add('hidden');
    } else {
        tarjeta.classList.add('hidden');
        efectivo.classList.remove('hidden');
        barra.classList.remove('hidden');
    }
}

// Muestra el método de pago seleccionado (tarjeta, efectivo o transferencia)
function mostrarMetodoPago() {
  const tipo = document.getElementById('tipoPago').value;
  const metodos = document.querySelectorAll('.pago-metodo');

  // Oculta todos los métodos primero
  metodos.forEach(m => m.style.display = 'none');

  // Muestra solo el método correspondiente
  if (tipo === 'Tarjeta') {
    document.getElementById('pago-tarjeta').style.display = 'block';
  } else if (tipo === 'Efectivo') {
    document.getElementById('pago-efectivo').style.display = 'block';
  } else if (tipo === 'Transferencia') {
    document.getElementById('pago-transferencia').style.display = 'block';
  }
}

// Ejecuta la función de visualización de método al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  mostrarMetodoPago(); // Para que el método correcto se muestre desde el inicio
});
