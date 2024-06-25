<?php require_once('../inclusion/header.php'); ?>
<?php
if(isset($_GET['id'])):
  
    $request = "SELECT * FROM articles WHERE id=:id";
    $response = $pdo->prepare($request);

    // $data = [
    //     'id' => $_GET['id']
    // ];
    // Autre manière:
    $response->execute(['id' => $_GET['id']]);
    $article = $response->fetch(PDO::FETCH_ASSOC);

    if(empty($article) ):
      header('location:gestionArticle.php');
      exit();
    endif;

else:
  header('location:gestionArticle.php');
  exit();


endif;

if(!empty($_POST)){
    if(($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/png' ||
        $_FILES['image']['type'] == 'image/webp') && $_FILES['image']['size'] < 3000000 ){

            $imageName = date_format(new DateTime(), 'dmYHis') . uniqid() . $_FILES['image']['name'];

            //on supprime la précédente photo grace à la métode unlink qui attend 1 argument le chemin complet d'accès au fichier à supperimer
            unlink('../assets/upload/' . $_POST['ancienneImg']);

            //on copie dans notre répertoire d'upload le fichier chargé et renommé
            copy($_FILES['image']['tmp_name'], '../assets/upload/' . $imageName);

        }else{

            $imageName = $_POST['ancienneImg'];

        }

        $data = [
            'nom' => $_POST['nom'],
            'image' => $imageName,
            'description' => $_POST['description'],
            'prix' => $_POST['prix'],
            'taille' => $_POST['taille'],
            'id' => $_GET['id']
        ];

        $request = "UPDATE articles SET nom=:nom, image=:image, description=:description, prix=:prix, taille=:taille WHERE id=:id";

        $response = $pdo->prepare($request);
        $response->execute(traitement($data));

        $_SESSION['messages']['success'][] = 'Annonce modifié avec succès';

        header('location:gestionArticle.php');
        exit();
}


?>

<!-- le form du fichier 'ajoutArticle.php' -->
<div class="container">
<h1 class="text-center">Ajouter un article</h1>

<form method="post" enctype="multipart/form-data">
  <fieldset>
    
    <div class="form-group">
      <label for="nom" class="form-label mt-4">Nom de l'article</label>
      <input type="text" class="form-control" id="nom" placeholder="Nom de l'article" name="nom" value="<?= $article['nom']; ?>"> <!-- name="" obligé en input -->
    </div>
    <div class="form-group">
      <label for="prix" class="form-label mt-4">Prix</label>
      <input type="number" class="form-control" id="prix" placeholder="Prix" min="0" step="0.01" name="prix" value="<?= $article['prix']; ?>">
    </div>
    <div class="form-group">
      <label for="description" class="form-label mt-4">Description</label>
      <textarea class="form-control" id="description" name="description" value=""><?= $article['description']; ?></textarea>
    </div>
    <div class="form-group">
      <label for="image" class="form-label mt-4">Image</label>
      <input class="form-control" type="file" id="image" name="image">
    </div>
    <div class="form-group">
      <label for="taille" class="form-label mt-4">Taille</label>
      <select class="form-select" id="taille" name="taille">
        <option value="xs" <?= $article['taille'] == 'xs' ? 'selected': "" ; ?>>XS</option> <!--value="" obligé en option pour récupérer le valeur du option -->
        <option value="s" <?= $article['taille'] == 's' ? 'selected': "" ; ?>>S</option>
        <option value="m" <?= $article['taille'] == 'm' ? 'selected': "" ; ?>>M</option>
        <option value="l" <?= $article['taille'] == 'l' ? 'selected': "" ; ?>>L</option>
        <option value="xl" <?= $article['taille'] == 'xl' ? 'selected': "" ; ?>>XL</option>
        <option value="xxl" <?= $article['taille'] == 'xxl' ? 'selected': "" ; ?>>XXL</option>
      </select>
    </div>
    <input type="text" name="ancienneImg" hidden value="<?= $article['image'] ; ?>">
    <button type="submit" class="btn btn-primary">Ajouter</button>
  </fieldset>
</form>

</div>




<?php require_once('../inclusion/footer.php'); ?>