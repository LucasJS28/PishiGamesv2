/* Este Documento JS busca poder juntar todo el Codigo AJAX para mayor entendimiento */

/* Ajax tienda.php */

// Manejador de evento clic para los botones "Agregar al Carrito"
var agregarCarritoButtons = document.getElementsByClassName('agregar-carrito');
// Recorrer todos los elementos obtenidos
for (var i = 0; i < agregarCarritoButtons.length; i++) {
    // Agregar un event listener para el evento 'click'
    agregarCarritoButtons[i].addEventListener('click', function(event) {
        event.preventDefault(); // Evitar que se envíe el formulario

        // Obtener el ID del juego desde el atributo 'data-id'
        var idJuego = this.getAttribute('data-id');

        // Crear una nueva solicitud XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Configurar la solicitud
        xhr.open('POST', '', true); // Realizar una solicitud POST al mismo documento actual
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Establecer la cabecera 'Content-Type'

        // Definir la función de retorno de llamada cuando cambie el estado de la solicitud
        xhr.onreadystatechange = function() {
        /* xhr.readyState === 4 verifica si el estado de la solicitud es 4, lo cual significa que la solicitud ha sido completada.
            xhr.status === 200 verifica si el estado de la respuesta del servidor es 200, lo cual indica que la solicitud se ha realizado 
            correctamente y sin errores. El código de estado 200 en HTTP significa "OK" y se utiliza para indicar una respuesta exitosa del servidor. */
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Procesar la respuesta recibida del servidor
                var response = xhr.responseText;
                var alertaDiv = document.getElementById('alerta');

                if (response === "<div id='alerta' class='AlertaBuena'>Se añadió una nueva copia al Carro</div>") {
                    // Mostrar mensaje de éxito
                    alertaDiv.innerHTML = "Se añadió una nueva copia al Carro";
                    alertaDiv.className = "AlertaBuena";
                } else if (response === "<div id='alerta' class='AlertaBuena'>Se añadió al Carrito</div>") {
                    // Mostrar otro mensaje de éxito
                    alertaDiv.innerHTML = "Se añadió al Carrito";
                    alertaDiv.className = "AlertaBuena";
                } else {
                    // Mostrar mensaje de error u otra respuesta desconocida
                    alertaDiv.innerHTML = response;
                    alertaDiv.className = "AlertaError";
                }
            }
        };
        // Enviar la solicitud al servidor con los datos necesarios
        xhr.send('agregarCarrito=true&idJuego=' + idJuego);
    });
}




/* Funciones AJAX para revisarPedidos.php */
function actualizarEstadoPedido(idPedido, estado) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "revisarPedidos.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            alert("Pedido Actualizado con Exito");
            console.log(xhr.responseText);
        }
    };
    xhr.send("idPedido=" + encodeURIComponent(idPedido) + "&estado=" + encodeURIComponent(estado));
}

function eliminarPedido(idPedido) {
    var confirmacion = confirm("¿Estás seguro de que deseas cancelar este pedido?");
    if (confirmacion) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "revisarPedidos.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                alert("Producto Eliminado con Éxito");
                console.log(xhr.responseText);
                // Eliminar la fila del pedido de la tabla sin recargar la página
                var fila = document.getElementById("fila-" + idPedido); //Elimina el tr con el ID que se genera con cada una de las tablas
                if (fila) {
                    fila.parentNode.removeChild(fila);
                }
            }
        };
        xhr.send("idPedidoCancelar=" + encodeURIComponent(idPedido) + "&confirmacion_" + idPedido + "=si");
    }
}


//Ajax del panelAdministrador

function eliminarUsuario(correoUsuario) { //No  se por que no funciona al 100 el borrar
    var confirmacion = confirm("¿Estás seguro de que deseas eliminar este usuario?");
    if (confirmacion) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText); // Agregar esta línea para imprimir la respuesta en la consola
                if (this.responseText.trim() === "success") {
                    // Elimina la fila de usuario eliminado sin recargar la página
                    var fila = document.getElementById("fila-" + correoUsuario);
                    if (fila) {
                        fila.parentNode.removeChild(fila);
                    }
                }
            }
        };
        xhttp.open("POST", "panelAdministrador.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("eliminarUsuario=" + correoUsuario);
    }
}

