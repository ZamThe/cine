<html>




<?php
include 'conexion.php';

$sql = "SELECT * FROM cartelera";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
echo $row['id_pelicula'];
echo $row['Descripcion'];

}
?>

</html>