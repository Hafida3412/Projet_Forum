<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use PDO;
use Model\Managers\UtilisateurManager;


class SecurityController extends AbstractController{

     // contiendra les méthodes liées à l'authentification : register, login et logout
     // Affiche la vue du formulaire register
          //session_start();
    
    //MISE EN PLACE DE LA FONCTION S INSCRIRE
    public function register(){
    
           if (isset($_POST["submitRegister"])) {
            
                //FILTRER LES CHAMPS DU FORMULAIRE D INSCRIPTION:
                $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
                $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
                //VERIFIER LA VALIDITE DES FILTRES:
                if($pseudo && $email && $pass1 && $pass2){

                    // var_dump("ok");die;
                    $userManager = new UtilisateurManager();
                    $utilisateur = $userManager->checkUserExists($email);//création de la function checkUserExists dans utilisateurManager pour vérifier si l'utilisateur existe
                //SI L UTILISATEUR EXISTE
                    if($utilisateur){
                        header("Location: index.php?ctrl=security&action=register"); 
                        exit; 
                    } else {
                        //var_dump("utilisateur inexistant");die;
                        //insertion de l'utilisateur en BDD
                        if($pass1 == $pass2 && strlen($pass1) >= 5) {//VERIFICATION QUE LES MDP SONT IDENTIQUES
                            
                            $userManager->add([//on récupère la function add du fichier Manager
                                "pseudo" => $pseudo,
                                "email" => $email,
                                "password" => password_hash($pass1, PASSWORD_DEFAULT)
                            ]);

                            //REDIRECTION APRES L INSCRIPTION
                            header("Location: index.php?ctrl=security&action=login");
                            exit;
                        } else {
                            header("Location: index.php?ctrl=security&action=register");
                            exit;
                            // $this->redirectTo("security","register")
                        }
                    }
                }
            }
             return [
                "view" => VIEW_DIR . "connexion/register.php",
                "meta_description" => "Formulaire d'inscription"
            ];
    }  


    //MISE EN PLACE DE LA FONCTION SE CONNECTER
    public function login() {
        //On vérifie si le formulaire a été soumis
            if(isset($_POST["submitLogin"])) {
            //PROTECTION XSS (=FILTRES)
            //Nettoie et valide l'email pour éviter les attaques XSS et les mails invalides
                $email = filter_input(INPUT_POST, "email", 
                FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            //Nettoie le mot de passe pour éviter les attaques XSS
                $password = filter_input(INPUT_POST, "password", 
                FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            //Si l'email et le password sont valides
                if($email && $password) {/*REQUETE PREPARE POUR LUTTER CTRE 
            LES INJECTIONS SQL*/
                    // var_dump("ok");die;
            //On crée une instance de la classe UtilisateurManager pour gérer les utilisateurs
                    $userManager = new UtilisateurManager();
                //On vérifie si l'ultilisateur existe dans la base de données
                    $utilisateur = $userManager->checkUserExists($email);

                    if($utilisateur){//Si l'utilisateur existe
                        // var_dump($utilisateur);die;
            //On récupère le mot de passe haché de l'utilisateur depuis la base de données
                        $hash = $utilisateur->getPassword();

                        if(password_verify($password, $hash)){//VERIFICATION DU MDP 
                            $_SESSION["utilisateur"] = $utilisateur; //on stocke dans un tableau SESSION l'intégralité des infos du user
                            header("Location:index.php?ctrl=home&action=index");//SI CONNEXION REUSSIE: REDIRECTION VERS PAGE D ACCUEIL
                        //Dans Forum, la redirection sera par exemple: header("Location: index.php?ctrl=home&action=index&id=");    
                            exit;  
                        
                            } else {
                        // Erreur d'adresse mail ou de mot de passe
                            header("Location: index.php?ctrl=security&action=login");
                            exit;
                            }
                        } else {
                            // Utilisateur introuvable
                            header("Location: index.php?security&action=login");
                            exit;
                        }
                    }

                // Afficher le formulaire de connexion
            }
            return [
                "view" => VIEW_DIR . "connexion/login.php",
                "meta_description" => "Formulaire de connexion"
            ];
    }
    
    
    public function logout() {
        session_unset();// Supprimer toutes les données de la session
        // Redirection après la déconnexion
        header("Location: index.php");
        exit;
    }

}




        

