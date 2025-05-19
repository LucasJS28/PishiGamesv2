//Rellena el Formuilario del PanelJefe
function fillForms() {
  var select = document.getElementById("juego");
  var selectedOption = select.options[select.selectedIndex];
  var stockAnteriorInput = document.getElementById("stock_anterior");
  var precioAnteriorInput = document.getElementById("precio_anterior");
  var imagenJuego = document.getElementById("imagen_juego");

  stockAnteriorInput.value = selectedOption.dataset.stock;
  precioAnteriorInput.value = selectedOption.dataset.precio;
  imagenJuego.src = selectedOption.dataset.imagen;
  imagenJuego.removeAttribute("hidden");
}

// Llenar los formularios al cargar la página con el primer juego
window.addEventListener("load", function () {
  fillForms();
});

//Validacion para el Registro

function validarFormularioRegistro() {
  var correo = document.getElementById("correo").value;
  var contrasena = document.getElementById("contrasena").value;
  var repecontra = document.getElementById("repecontra").value;
  var terminos = document.getElementById("terminos").checked;

  // Validar la dirección de correo electrónico
  var correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!correoRegex.test(correo)) {
    alert("Ingrese un correo electrónico válido");
    return false; // Evita que se envíe el formulario
  }
  // Validar contraseñas
  if (contrasena.length < 8) {
    alert("La contraseña debe tener al menos 8 caracteres");
    return false;
  }

  if (contrasena !== repecontra) {
    alert("Las contraseñas no coinciden");
    return false;
  }

  // Validar aceptación de términos y condiciones
  if (!terminos) {
    alert("Debe aceptar los Términos y Condiciones");
    return false;
  }

  return true;
}

//Validacion para el Login
function validarFormularioLogin() {
  var correoUsuario = document.getElementById("correoUsuario").value;
  var passUsuario = document.getElementById("passUsuario").value;

  // Verificar si los campos están vacíos
  if (correoUsuario === "" || passUsuario === "") {
    alert("Por favor, complete todos los campos.");
    return false; // Evita que se envíe el formulario
  }
  // Validar la dirección de correo electrónico
  var correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!correoRegex.test(correoUsuario)) {
    alert("Ingrese un correo electrónico válido");
    return false; // Evita que se envíe el formulario
  }
  // Si todo es válido, se enviará el formulario
  return true;
}

//Validacion FormularioAdmin

function validarFormularioRegistroAdmin() {
  var correo = document.getElementById("correo").value;
  var contrasena = document.getElementById("contrasena").value;
  var rol = document.getElementById("rol").value;

  // Validar campos vacíos
  if (correo === "" || contrasena === "" || rol === "") {
    alert("Por favor, complete todos los campos.");
    return false; // Evita que se envíe el formulario
  }

  // Validar dirección de correo electrónico
  var correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!correoRegex.test(correo)) {
    alert("Por favor, ingrese un correo electrónico válido.");
    return false; // Evita que se envíe el formulario
  }

  // Si todo es válido, se enviará el formulario
  return true;
}

//Valida Formulario Stock en PanelJefe

function validarFormularioJefe() {
  var stockAnterior = document.getElementById("stock_anterior").value;
  var stockNuevo = document.getElementById("stock_nuevo").value;
  var precioAnterior = document.getElementById("precio_anterior").value;
  var precioNuevo = document.getElementById("precio_nuevo").value;

  if (isNaN(stockNuevo)) {
    alert("Ingrese un valor numérico válido para el nuevo stock.");
    return false;
  }
  if (parseFloat(stockNuevo) < 0) {
    alert("El nuevo stock debe ser mayor o igual a cero.");
    return false;
  }

  if (isNaN(precioNuevo)) {
    alert("Ingrese un valor numérico válido para el nuevo precio.");
    return false;
  }

  if (stockAnterior === stockNuevo) {
    alert("El nuevo precio debe ser diferente al precio anterior.");
    return false;
  }
  if (precioAnterior === precioNuevo) {
    alert("El nuevo precio debe ser diferente al precio anterior.");
    return false;
  }

  if (parseFloat(precioNuevo) <= 0) {
    alert("El nuevo precio debe ser mayor a cero.");
    return false;
  }

  return true;
}

function validarFormularioJuegos() {
  var titulo = document.getElementById("titulo").value;
  var descripcion = document.getElementById("descripcion").value;
  var precio = document.getElementById("precio").value;
  var stock = document.getElementById("stock").value;
  var imagen = document.getElementById("imagen").value;

  if (titulo.trim() === "") {
    alert("Ingrese un título para el juego.");
    return false;
  }

  if (descripcion.trim() === "") {
    alert("Ingrese una descripción para el juego.");
    return false;
  }

  if (precio.trim() === "") {
    alert("Ingrese un precio para el juego.");
    return false;
  }

  if (isNaN(precio) || parseFloat(precio) <= 0) {
    alert("Ingrese un valor numérico válido y mayor a cero para el precio.");
    return false;
  }

  if (stock.trim() === "") {
    alert("Ingrese un stock para el juego.");
    return false;
  }

  if (isNaN(stock) || parseInt(stock) <= 0) {
    alert("Ingrese un valor numérico válido y mayor a cero para el stock.");
    return false;
  }

  if (imagen.trim() === "") {
    alert("Seleccione una imagen para el juego.");
    return false;
  }

  return true;
}
