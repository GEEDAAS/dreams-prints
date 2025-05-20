// Espera a que el DOM esté completamente cargado antes de ejecutar
document.addEventListener('DOMContentLoaded', function() {
  // Intenta recuperar contenido previamente guardado en localStorage
  const savedContent = localStorage.getItem('aboutContent');

  // Si existe contenido guardado, lo muestra en la sección editable
  if (savedContent) {
    document.querySelector('.about-content').innerHTML = savedContent; // Cargar contenido guardado
  }
});

// Función para mostrar el modal de consulta
function abrirConsultaModal() {
  document.getElementById("modalConsulta").style.display = "block";
}

// Función para cerrar el modal de consulta
function cerrarConsultaModal() {
  document.getElementById("modalConsulta").style.display = "none";
}

// Función que se ejecuta al enviar el formulario de consulta
function enviarConsultaPorCorreo(event) {
  event.preventDefault(); // Previene el envío del formulario por defecto

  // Obtiene los datos del formulario
  const usuario = document.getElementById("usuario").value;
  const descripcion = document.getElementById("descripcion").value;

  // Datos del correo
  const correoDestino = "soporte@dreamsandprints.com";
  const asunto = encodeURIComponent("Consulta de usuario: " + usuario);
  const cuerpo = encodeURIComponent("Usuario: " + usuario + "\n\nDescripción:\n" + descripcion);

  // Abre cliente de correo predeterminado con los datos prellenados
  window.location.href = `mailto:${correoDestino}?subject=${asunto}&body=${cuerpo}`;

  // Cierra el modal una vez enviado
  cerrarConsultaModal();
}
