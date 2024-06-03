<?php
    $sujet = $result["data"]['sujet']; 
    $messages = $result["data"]['messages']; 
?>
<br>
<h1>Liste des messages</h1>
<br>
<?php

if($messages) {
foreach($messages as $message ){ ?>
 <?= $sujet->getUtilisateur() ?> 
 (<?= date('d-m-Y H:i:s', strtotime($message->getDateCreationMessage())) ?>)<br><?= $message->getTexte() ?><br><br></p>
<?php }
} else {
    echo "<p>Pas de sujet pour le moment</p>";
}
?>

<!-- Ajout du formulaire pour ajouter un nouveau message -->

<p> Créer un nouveau message</p>
<?php

?>
<form action="?ctrl=Forum&action=addNewMessage&id=<?= $sujet->getId() ?>" method="post">
    <textarea name="texte" rows="4" cols="50"></textarea><br>
    <input type="submit" name = "submitMessage" value="Ajouter un message">
</form>