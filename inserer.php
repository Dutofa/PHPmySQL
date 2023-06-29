<?php
session_start();

// Connection à la base de données PDO
$database = new PDO ('mysql:host=localhost;dbname=twitter', 'root', '');

$jeveuxinserer = $database->prepare('INSERT INTO tweets (titre, tweet, date, couleur, user_id) VALUES (:titre, :tweet, NOW(), :couleur, :user_id)');
$jeveuxinserer->execute([
    'titre' => $_POST['montitre'],
    'tweet' => $_POST['montweet'],
    'couleur' => $_POST['couleur'],
    'user_id' => $_SESSION['user_id']
]);


// Rediriger vers la page principale
header("Location: index.php");