<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $provincia = $_POST['provincia'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $nombreMed = $_POST['nombreMed'];
    $laboratorio = $_POST['laboratorio'];
    $presentacion = $_POST['presentacion'];
    $cantidadMedicamento = $_POST['cantidadMedicamento'];
    $fechaEntrega = $_POST['fechaEntrega'];

    // Manejo de archivo subido
    if (isset($_FILES['fotoReceta']) && $_FILES['fotoReceta']['error'] == UPLOAD_ERR_OK) {
        $fotoRecetaTmp = $_FILES['fotoReceta']['tmp_name'];
        $fotoRecetaNombre = basename($_FILES['fotoReceta']['name']);
        $fotoRecetaDestino = __DIR__ . '/uploads/' . $fotoRecetaNombre;

        // Mover el archivo a la carpeta de destino
        if (!move_uploaded_file($fotoRecetaTmp, $fotoRecetaDestino)) {
            die("Error al subir la foto de la receta.");
        }
    } else {
        $fotoRecetaNombre = null;
    }

    try {
        // Preparar la consulta SQL con marcadores de posición (?)
        $stmt = $conn->prepare("INSERT INTO solicitudes (nombre, apellido, dni, telefono, email, provincia, direccion, cp, nombreMed, laboratorio, presentacion, cantidadMedicamento, fechaEntrega, fotoReceta)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Vincular parámetros a la consulta preparada
        $stmt->bind_param("ssssssssssssss", $nombre, $apellido, $dni, $telefono, $email, $provincia, $direccion, $cp, $nombreMed, $laboratorio, $presentacion, $cantidadMedicamento, $fechaEntrega, $fotoRecetaNombre);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        echo "Solicitud enviada correctamente.";
        
        // Cerrar la conexión y liberar recursos
        $stmt->close();
        $conn->close();
        
    } catch (mysqli_sql_exception $e) {
        echo "Error en la ejecución de la consulta: " . $e->getMessage();
    }
} else {
    echo "No se recibieron datos por el método POST.";
}
?>
