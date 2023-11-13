<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=weatherapp;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    try {
        $query = $bdd->query('SELECT * from météo');
        $meteo = $query->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<form method="post" action="delete.php">';
        echo '<table>';
        echo '<tr>';

        $tableLength = count($meteo[0]);
        for ($i = 0; $i < $tableLength; $i++) {
            $key = array_keys($meteo[0])[$i];
            echo '<th>' . $key . '</th>';
        }
        echo '<th>Delete</th>';
        echo '</tr>';

        $meteoLength=count($meteo);
        for ($j = 0; $j < $meteoLength; $j++) {
            echo '<tr>';
            $row = $meteo[$j];
            $rowValues = array_values($row);
            $rowValuesLength = count($rowValues);
        
            for ($k = 0; $k < $rowValuesLength; $k++) {
                $value = $rowValues[$k];
                echo '<td>' . $value . '</td>';
            }
            echo '<td><input type="checkbox" name="checkbox[]" value="' . $row['ville'] . '"></td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<input type="submit" name="delete" value="Delete Selected">';
        echo '</form>';

    if (isset($_POST['submit'])) {
        $ville = $_POST['ville'];
        $haut = $_POST['haut'];
        $bas = $_POST['bas'];

        $stmt = $bdd->prepare("INSERT INTO météo (ville, haut, bas) VALUES (:ville, :haut, :bas)");
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':haut', $haut);
        $stmt->bindParam(':bas', $bas);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            echo "<div>Error inserting data.</div>";
        }
        
    }

}
catch(Exception $e)
{
	
    die('Erreur : '.$e->getMessage());
}
?>
<form method="post">
    <div class="form_group">
        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville">
    </div>
    <div class="form_group">
        <label for="haut">Haut :</label>
        <input type="text" id="haut" name="haut">
    </div>
    <div class="form_group">
        <label for="bas">Bas :</label>
        <input type="text" id="bas" name="bas">
    </div>
    <input type="submit" name="submit">
</form>
</body>
</html>

