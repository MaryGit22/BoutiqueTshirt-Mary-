<?php require_once('../inclusion/header.php'); ?>

<?php

//debug($_POST); //debug pour afficher l'array

// ici on vérifie que notre formulaire à été envoyé
if(!empty($_POST))
{
    // ici on vérifie que chaque input à été remplis
    if(!empty($_POST['nom']) && !empty($_POST['prix']) && !empty($_POST['description']) 
    && !empty($_POST['taille']) && !empty($_FILES['image']['name']))
    {
        // ici on vérifie que notre fichier soit de type (jpeg ou png ou webp) et on vérifie aussi que sa taille ne soit ni égale à 3mo ou les dépasses
        if(($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/png' ||
        $_FILES['image']['type'] == 'image/webp') && $_FILES['image']['size'] < 3000000 )
        {
            // condition d'existance du dossier d'upload
            if(!file_exists('../assets/upload'))
            {
                //méthode de PHP(mkdir) permettent de créer un dossier avec droits de lecture et d'écriture
                mkdir('../assets/upload', 777);
            }

            //16022023143523['unique id']['nom de votre fichier']
            // date_format attend deux arguments : 1 date et le format ici 'dmYHis'.
            // dmYHis => (d = day, m = month, Y = year, H = hour, i = minute, s = seconds)
            $imgName = date_format(new DateTime(), 'dmYHis') . uniqid() . $_FILES['image']['name'];
            
            copy($_FILES['image']['tmp_name'], "../assets/upload/" . $imgName);
            
            // tableau des valeurs à envoyer

            $data = [
                'nom' => $_POST['nom'],
                'image' => $imgName,
                'description' => $_POST['description'],
                'prix' => $_POST['prix'],
                'taille' => $_POST['taille']
            ];
            //ici on crée une variable contient notre requête
            $request = "INSERT INTO articles ( nom, image, description, prix, taille) VALUES (:nom, :image, :description, :prix, :taille)";
            
            //ici on prépare la requête à executer dans la base de donnée
            $response = $pdo->prepare($request);

            //ici on execute la requête en remplaçant les marquers (:nom, :image etc......) par les valeurs de notre tableau data
            $response->execute($data);
            //debug($response);

            $_SESSION['messages']['success'][] = 'Votre article a bien été ajouté';

            header('location:../front/article.php');
            exit();

        }

    }

}
//debug($_FILES);


?>


<div class="container">
<h1 class="text-center">Ajouter un article</h1>

<!-- code html(forms) copie de https://bootswatch.com/lux/ et modifié -->
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
        <option value="xs">XS</option> <!--value="" obligé en option pour récupérer le valeur du option -->
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