function actualizarRol(correoUsuario, nuevoRol) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText === "success") {
                // Actualiza el campo de rol sin recargar la página
                var campoRol = document.querySelector("td[data-correo='" + correoUsuario + "'] select");
                if (campoRol) {
                    campoRol.value = nuevoRol;
                }
            }
        }
    };
    xhttp.open("POST", "panelAdministrador.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("correoUsuario=" + correoUsuario + "&rol=" + nuevoRol);
}




/* AJax para el panel jefe */
$(document).ready(function() {

    // Función para mostrar alertas flotantes (asegúrate de que esta función esté definida, ya la tenías en mi ejemplo anterior)
    function mostrarAlerta(mensaje, tipo) {
        var alerta = $('<div class="alerta-flotante ' + (tipo === 'success' ? 'alerta-buena' : 'alerta-mala') + '">' + mensaje + '</div>');
        $('body').append(alerta);

        // Animar la entrada
        setTimeout(function() {
            alerta.css({
                'opacity': '1',
                'transform': 'translateX(-50%) translateY(0)'
            });
        }, 50);

        // Animar la salida y remover
        setTimeout(function() {
            alerta.css({
                'opacity': '0',
                'transform': 'translateX(-50%) translateY(-20px)'
            });
            alerta.on('transitionend', function() {
                $(this).remove();
            });
        }, 3000);
    }

    // Interceptar el envío del formulario de MODIFICAR PRECIO, STOCK o ELIMINAR
    // Usamos delegación de eventos porque los formularios están dentro de la tabla
    $(document).on('submit', '.form-accion-jefe', function(e) {
        e.preventDefault(); // Evita el envío normal del formulario (recarga de página)

        var $form = $(this);
        var formData = $form.serialize(); // Serializa los datos del formulario (id, accion, precio/stock)
        var accion = $form.find('input[name="accion"]').val(); // Obtiene la acción (modificar_precio, modificar_stock, eliminar)
        var idJuego = $form.find('input[name="id"]').val(); // Obtiene el ID del juego
        var $row = $form.closest('tr'); // Encuentra la fila (<tr>) que contiene este formulario

        $.ajax({
            url: 'panelJefe.php', // La URL a la que se envía la petición
            type: 'POST',
            data: formData,
            dataType: 'json', // Esperamos una respuesta en formato JSON desde el servidor
            success: function(response) {
                if (response.success) {
                    mostrarAlerta(response.message, 'success');

                    // Actualizar solo el elemento afectado en la tabla, sin recargar toda la tabla
                    if (accion === 'modificar_precio') {
                        // El PHP devuelve 'nuevo_valor', que es el precio actualizado
                        $form.find('input[name="precio"]').val(response.nuevo_valor);
                    } else if (accion === 'modificar_stock') {
                        // El PHP devuelve 'nuevo_valor', que es el stock actualizado
                        $form.find('input[name="stock"]').val(response.nuevo_valor);
                    } else if (accion === 'eliminar') {
                        // Si se elimina, queremos remover la fila completa de la tabla
                        $row.fadeOut(500, function() {
                            $(this).remove(); // Quita la fila del DOM después de desvanecerla
                            // Opcional: Si no quedan productos, mostrar un mensaje
                            if ($('.tabla-principal tbody tr:visible').length === 0) {
                                $('.contenedor-tabla').append('<p class="no-pedidos">No se encontraron productos para modificar.</p>');
                            }
                        });
                    }

                } else {
                    mostrarAlerta(response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX en panelJefe:", status, error);
                console.log("Respuesta del servidor:", xhr.responseText); // Útil para depurar errores del servidor
                mostrarAlerta('Ha ocurrido un error al procesar la acción. Inténtelo de nuevo.', 'error');
            }
        });
    });

    // Tu lógica existente para el buscador (que filtra en el cliente, no necesita AJAX adicional para esto)
    $('#buscar').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        // Asegúrate de que esta selección apunte a las filas de tu tabla de productos
        $('.tabla-principal tbody tr').each(function() {
            var rowContent = $(this).text().toLowerCase(); // Obtiene todo el texto de la fila
            if (rowContent.includes(searchTerm)) {
                $(this).show(); // Muestra la fila si coincide
            } else {
                $(this).hide(); // Oculta la fila si no coincide
            }
        });
    });

});