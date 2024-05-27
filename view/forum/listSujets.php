<?php
    $categorie = $result["data"]['categorie']; 
    $sujets = $result["data"]['sujets']; 
?>
<br>
<h1>Liste des sujets <?= $categorie->getCategorie() ?></h1>
<br>
<?php
if($sujets) {
    foreach($sujets as $sujet ){ ?>
        <p><a href="index.php?ctrl=forum&action=MessagesBySujet&id=<?= $sujet->getId() ?>"<?= $sujet->getId() ?>><?= $sujet ?></a> par <?= $sujet->getUtilisateur() ?> (<?= date('d-m-Y H:i:s', strtotime($sujet->getDateCreationSujet())) ?>)</p>
    <br><?php }
} else {
    echo "<p>Pas de sujet pour le moment</p>";
}
