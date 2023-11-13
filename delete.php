<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=weatherapp;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['delete']) && isset($_POST['checkbox'])) {
        $deleteArray = $_POST['checkbox'];

        foreach ($deleteArray as $villeToDelete) {
            $stmt = $bdd->prepare("DELETE FROM météo WHERE ville = :ville");
            $stmt->bindParam(':ville', $villeToDelete);
            $stmt->execute();
        }

        header('Location: index.php'); 
        exit; 
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
