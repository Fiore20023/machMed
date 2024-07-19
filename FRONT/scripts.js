document.addEventListener('DOMContentLoaded', function () {
    // Cargar los datos del usuario para mostrar nombre y logo
    fetch('/api/userinfo')
        .then(response => response.json())
        .then(data => {
            document.getElementById('associationLogo').src = data.logoUrl;
            document.getElementById('userName').textContent = data.userName;
        })
        .catch(error => console.error('Error al obtener los datos del usuario:', error));

    // Cargar donaciones y pedidos desde la API
    fetch('/api/donations')
        .then(response => response.json())
        .then(donations => {
            const donationsContainer = document.getElementById('donations');
            donations.forEach(donation => {
                const donationElement = document.createElement('div');
                donationElement.className = 'grid-item';
                donationElement.innerHTML = `
                    <img src="${donation.logoUrl || 'https://via.placeholder.com/100'}" alt="${donation.nombreDonante}">
                    <h2>${donation.nombreDonante}</h2>
                    <p>${donation.nombreMed} - ${donation.cantidadMedicamento} unidades</p>
                    <p>${donation.fechaVto}</p>
                `;
                donationsContainer.appendChild(donationElement);
            });
        })
        .catch(error => console.error('Error al obtener las donaciones:', error));

    fetch('/api/requests')
        .then(response => response.json())
        .then(requests => {
            const requestsContainer = document.getElementById('requests');
            requests.forEach(request => {
                const requestElement = document.createElement('div');
                requestElement.className = 'grid-item';
                requestElement.innerHTML = `
                    <img src="${request.logoUrl || 'https://via.placeholder.com/100'}" alt="${request.nombre}">
                    <h2>${request.nombre}</h2>
                    <p>${request.diagnostico.join(', ')}</p>
                    <p>${request.cobertura} - ${request.obraSocial || request.prepaga}</p>
                `;
                requestsContainer.appendChild(requestElement);
            });
        })
        .catch(error => console.error('Error al obtener los pedidos:', error));
});

function search() {
    // Implementar la funcionalidad de búsqueda aquí
}
