<?php

session_start();

// Connection à la base de données PDO
$database = new PDO('mysql:host=localhost;dbname=twitter', 'root', '');

$jeveuxlesdonnes = $database->prepare('SELECT * FROM tweets ORDER BY id DESC');
$jeveuxlesdonnes->execute();
$lesdonnes = $jeveuxlesdonnes->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="grid">

        <nav class="firstcol">

            <div class="nav-links">
                    <div class="navlogo"><img src="img/logo-maison.png" alt="acceuil-logo"><a href="#">Acceuil</a></div>
                    <div class="navlogo"><img src="img/logo-rechercher.png" alt=""><a href="search.php">Rechercher</a></div>
                    <div class="navlogo"><img src="img/logo-profil.png" alt="connexion"><a href="login.php">Connexion</a></div>
                    <div class="navlogo"><img src="img/logo-profil-plus.png" alt="s'inscrire"><a href="register.php">S'inscrire</a></div>
            </div>

            <select id="color-filter"  class="navlogo">
                <option value="" selected>Toutes les couleurs</option>
                <option value="red" class="r-filtre">Rouge</option>
                <option value="blue" class="b-filtre">Bleu</option>
                <option value="green" class="v-filtre">Vert</option>
            </select>

            <form action="logout.php" method="post">
                <button class="navlogo" type="submit">Déconnexion</button>
            </form>
        </nav>

        <main class="secondcol">

            <div class="navbar"><img class="bluebird" src="img/logo-bird.png" alt="twitter-logo"><a href="#">Acceuil</a></div>

            <div class="tweet-box column">
            
                <form method="GET" action="search.php" class="margin-recherche">
                    <input class="padding-recherche" type="text" name="search_query" placeholder="Rechercher des tweets">
                    <button type="submit">Rechercher</button>
                </form>

                

                <?php
                if (isset($_GET['search_query'])) {
                    $searchQuery = $_GET['search_query'];

                    // Effectuer la recherche dans la base de données
                    $database = new PDO('mysql:host=localhost;dbname=twitter', 'root', '');
                    $query = $database->prepare('SELECT * FROM tweets WHERE titre LIKE :searchQuery OR tweet LIKE :searchQuery');
                    $query->bindValue(':searchQuery', '%' . $searchQuery . '%');
                    $query->execute();
                    $results = $query->fetchAll();

                    if (count($results) > 0) {
                        // Afficher les résultats de la recherche
                        foreach ($results as $result) {
                            // Afficher les détails du tweet
                            echo '<div class="tweet-p <?php echo $tagColorClass; ?>" data-color="<?php echo $tweet["couleur"]; ?>">';
                            echo '<h1>Id : ' . $result['user_id'] . '</h1>';
                            echo '<h2>' . $result['titre'] . '</h2>';
                            echo '<p class="text-tweet">' . $result['tweet'] . '</p>';
                            echo '<p>' . date("d/m/Y", strtotime($result['date'])) . ' à ' . date("H:i", strtotime($result['date'])) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        // Aucun tweet trouvé
                        echo 'Aucun tweet trouvé';
                    }
                }
                ?>

            </div>

        </main>

        <div>

            <form class="affichage-post" method="POST" action="inserer.php" enctype="multipart/form-data">
                <input class="post" type="text" name="montitre" placeholder="Votre titre" required>
                <textarea class="post" name="montweet" class="contenu-tweet" placeholder="Votre tweet" maxlength="125" rows="3"
                    required></textarea>
                <select class="post navlogo" name="couleur" required>
                    <option value="red">Rouge</option>
                    <option value="blue">Bleu</option>
                    <option value="green">Vert</option>
                </select>
                <button class="post tweeter" type="submit">Tweeter !</button>
            </form>

        </div>
    </div>

    <script src="main.js"></script>

</body>
</html>