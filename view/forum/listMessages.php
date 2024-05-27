<?php
    $sujet = $result["data"]['sujet']; 
    $messages = $result["data"]['messages']; 
?>

<h1>Liste des messages</h1>

<?php
foreach($messages as $message ){ ?>
    <p><a href="index.php?ctrl=forum&action=MessagesBySujet&id=<?= $sujet->getId() ?>"<?= $sujet->getId() ?>><?= $sujet ?></a> par <?= $sujet->getUtilisateur() ?> (<?= $sujet->getDateCreationSujet() ?>)<br><?= $message->getTexte() ?></p>
<?php }
