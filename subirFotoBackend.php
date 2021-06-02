<html>

<head>
  <title>Problema</title>
</head>

<body>
  <?php
  echo "Nombre temporal: ". $_FILES['foto']['tmp_name'].'</br>';
  echo "Nombre definitivo: ".$_FILES['foto']['name'].'</br>';
  $temp = $_FILES['foto']['tmp_name'];
  echo "<img src=\"$temp\">";
  copy($_FILES['foto']['tmp_name'], $_FILES['foto']['name']);
  echo "La foto se registro en el servidor.<br>";
  $nom = $_FILES['foto']['name'];
  echo "<img src=\"$nom\">";
  echo $nom;
  ?>
</body>

</html>