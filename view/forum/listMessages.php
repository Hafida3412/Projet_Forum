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
        <?= $message->getTexte() ?><br><br>

        <?php
            // si l'utilisateur est connecté
            if(App\Session::getUtilisateur()) {
                // si l'id de l'utilisateur du message = id de l'utilisateur connecté 
                if(App\Session::getUtilisateur()->getId() == $message->getUtilisateur()->getId()) {
                ?>
                    <a href="index.php?ctrl=forum&action=supprimerMessage&id=<?=$message->getId() ?>"><button>Supprimer</button></a><br>
                    <?php   
                }
                
            }
        ?>
    <?php }
} else {
    echo "<p>Pas de message à supprimer pour le moment</p>";
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

<!--alors impossible de poster car le sujet est verrouillé-->
<?php } else {
    echo "<p>Vous ne pouvez plus poster car ce sujet est verrouillé !</p>";   
}?>


