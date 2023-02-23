<?php 
require_once('../inclusion/init.php');

if(!empty($_GET['id']))
{
    //$data = ["id" => intval($_GET['id'])];
    $request="DELETE FROM articles WHERE id=:id";
    $response = $pdo->prepare($request);
    $response->execute(['id' => $_GET['id']]);

    $_SESSION['messages']['success'][] = "L'article a bien été supprimé";
    header('location:gestionArticle.php');
    exit();
}

// pour supprimer mettre le chemin dans l'navigateur
//par le chemin loclahost/Boutique_PHP/back/supprimerArticle?id=3