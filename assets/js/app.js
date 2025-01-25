// Función para cargar contenido asíncrono en una sección
async function loadContent(sectionId, url) {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Error al cargar ${url}: ${response.statusText}`);
        }
        const content = await response.text();
        document.getElementById(sectionId).innerHTML = content;

        // Inicializa el carrusel si el contenido cargado corresponde a él
        if (sectionId === 'carousel') {
            initializeCarousel();
        }
    } catch (error) {
        console.error(`Error al cargar el contenido para #${sectionId}:`, error);
        document.getElementById(sectionId).innerHTML = `<p>Error al cargar el contenido.</p>`;
    }
}

// Función para inicializar el carrusel de Bootstrap
function initializeCarousel() {
    const carouselElement = document.querySelector('#carousel');
    if (carouselElement) {
        new bootstrap.Carousel(carouselElement); // Inicializa el carrusel
    }
}
// Inicialización al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    // Cargar los contenidos principales
    loadContent('header', '/components/header.php');
    loadContent('footer', '/components/footer.html');
    loadContent('newsletter', '/components/newsletter.html'); 
    loadContent('arrowup', '/components/arrowup.html');
    loadContent('destacados', '/components/destacados.php');
    loadContent('carousel', '/components/carousel.html'); // Se inicializa el carrusel después de cargar
});

document.getElementById('applyFilters').addEventListener('click', function() {
    let provincia = document.getElementById('filterProvincia').value;
    let tipo = document.getElementById('filterTipo').value;

    let params = new URLSearchParams();
    if (provincia) params.append('provincia', provincia);
    if (tipo) params.append('tipo', tipo);
    params.append('ajax', '1');

    fetch('espacios.php?' + params.toString())
        .then(response => response.json()) // Cambié text() por json()
        .then(data => {
            console.log('Respuesta del servidor:', data); // Log para ver el contenido de la respuesta
            let spacesContainer = document.getElementById('spaces');
            spacesContainer.innerHTML = '';
            
            if (data.length === 0) {
                spacesContainer.innerHTML = '<p class="text-center">No se encontraron espacios con los filtros seleccionados.</p>';
                return;
            }
            
            data.forEach(space => {
                let imagenRuta = `/assets/images/${space.tipo}/${space.titulo}/img1.png`;

                let card = `
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <img src="${imagenRuta}" class="card-img-top" alt="Imagen de ${space.titulo}">
                            <div class="card-body">
                                <h5 class="card-title">${space.titulo}</h5>
                                <p><strong>Ubicación:</strong> ${space.provincia}</p>
                                <p><strong>Tipo:</strong> ${space.tipo}</p>
                                <p><strong>Precio:</strong> ${space.precio} €/hora</p>
                                <a href="detalles.php?id=${space.id}" class="btn btn-primary btn-sm">Ver más</a>
                            </div>
                        </div>
                    </div>
                `;
                spacesContainer.innerHTML += card;
            });
        })
        .catch(error => console.error('Error al cargar espacios:', error));
});


function showModal() {
    var modal = new bootstrap.Modal(document.getElementById('sessionModal'));
    modal.show();
}

// Función para mostrar el alert
function showModal_newsletter() {
   // Obtener el valor del correo ingresado
   const email = document.getElementById('email').value;

   // Establecer el mensaje del modal
   const modalMessage = document.getElementById('modalMessage');
   if (email) {
     modalMessage.textContent = `¡Gracias por suscribirte! Hemos enviado un correo de confirmación a ${email}.`;
   } else {
     modalMessage.textContent = 'Por favor, ingresa un correo válido.';
   }

   // Mostrar el modal
   const modal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
   modal.show();
 }

 // Obtener el botón y agregar el evento de click
 document.getElementById('subscribeButton').addEventListener('click', showModal);


// para lo del boton de reservas

function alertaSesion() {
    // Mostrar el modal con id "sessionModal"
    var modal = new bootstrap.Modal(document.getElementById('sessionModal'));
    modal.show();
}

