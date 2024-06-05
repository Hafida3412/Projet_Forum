<?php
    $sujet = $result["data"]['sujet']; 
    $messages = $result["data"]['messages']; 
?>
<br>
<h1>Liste des messages</h1>
<br>
<?php

if($messages) {
foreach($messages as $message ){ 
    ?><?= $sujet->getUtilisateur() ?>
 (<?= date('d-m-Y H:i:s', strtotime($message->getDateCreationMessage())) ?>)<br>
 <?= $message->getTexte() ?><button>Supprimer</button><br><br>
<?php }
} else {
    echo "<p>Pas de message pour le moment</p>";
}
?>

<!-- Ajout du formulaire pour ajouter un nouveau message -->

<p> Créer un nouveau message</p>

<?php
    if(!$sujet->getVerrouillage()) {//Si le sujet est verrouillé
?>
<?php

?>
<form action="?ctrl=Forum&action=addNewMessage&id=<?= $sujet->getId() ?>" method="post">
    <textarea name="texte" rows="4" cols="50"></textarea><br>
    <input type="submit" name = "submitMessage" value="Ajouter un message">
</form>

<?php } else {
    echo "<p>Vous ne pouvez plus poster car ce sujet est verrouillé !</p>";   
}?>


