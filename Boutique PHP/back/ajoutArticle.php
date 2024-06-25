<?php require_once('../inclusion/header.php'); ?>

<?php

if(!empty($_POST))
{
    if(!empty($_POST['nom']) && !empty($_POST['prix']) && !empty($_POST['description']) 
    && !empty($_POST['taille']) && !empty($_FILES['image']['name']))
    {
        if(($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/png' ||
        $_FILES['image']['type'] == 'image/webp') && $_FILES['image']['size'] < 3000000 )
        {
           if(!file_exists('../assets/upload'))
            {
                
                mkdir('../assets/upload', 777);
            }
            $imgName = date_format(new DateTime(), 'dmYHis') . uniqid() . $_FILES['image']['name'];
            
            copy($_FILES['image']['tmp_name'], "../assets/upload/" . $imgName);
            
          $data = [
                'nom' => $_POST['nom'],
                'image' => $imgName,
                'description' => $_POST['description'],
                'prix' => $_POST['prix'],
                'taille' => $_POST['taille']
            ];
            
            $request = "INSERT INTO articles ( nom, image, description, prix, taille) VALUES (:nom, :image, :description, :prix, :taille)";
            
            $response = $pdo->prepare($request);

            $response->execute($data);
          
            $_SESSION['messages']['success'][] = 'Votre article a bien été ajouté';

            header('location:../front/article.php');
            exit();

        }

    }

}



?>


<div class="container">
<h1 class="text-center">Ajouter un article</h1>

<form method="post" enctype="multipart/form-data">
  <fieldset>
    
    <div class="form-group">
      <label for="nom" class="form-label mt-4">Nom de l'article</label>
      <input type="text" class="form-control" id="nom" placeholder="Nom de l'article" name="nom"> <!-- name="" obligé en input -->
    </div>
    <div class="form-group">
      <label for="prix" class="form-label mt-4">Prix</label>
      <input type="number" class="form-control" id="prix" placeholder="Prix" min="0" step="0.01" name="prix">
    </div>
    <div class="form-group">
      <label for="description" class="form-label mt-4">Description</label>
      <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <div class="form-group">
      <label for="image" class="form-label mt-4">Image</label>
      <input class="form-control" type="file" id="image" name="image">
    </div>
    <div class="form-group">
      <label for="taille" class="form-label mt-4">Taille</label>
      <select class="form-select" id="taille" name="taille">
        <option value="xs">XS</option>
        <option value="s">S</option>
        <option value="m">M</option>
        <option value="l">L</option>
        <option value="xl">XL</option>
        <option value="xxl">XXL</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
  </fieldset>
</form>

</div>

<?php require_once('../inclusion/footer.php'); ?>