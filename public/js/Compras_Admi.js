// Agrega evento a todos los selectores de estado de pago
document.querySelectorAll('.dropdown-estado-pago').forEach(select => {
  select.addEventListener('change', async function () {
    const form = this.closest('.form-estado-pago');        // Obtiene el formulario padre
    const idCompra = form.dataset.id;                      // Extrae el ID de la compra
    const nuevoEstado = this.value;                        // Obtiene el nuevo estado seleccionado

    // Envía la solicitud para actualizar el estado de pago
    const response = await fetch('index.php?page=actualizar_estado_pago', {
      method: 'POST',
      body: new URLSearchParams({
        idCompra,
        estadoPago: nuevoEstado
      })
    });

    const result = await response.text(); // Lee la respuesta del servidor
    alert(result);                        // Muestra mensaje con el resultado
    location.reload();                    // Recarga la página para reflejar cambios
  });
});

// Agrega evento a todos los selectores de estado de impresión
document.querySelectorAll('.dropdown-estado-impresion').forEach(select => {
  select.addEventListener('change', async function () {
    const form = this.closest('.form-estado-impresion');   // Obtiene el formulario padre
    const idImpresion = form.dataset.id;                   // ID de la impresión específica
    const idCompra = form.dataset.idcompra;                // ID de la compra asociada
    const estadoImpresion = this.value;                    // Nuevo estado de impresión

    // Envía la solicitud para actualizar el estado de impresión
    const response = await fetch('index.php?page=actualizar_estado_impresion', {
      method: 'POST',
      body: new URLSearchParams({
        idImpresion,
        estadoImpresion,
        idCompra
      })
    });

    const result = await response.text(); // Lee la respuesta
    alert(result);                        // Muestra mensaje con resultado
    location.reload();                    // Recarga para ver los cambios reflejados
  });
});
