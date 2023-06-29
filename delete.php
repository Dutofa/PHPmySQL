
<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  if (isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];
    
    // Supprimez le post de la base de données en utilisant l'ID fourni
    $request = $database->prepare("DELETE FROM tweets WHERE id = :post_id");
    $request->bindParam(':post_id', $postId);
    $request->execute();

    // Redirigez l'utilisateur vers une autre page après la suppression (par exemple, la page d'accueil)
    header("Location: index.php");
    exit();
  }
}
?>