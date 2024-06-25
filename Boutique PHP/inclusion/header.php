<?php require_once('init.php') ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.3/lux/bootstrap.min.css"
    integrity="sha512-+TCHrZDlJaieLxYGAxpR5QgMae/jFXNkrc6sxxYsIVuo/28nknKtf9Qv+J2PqqPXj0vtZo9AKW/SMWXe8i/o6w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- link bootstrap et code html(navbars) copie de https://cdnjs.com/libraries/bootswatch https://bootswatch.com/lux/ respectivement-->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Boutique</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="<?= BASE ; ?>">Accueil <!--ici BASE c'est index.php-->
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE . "front/article.php" ; ?>">Articles</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">BACK OFFICE</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= BASE . "back/ajoutArticle.php" ; ?>">Ajouter un article</a>
            <a class="dropdown-item" href="<?= BASE . "back/gestionArticle.php" ; ?>">Gestion Article</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php if(isset($_SESSION['messages'])):
  foreach($_SESSION['messages'] as $type => $messages):
    foreach($messages as $message):
?>
<div class="text-center mx-auto alert alert-<?= $type ?>">
      <?= $message; ?>
</div>


<?php
    endforeach;
  endforeach;
  unset($_SESSION['messages']);
  endif; ?>
