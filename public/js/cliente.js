(function () {
    // Obtener referencias a los elementos DOM necesarios
    var inputAjax = document.getElementById('buscar_ajax'); // Campo de búsqueda AJAX
    var contenedor = document.getElementById('catalogo-grid'); // Contenedor donde se muestran las tarjetas de canciones
    var estado = document.getElementById('catalogo-estado'); // Elemento para mostrar el estado/resultado
    var checkboxes = document.getElementsByName('generos[]'); // Checkboxes para filtrar por género

    // Salir si faltan elementos esenciales
    if (!inputAjax || !contenedor) {
        return;
    }

    // Configurar evento de entrada en el campo de búsqueda para filtrar en tiempo real
    inputAjax.oninput = function () {
        filtrarAjax();
    };

    // Configurar evento de cambio en cada checkbox de género para filtrar al marcar/desmarcar
    // for (var i = 0; i < checkboxes.length; i++) {
    //     checkboxes[i].onchange = function () {
    //         filtrarAjax();
    //     };
    // }

    // Función principal que realiza la petición AJAX para filtrar canciones
    // según el texto de búsqueda y los géneros seleccionados
    function filtrarAjax() {
        // Obtener el texto de búsqueda (cadena vacía si es null/undefined)
        var texto = inputAjax.value || '';
        var params = new URLSearchParams();
        params.append('buscar', texto); // Añadir término de búsqueda a los parámetros

        // Añadir los géneros seleccionados como parámetros
        // for (var i = 0; i < checkboxes.length; i++) {
        //     if (checkboxes[i].checked) {
        //         params.append('generos[]', checkboxes[i].value);
        //     }
        // }

        // Realizar petición fetch al endpoint de búsqueda AJAX
        fetch('/cliente/buscar-ajax?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indicar que es una petición AJAX
            }
        })
            .then(function (respuesta) {
                return respuesta.json(); // Convertir respuesta a JSON
            })
            .then(function (datos) {
                var lista = datos.canciones || []; // Obtener lista de canciones (o array vacío si no hay)
                pintarCanciones(lista); // Renderizar las canciones en el contenedor
            });
    }

    // Función que renderiza la lista de canciones en el contenedor
    // @param {Array} lista - Array de objetos canción a mostrar
    function pintarCanciones(lista) {
        // Limpiar el contenedor eliminando todos los hijos existentes
        while (contenedor.firstChild) {
            contenedor.removeChild(contenedor.firstChild);
        }

        // Si no hay resultados, mostrar mensaje informativo
        if (!lista.length) {
            var vacio = document.createElement('p');
            vacio.className = 'catalogo-vacio';
            vacio.textContent = 'No hay canciones registradas.';
            contenedor.appendChild(vacio);
            if (estado) {
                estado.textContent = ''; // Limpiar el estado
            }
            return;
        }

        // Crear y añadir una tarjeta para cada canción en la lista
        for (var i = 0; i < lista.length; i++) {
            contenedor.appendChild(crearCard(lista[i]));
        }

        // Actualizar el contador de resultados si el elemento existe
        if (estado) {
            estado.textContent = 'Resultados: ' + lista.length;
        }
    }

    // Función que crea el elemento DOM para una tarjeta de canción
    // @param {Object} cancion - Objeto con los datos de la canción
    // @returns {HTMLAnchorElement} Elemento enlace que contiene la tarjeta completa
    function crearCard(cancion) {
        // Crear el enlace que envuelve toda la tarjeta
        var enlace = document.createElement('a');
        enlace.className = 'catalogo-card-link';
        enlace.href = '/cliente/cancion/' + cancion.id; // Enlace a la página de detalle de la canción

        // Crear el contenedor de la tarjeta
        var card = document.createElement('article');
        card.className = 'catalogo-card';

        // Crear el contenedor de la imagen
        var cajaImagen = document.createElement('div');
        cajaImagen.className = 'catalogo-card-img';

        // Crear y configurar la imagen de la portada
        var imagen = document.createElement('img');
        imagen.src = cancion.portada;
        imagen.alt = 'Portada de ' + cancion.titulo;

        cajaImagen.appendChild(imagen);

        // Crear el contenedor del cuerpo de la tarjeta
        var cuerpo = document.createElement('div');
        cuerpo.className = 'catalogo-card-body';

        // Crear y configurar el título de la canción
        var titulo = document.createElement('h2');
        titulo.className = 'catalogo-subtitulo';
        titulo.textContent = cancion.titulo;

        // Crear y configurar el texto del artista
        var artista = document.createElement('p');
        artista.className = 'catalogo-texto';
        artista.textContent = 'Artista: ' + cancion.artista;

        // Ensamblar la estructura de la tarjeta
        cuerpo.appendChild(titulo);
        cuerpo.appendChild(artista);
        card.appendChild(cajaImagen);
        card.appendChild(cuerpo);
        enlace.appendChild(card);

        return enlace; // Devolver el enlace completo con la tarjeta dentro
    }
})();
