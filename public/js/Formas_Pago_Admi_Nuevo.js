// Contador para asignar IDs únicos a nuevos métodos de pago agregados
let contadorMetodo = 4;

// Función para editar el texto de un método de pago existente
function editPaymentMethod(id) {
  const li = document.getElementById(id);             // Obtiene el <li> por ID

  const icono = li.querySelector("i");                // Captura el ícono existente
  const botones = li.querySelectorAll("button");      // Captura los botones "Editar" y "Eliminar"

  // Extrae el texto actual sin incluir los botones ni íconos
  let textoActual = li.innerText;
  textoActual = textoActual.replace(/Editar|Eliminar/g, "").trim();

  // Solicita nuevo texto al usuario
  const nuevoTexto = prompt("Editar método de pago:", textoActual);
  if (nuevoTexto !== null && nuevoTexto.trim() !== "") {
    li.innerHTML = '';                      // Limpia el contenido del <li>
    li.appendChild(icono);                  // Vuelve a agregar el ícono
    li.append(" " + nuevoTexto);            // Inserta el nuevo texto

    // Vuelve a agregar los botones de acción
    botones.forEach(btn => li.appendChild(btn));
  }
}

// Función para eliminar un método de pago visualmente
function deletePaymentMethod(id) {
  const li = document.getElementById(id);
  if (confirm("¿Estás seguro de eliminar este método de pago?")) {
    li.remove();  // Elimina el elemento del DOM
  }
}

// Función para agregar un nuevo método de pago manualmente
function addPaymentMethod() {
  const lista = document.getElementById("paymentMethodsList"); // UL que contiene los métodos
  const nuevoTexto = prompt("Ingresa el nuevo método de pago:");

  if (nuevoTexto !== null && nuevoTexto.trim() !== "") {
    const id = "payment-method-" + contadorMetodo++;  // Crea un ID único para el nuevo elemento

    // Crea un nuevo <li> con ícono y botones
    const li = document.createElement("li");
    li.id = id;
    li.innerHTML = `
      <i class="fas fa-plus-circle"></i> ${nuevoTexto}
      <button onclick="editPaymentMethod('${id}')">Editar</button>
      <button onclick="deletePaymentMethod('${id}')">Eliminar</button>
    `;

    lista.appendChild(li);  // Agrega el nuevo método a la lista
  }
}
