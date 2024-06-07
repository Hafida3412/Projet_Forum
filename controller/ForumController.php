<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategorieManager;
use Model\Managers\SujetManager;
use Model\Managers\MessageManager;//rajout du Manager pour pouvoir afficher les messages
use Model\Managers\UtilisateurManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categorieManager = new CategorieManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categorieManager->findAll(["categorie", "ASC"]);
       
        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    //Affichage des sujets par catégorie
    public function listSujetsByCategorie($id) {

        $sujetManager = new SujetManager();
        $categorieManager = new CategorieManager();
        $categorie = $categorieManager->findOneById($id);
        $sujets = $sujetManager->findTopicsByCategorie($id);

        return [
            "view" => VIEW_DIR."forum/listSujets.php",
            "meta_description" => "Liste des sujets par catégorie : ".$categorie,
            "data" => [
                "categorie" => $categorie,
                "sujets" => $sujets
            ]
        ];
    }

    //Affichage des messsages par sujet
    public function MessagesBySujet($id) {

        $messageManager = new MessageManager();
        $sujetManager = new SujetManager();
        $sujet = $sujetManager->findOneById($id);
        $messages = $messageManager->findMessagesBySujet($id);

        return [
            "view" => VIEW_DIR."forum/listMessages.php",
            "meta_description" => "Liste des messages par sujet : ".$sujet,
            "data" => [
                "sujet" => $sujet,     //on reprend juste les entités dont on a besoin
                "messages" =>$messages // 1 sujet(singulier) et des messages(pluriel)
            ]
        ];
     
    }
    
   //Ajouter un sujet
    public function addNewSujet($id) {// correspond à l'id categorie

        $sujetManager = new SujetManager();
        $messageManager = new MessageManager();
        
        if(isset($_POST["submit"])) {//Toujours faire cette méthode if pour vérifier que ça fonctionne
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($titre && $texte) {
                
                $sujet_id = $sujetManager->add([//on ne rajoute pas la date de création car c'est un current_times
                    "titre" => $titre,
                    "categorie_id" => $id,
                    //ON AJOUTE EGALEMENT L UTILISATEUR QUI CREE LE SUJET
                    "utilisateur_id" => Session::getUtilisateur()->getId(),//ça reprend le fichier session/ on écrit Session :: car ça reprend la session "static" utilisateur
                ]);
            
                $messageManager->add([
                    "texte" => $texte,
                    "utilisateur_id" => Session::getUtilisateur()->getId(),//on récupère l'Id de l'utilisateur
                    "sujet_id" => $sujet_id,
                ]);
            }
            $this->redirectTo("forum", "listSujetsByCategorie", $id);
            
        }
    
       $this->redirectTo("forum", "listSujetsByCategorie", $id);

    }

    //Ajouter un message
    public function addNewMessage($id){

        $messageManager = new MessageManager();
        $sujetManager = new SujetManager();
        
    if (isset($_POST["submitMessage"])) {
        $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $messageManager->add([
            "texte" => $texte,
            "utilisateur_id" => Session::getUtilisateur()->getId(),//on récupère l'Id de l'utilisateur
            "sujet_id" => $id,
        ]);
        }

        $this->redirectTo("forum", "MessagesBySujet", $id);

    }

    //Supprimer un message
     public function supprimerMessage($id){

        $messageManager = new messageManager();
        $message = $messageManager->findOneById($id);

        // si l'utilisateur est connecté
        if(Session::getUtilisateur()) {
            // si l'id de l'utilisateur du message = id de l'utilisateur connecté 
            if(Session::getUtilisateur()->getId() == $message->getUtilisateur()->getId()) {
                $messageManager->deleteMessage($id);//on récupére la fonction 
                $this->redirectTo("forum", "MessagesBySujet&id", $message->getSujet()->getId());
            }  
            return [
                "view" => VIEW_DIR."forum/MessagesBySujet&id.php", 
                "data" => [
                    "sujets" => $messageManager->findOneById($id)
                ]
            ];
    
        }
    }

    //Verrouiller un sujet
    public function verrouillerSujet ($id){
        
        $sujetManager = new SujetManager();
        $sujet = $sujetManager->findOneById($id);

        // si l'utilisateur est connecté
        if(Session::getUtilisateur()) {
            // si l'id de l'utilisateur du sujet = id de l'utilisateur connecté 
            if(Session::getUtilisateur()->getId() == $sujet->getUtilisateur()->getId()) {
                $sujetManager->lockSujet($id);//on récupére la fonction lockSujet de SujetManager 
                $this->redirectTo("forum", "listSujetsByCategorie", $sujet->getCategorie()->getId());//on récupère l'id de la catégorie du sujet
            }
        }
         else {
            echo "Erreur lors du verrouillage du sujet";
        }
        
        return [
            "view" => VIEW_DIR."forum/listSujetsByCategorie.php", 
            "data" => [
                "sujets" => $sujetManager->findOneById($id)
            ]
        ];
    }
    
    //Déverrouiller un sujet
    public function deverrouillerSujet ($id){
        
        $sujetManager = new SujetManager();
        $sujet = $sujetManager->findOneById($id);

        // si l'utilisateur est connecté
        if(Session::getUtilisateur()) {
            // si l'id de l'utilisateur du sujet = id de l'utilisateur connecté 
            if(Session::getUtilisateur()->getId() == $sujet->getUtilisateur()->getId()) {
                $sujetManager->unlockSujet($id);
                $this->redirectTo("forum", "listSujetsByCategorie", $sujet->getCategorie()->getId());
            }
        }
         else {
            echo "Erreur lors du déverrouillage du sujet";
        }
        
        return [
            "view" => VIEW_DIR."forum/listSujetsByCategorie.php", 
            "data" => [
                "sujets" => $sujetManager->findOneById($id)
            ]
        ];
    }
}




    

    
    
    
        


            


