
//Animaciones para las alertas de errores o mensajes exitosos
setTimeout(function() {
    var alerta = document.getElementById('alerta');
    if (alerta) {
        alerta.style.animation = 'aparecer 2s forwards'; // Ajusta la duración de la animación de aparición
        setTimeout(function() {
            alerta.style.animation = 'desaparecer 5s forwards'; // Ajusta la duración de la animación de desaparición
            setTimeout(function() {
                alerta.style.display = 'none';
            }, 5000); // Ajusta el tiempo de espera antes de ocultar el elemento
        }, 200); // Ajusta el tiempo de espera antes de iniciar la animación de desaparición
    }
}, 10000);


//Funcion buscar input buscar panelAdminitrador
document.getElementById('buscar').addEventListener('input', function() {
    var input = this.value.toLowerCase();
    var usuarios = document.getElementsByClassName('correoUsuario');
    for (var i = 0; i < usuarios.length; i++) {
        var correo = usuarios[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        if (correo.includes(input)) {
            usuarios[i].style.display = 'table-row';
        } else {
            usuarios[i].style.display = 'none';
        }
    }
});
//Funcion para el input de buscar en Tienda
document.getElementById('buscar').addEventListener('input', function() {
    var input = this.value.toLowerCase();
    var juegos = document.getElementsByClassName('juego');

    for (var i = 0; i < juegos.length; i++) {
        var titulo = juegos[i].getElementsByClassName('titulo')[0].textContent.toLowerCase();
        if (titulo.includes(input)) {
            juegos[i].style.display = 'block';
        } else {
            juegos[i].style.display = 'none';
        }
    }
});


//Funcion buscar input buscar revisarPedidos
document.getElementById('buscar').addEventListener('input', function() {
    var input = this.value.toLowerCase();
    var pedidos = document.getElementsByClassName('tabla-principal')[0].getElementsByTagName('tr');
    for (var i = 1; i < pedidos.length; i++) { // Start from index 1 to exclude table header row
        var idPedido = pedidos[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        if (idPedido.includes(input)) {
            pedidos[i].style.display = 'table-row';
        } else {
            pedidos[i].style.display = 'none';
        }
    }
});

//Funcion buscar input buscar panelJefe 
document.getElementById('buscar').addEventListener('input', function() {
    var input = this.value.toLowerCase();
    var pedidos = document.getElementsByClassName('tabla-principal')[0].getElementsByTagName('tr');
    for (var i = 1; i < pedidos.length; i++) { // Start from index 1 to exclude table header row
        var segundoValor = pedidos[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        if (segundoValor.includes(input)) {
            pedidos[i].style.display = 'table-row';
        } else {
            pedidos[i].style.display = 'none';
        }
    }
});
/* script para eliminar -1 de stock cuando se presiona agregar al carro */

var botonesAgregarCarrito = document.getElementsByClassName("agregar-carrito");

  // Recorrer cada botón y agregar el evento de clic
  for (var i = 0; i < botonesAgregarCarrito.length; i++) {
    botonesAgregarCarrito[i].addEventListener("click", function() {
      // Obtener el elemento <p> del stock correspondiente al botón presionado
      var stockSeleccionado = this.parentNode.querySelector(".stock");
      // Obtener el valor actual del stock
      var stock = parseInt(stockSeleccionado.innerText.split(" ")[1]);
      // Verificar si hay suficiente stock para restar 1
      if (stock >= 1) {
        // Restar 1 al stock
        stock--;
        // Actualizar el contenido del elemento <p> con el nuevo stock
        stockSeleccionado.innerText = "Stock: " + stock;
      }
    });
  }

