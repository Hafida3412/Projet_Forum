<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use PDO;

class SecurityController extends AbstractController{

     // contiendra les méthodes liées à l'authentification : register, login et logout
     // Affiche la vue du formulaire register
        //session_start();
    public function register(){
       
        if (isset($_POST["submitRegister"])) {
        
        //CONNEXION A LA BASE DE DONNEES:
        $pdo = new PDO("mysql: host=localhost; dbname=forum_hafida;charset=utf8", "root", "");
            
        //FILTRER LES CHAMPS DU FORMULAIRE D INSCRIPTION:
        $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       
        //VERIFIER LA VALIDITE DES FILTRES:
        if($pseudo && $email && $pass1 && $pass2){
           //var dump("ok");die;
           //pour lutter contre les injections SQL: requête prepare
           $requete = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");//requete préparée se fait par un champ paramétré préfixé par un dble point(:email)
           $requete->execute(["email" => $email]);
           $utilisateur = $requete->fetch();
           //SI L UTILISATEUR EXISTE
           if($utilisateur){
               header("Location: index.php?ctrl=register"); 
           exit; 
           } else {
               //var dump("utilisateur inexistant");die;
               //insertion de l'utilisateur en BDD
           if($pass1 == $pass2 && strlen($pass1) >= 5) {//VERIFICATION QUE LES MDP SONT IDENTIQUES
               $insertUser = $pdo->prepare("INSERT INTO utilisateur (pseudo, email, password) VALUES (:pseudo, :email, :password)");
               $insertUser->execute([
                "pseudo" =>"pseudo",
                "email" => "email",
                "password" => password_hash($pass1, PASSWORD_DEFAULT)
            ]);
            //REDIRECTION APRES L INSCRIPTION
            header("Location: index.php?ctrl=login");
            exit;
        } else {
            header("Location: index.php?ctrl=register");
            exit;
        }
    }
}
}
        // Afficher le formulaire d'inscription
        include(VIEW_DIR."register.php");
    }
      

    public function login() {
    if($_POST["submitLogin"]){
        //CONNEXION A LA BASE DE DONNEES:
        $pdo = new PDO("mysql: host=localhost; dbname=forum_hafida;charset=utf8", "root", "");
       
        //PROTECTION XSS (=FILTRES)
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        if($email && $password) {//REQUETE PREPARE POUR LUTTER CTRE LES INJECTIONS SQL
            $requete = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
            $requete->execute(["email" => $email]);
            $utilisateur = $requete->fetch();
            //var_dump($user);die;
            //si l'utilisateur existe
            if($utilisateur){
                $hash = $utilisateur["password"];
                if(password_verify($_POST["password"], $hash)){//VERIFICATION DU MDP
            $_SESSION["utilisateur"] = $utilisateur; //on stocke dans un tableau SESSION l'intégralité des infos du user
            header("Location:index.php?ctrl=home&action=index&id=");//SI CONNEXION REUSSIE: REDIRECTION VERS PAGE D ACCUEIL
//Dans Forum, la redirection sera par exemple: header("Location: index.php?ctrl=home&action=index&id=");    
            exit;  
        
                } else {
                    // Mauvais mot de passe
                    header("Location: index.php?ctrl=login");
                    exit;
                }
            } else {
                // Utilisateur introuvable
                header("Location: index.php?ctrl=login");
                exit;
            }
        }

        // Afficher le formulaire de connexion
        include(VIEW_DIR."login.php");
    }
    
    
}
public function logout() {
    session_unset();// Supprimer toutes les données de la session
    // Redirection après la déconnexion
    header("Location: index.php");
    exit;
}
}

        

