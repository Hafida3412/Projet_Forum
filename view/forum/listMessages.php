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
 <?= $sujet->getUtilisateur() ?> (<?= date('d-m-Y H:i:s', strtotime($message->getDateCreationMessage())) ?>)<br><?= $message->getTexte() ?><br><br></p>
<?php }
} else {
    echo "<p>Pas de sujet pour le moment</p>";
}