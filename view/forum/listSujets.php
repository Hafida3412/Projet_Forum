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
?>

<!-- Ajout du formulaire pour ajouter un nouveau sujet -->
<div>
    <form action="?ctrl=Forum&action=addNewSujet&id=<?= $categorie->getId() ?>" method="post">
        <label for="titre_sujet">Titre du sujet :</label><br>
        <input type="text" name="titre_sujet"><br>
        
        <label for="texte_sujet">Contenu du sujet :</label><br>
        <textarea name="texte_sujet" rows="4" cols="50"></textarea><br>
        
        <input type="submit" name="submit" value="Ajouter un sujet">
    </form>
</div>
