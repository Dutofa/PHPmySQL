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
    <title>PHPmySQL</title>
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

           <div class="tweet-box">

                <?php foreach ($lesdonnes as $tweet): ?>
                    <?php
                    $tagColorClass = '';

                    if ($tweet['couleur'] === 'red') {
                        $tagColorClass = 'red';
                    } elseif ($tweet['couleur'] === 'blue') {
                        $tagColorClass = 'blue';
                    } elseif ($tweet['couleur'] === 'green') {
                        $tagColorClass = 'green';
                    }


                    ?>

                    <div class="tweet-p <?php echo $tagColorClass; ?>" data-color="<?php echo $tweet['couleur']; ?>">

                        <h1 class="p-margin p-h1">Id :
                            <?php echo $tweet['user_id']; ?>
                        </h1>
                        <h2 class="p-margin p-h2">
                            <?php echo $tweet['titre']; ?>
                        </h2>
                        <p class="text-tweet p-margin p-contenu">
                            <?php echo $tweet['tweet']; ?>
                        </p>
                        <p class="p-margin p-date">
                            <?php echo "Fait le ". date("d/m/Y", strtotime($tweet['date'])) . " à " . date("H:i", strtotime($tweet['date'])); ?>
                        </p>
                        <form class="p-margin" method="POST" action="delete.php">
                            <input type="hidden" name="post_id" value="<?php echo $tweet['id']; ?>">
                            <button type="submit">Supprimer le post</button>
                        </form>

                    </div>

                <?php endforeach; ?>

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