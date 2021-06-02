<?php
$idFoto = $_POST["idPublicacion"];
$texto = $_POST["texto"];
$servername = "localhost";
$username = "root";
$password = "jose";
$dbname = "redSocial";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//$sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
$sql = 'update foto set contenido = "'.$texto.'" where idFoto ='.$idFoto;

if ($conn->query($sql) === TRUE) {
  echo "Publicación actualizada";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?> 