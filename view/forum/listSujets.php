<?php
    $categorie = $result["data"]['categorie']; 
    $sujets = $result["data"]['sujets']; 
?>

<h1>Liste des sujets <?= $categorie->getCategorie() ?></h1>

<?php
foreach($sujets as $sujet ){ ?>
    <p><a href="#"><?= $sujet ?></a> par <?= $sujet->getUtilisateur() ?> (<?= $sujet->getDateCreationSujet() ?>)</p>
<?php }
