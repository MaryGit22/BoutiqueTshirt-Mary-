<?php require_once('../inclusion/header.php')  ?>
<?php

// ici on récupére tout les articles dans un objet PDOstatement.
$responses = $pdo->query("SELECT * FROM articles");

// ici on va transformer notre ojet $responses en tableau associatif
$articles = $responses->fetchAll(PDO::FETCH_ASSOC);
//debug($articles);

?>

<h1 class="text-center">Articles</h1>

<div class="container flex">
    <div class="row justify-content-center">

<!-- ici foreach(): endforeach; == foreach(){     } -->
<?php foreach($articles as $article) :   ?>

<div class="col-md-4">
    <div class="card border">
        <h2><?= $article['nom'] ; ?></h2>
    <div class="text-center">
        <img src="<?= BASE . 'assets/upload/' . $article['image'] ; ?>" alt="" width="200px">
    </div>
        <p class="my-2">
            <?= $article['description']; ?>
        </p>
        <h3 class="text-end">
            <?= $article['taille']; ?>
        </h3>
        <h3 class="text-end">
            <?=number_format($article['prix'], 2); ?> €
        </h3>
    
    </div>
</div>
    



<?php endforeach; ?>


    </div>
</div>

<?php require_once('../inclusion/footer.php')  ?>

