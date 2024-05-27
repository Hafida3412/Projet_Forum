<?php
    $sujet = $result["data"]['sujet']; 
    $messages = $result["data"]['messages']; 
?>

<h1>Liste des messages</h1>

<?php

if($messages) {
foreach($messages as $message ){ ?>
 <?= $sujet->getUtilisateur() ?> (<?= date('d-m-Y H:i:s', strtotime($message->getDateCreationMessage())) ?>)<br><?= $message->getTexte() ?></p>
<?php }
} else {
    echo "<p>Pas de sujet pour le moment</p>";
}