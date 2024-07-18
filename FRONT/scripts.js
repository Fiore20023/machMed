document.getElementById('donateButton').addEventListener('click', function() {
    window.location.href = 'donate.html';
});

document.getElementById('requestButton').addEventListener('click', function() {
    window.location.href = 'request.html';
});

// Handle login form submission
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Perform login and redirect to dashboard if successful
});

// Handle donate form submission
document.getElementById('donateForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Handle donation submission

    const formData = new FormData(this);

    fetch('http://localhost/BACK/submit_donation.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        alert('Donación registrada exitosamente.');
        // Puedes agregar código adicional para limpiar el formulario o redirigir al usuario
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al registrar la donación.');
    });
});

// Handle request form submission
document.getElementById('requestForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Handle medication request submission

});

document.addEventListener('DOMContentLoaded', function () {
    // Suponiendo que los datos se obtienen de una API
    fetch('/api/userinfo')
        .then(response => response.json())
        .then(data => {
            document.getElementById('associationLogo').src = data.logoUrl;
            document.getElementById('userName').textContent = data.userName;
        })
        .catch(error => console.error('Error al obtener los datos del usuario:', error));
});

document.addEventListener("DOMContentLoaded", function() {
    const nombreMedicamento = document.getElementById("nombreMedicamento");
    const otroMedicamento = document.getElementById("otroMedicamento");
    const presentacionMedicamento = document.getElementById("presentacionMedicamento");
    const otraPresentacion = document.getElementById("otraPresentacion");

    nombreMedicamento.addEventListener("change", function() {
        otroMedicamento.style.display = this.value === "Otro" ? "block" : "none";
    });

    presentacionMedicamento.addEventListener("change", function() {
        otraPresentacion.style.display = this.value === "Otro" ? "block" : "none";
    });
});
