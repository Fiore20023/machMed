<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

var_dump($_ENV); // Esto es solo para depuración, recuerda quitarlo en producción

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define las variables para almacenar los datos del formulario
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
    

    try {
        // Preparar la consulta SQL con marcadores de posición (?)
        $stmt = $conn->prepare("INSERT INTO solicitudes (nombre, apellido, dni, telefono, email, provincia, direccion, cp, nombreMed, laboratorio, presentacion, fechaElab, fechaVto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Vincular parámetros a la consulta preparada
        $stmt->bind_param("ssssssssssssss", $nombre, $apellido, $dni, $telefono, $email, $provincia, $direccion, $cp, $nombreMed, $laboratorio, $presentacion, $fechaElab, $fechaVto);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Redirigir a una página de éxito o mostrar un mensaje
        echo "Solicitud enviada correctamente.";
        
        // Cerrar la conexión y liberar recursos
        $stmt->close();
        $conn->close();
        
    } catch (mysqli_sql_exception $e) {
        // Manejar excepciones de MySQL
        echo "Error en la ejecución de la consulta: " . $e->getMessage();
    }
} else {
    // Si no se envió el formulario por el método POST, redirigir o manejar el flujo según corresponda
    echo "No se recibieron datos por el método POST.";
}
?>
<?php
// Verificar que todas las claves existan en $_POST
if (isset($_POST['nombreMed'], $_POST['presentacion'],  $_POST['fechaElab'], $_POST['fechaVto'])) {
    $nombreMed = $_POST['nombreMed'];
    $presentacion = $_POST['presentacion'];
    $fechaElab = $_POST['fechaElab'];
    $fechaVto = $_POST['fechaVto'];

    // Configuración de la base de datos
    $db_host = 'localhost';
    $db_name = 'donation_requests';
    $db_username = 'root';
    $db_password = '';

    // Conexión a la base de datos
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta para insertar datos en la tabla solicitud
    $sql = "INSERT INTO solicitudes (nombreMed, presentacion, fechaElab, fechaVto) VALUES ('$nombreMed', '$presentacion',  '$fechaElab', '$fechaVto')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso.";
    } else {
        echo "Error en la ejecución de la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Faltan datos en el formulario.";
}
?>
