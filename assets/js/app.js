// Función para cargar contenido asíncrono en una sección
async function loadContent(sectionId, url) {
    try {
        const section = document.getElementById(sectionId);
        if (!section) return;

        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Error al cargar ${url}: ${response.statusText}`);
        }
        section.innerHTML = await response.text();

        if (sectionId === 'carousel') {
            initializeCarousel();
        }
    } catch (error) {
        console.error(`Error al cargar el contenido para #${sectionId}:`, error);
        document.getElementById(sectionId).innerHTML = `<p>Error al cargar el contenido.</p>`;
    }
}

function initializeCarousel() {
    const carouselElement = document.getElementById('carousel');
    if (carouselElement) {
        new bootstrap.Carousel(carouselElement); 
    }
}

// Inicialización al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    // Cargar los contenidos principales
    const sections = {
        header: '/components/header.php',
        footer: '/components/footer.html',
        newsletter: '/components/newsletter.php',
        arrowup: '/components/arrowup.html',
        destacados: '/components/destacados.php',
        carousel: '/components/carousel.html'
    };

    Object.entries(sections).forEach(([sectionId, url]) => loadContent(sectionId, url));

    const applyFiltersButton = document.getElementById('applyFilters');
    if (applyFiltersButton) {
        applyFiltersButton.addEventListener('click', applyFilters);
    }

    const subscribeButton = document.getElementById('subscribeButton');
    if (subscribeButton) {
        subscribeButton.addEventListener('click', showModal_newsletter);
    }
});

// Función para aplicar filtros
function applyFilters() {
    let provincia = document.getElementById('filterProvincia')?.value || '';
    let tipo = document.getElementById('filterTipo')?.value || '';

    let params = new URLSearchParams();
    if (provincia) params.append('provincia', provincia);
    if (tipo) params.append('tipo', tipo);
    params.append('ajax', '1');

    fetch(`espacios.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data);
            const spacesContainer = document.getElementById('spaces');
            if (!spacesContainer) return;

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
                spacesContainer.insertAdjacentHTML('beforeend', card);
            });
        })
        .catch(error => console.error('Error al cargar espacios:', error));
}

function showModal() {
    const modalElement = document.getElementById('sessionModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
}

// Función para mostrar el modal del newsletter
function showModal_newsletter(event) {
    event.preventDefault(); 

    const emailInput = document.getElementById('email');
    const modalMessage = document.getElementById('modalMessage');
    const modalElement = document.getElementById('subscriptionModal');

    if (!emailInput || !modalMessage || !modalElement) return;

    const email = emailInput.value.trim();
    modalMessage.textContent = email
        ? `¡Gracias por suscribirte! Hemos enviado un correo de confirmación a ${email}.`
        : 'Por favor, ingresa un correo válido.';

    const modal = new bootstrap.Modal(modalElement);
    modal.show();

    emailInput.value = ""; 
}

// Función para mostrar el modal de reserva
function alertaSesion() {
    const modalElement = document.getElementById('sessionModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
}


document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("togglePassword");
    const passwordField = document.getElementById("password");

    togglePassword.addEventListener("click", function () {
        // Alternar entre 'password' y 'text' para que se vea la contraseña
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;

        // Cambiar el icono
        this.innerHTML = type === "password" ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
    });
});
