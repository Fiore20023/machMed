<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $nombreDonante = $_POST['nombreDonante'];
    $apellidoDonante = $_POST['apellido_donante'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $provincia = $_POST['provincia'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $nombreMedicamento = $_POST['nombreMed'];
    $laboratorio = $_POST['laboratorio'];
    $presentacionMedicamento = $_POST['presentacion'];
    $cantidadMedicamento = $_POST['cantidadMedicamento'];
    $fechaVto = $_POST['fechaVto'];

    // Verificar si el donante ya existe en la tabla donantes
    $stmt = $conn->prepare("SELECT id FROM donantes WHERE nombreDonante = ? AND apellido_donante = ? AND dni = ?");
    $stmt->bind_param('sss', $nombreDonante, $apellidoDonante, $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El donante ya existe, obtener su ID
        $row = $result->fetch_assoc();
        $donante_id = $row['id'];
    } else {
        // El donante no existe, insertarlo en la tabla donantes
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO donantes (nombreDonante, apellido_donante, dni, telefono, email, provincia, direccion, cp)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssss', $nombreDonante, $apellidoDonante, $dni, $telefono, $email, $provincia, $direccion, $cp);
        $stmt->execute();

        // Obtener el ID del nuevo donante insertado
        $donante_id = $stmt->insert_id;
    }

    // Insertar la donación en la tabla donations
    $stmt = $conn->prepare("INSERT INTO donations (donante_id, nombreDonante, apellido_donante, dni, telefono, email, provincia, direccion, cp, nombreMed, laboratorio, presentacion, cantidadMedicamento, fechaVto)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issssssssssiss', $donante_id, $nombreDonante, $apellidoDonante, $dni, $telefono, $email, $provincia, $direccion, $cp, $nombreMedicamento, $laboratorio, $presentacionMedicamento, $cantidadMedicamento, $fechaVto);

    if ($stmt->execute()) {
        echo "Donación registrada exitosamente!";
    } else {
        echo "Error al registrar la donación: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}
?>

