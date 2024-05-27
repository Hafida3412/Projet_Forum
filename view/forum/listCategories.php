<?php
    
/**
 * on initialise une variable permettant de récupérer ce que nous renvoie le
 * controller à l'index "catégories" du tableau de "data" 
 */   
 
    $categories = $result["data"]['categories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($categories as $categorie ){ ?>
    <p><a href="index.php?ctrl=forum&action=listSujetsByCategorie&id=<?= $categorie->getId() ?>"><?= $categorie->getCategorie() ?></a></p>
<?php }


  
