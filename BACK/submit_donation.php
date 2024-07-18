<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreDonante = $_POST['nombreDonante'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $provincia = $_POST['provincia'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $nombreMedicamento = $_POST['nombreMedicamento'];
    $otroMedicamento = $_POST['otroMedicamento'];
    $laboratorio = $_POST['laboratorio'];
    $presentacionMedicamento = $_POST['presentacionMedicamento'];
    $otraPresentacion = $_POST['otraPresentacion'];
    $cantidadMedicamento = $_POST['cantidadMedicamento'];
    $fechaVto = $_POST['fechaVto'];

    $sql = "INSERT INTO donaciones (nombreDonante, apellido, dni, telefono, email, provincia, direccion, cp, nombreMedicamento, otroMedicamento, laboratorio, presentacionMedicamento, otraPresentacion, cantidadMedicamento, fechaVto)
            VALUES (:nombreDonante, :apellido, :dni, :telefono, :email, :provincia, :direccion, :cp, :nombreMedicamento, :otroMedicamento, :laboratorio, :presentacionMedicamento, :otraPresentacion, :cantidadMedicamento, :fechaVto)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombreDonante', $nombreDonante);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':provincia', $provincia);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':cp', $cp);
    $stmt->bindParam(':nombreMedicamento', $nombreMedicamento);
    $stmt->bindParam(':otroMedicamento', $otroMedicamento);
    $stmt->bindParam(':laboratorio', $laboratorio);
    $stmt->bindParam(':presentacionMedicamento', $presentacionMedicamento);
    $stmt->bindParam(':otraPresentacion', $otraPresentacion);
    $stmt->bindParam(':cantidadMedicamento', $cantidadMedicamento);
    $stmt->bindParam(':fechaVto', $fechaVto);

    if ($stmt->execute()) {
        echo "Donación registrada exitosamente.";
    } else {
        echo "Error al registrar la donación.";
    }
}
?>