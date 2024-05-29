<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategorieManager;
use Model\Managers\SujetManager;
use Model\Managers\MessageManager;//rajout du Manager pour pouvoir afficher les messages

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

    public function listSujetsByCategorie($id) {

        $sujetManager = new SujetManager();
        $categorieManager = new CategorieManager();
        $categorie = $categorieManager->findOneById($id);
        $sujets = $sujetManager->findTopicsByCategorie($id);

        return [
            "view" => VIEW_DIR."forum/listSujets.php",
            "meta_description" => "Liste des topics par catégorie : ".$categorie,
            "data" => [
                "categorie" => $categorie,
                "sujets" => $sujets
            ]
        ];
    }

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

    public function addNewMessage($id) {
        $messageManager = new MessageManager();
        
        if(Session::getUser()) {
            if(isset($_POST['submit'])) {
                $texte = filter_input(INPUT_POST, 'new_message',  FILTER_SANITIZE_SPECIAL_CHARS);
                
                if(!empty($texte)) {
                    $data = [
                        'texte' => $texte,
                        'utilisateur_id' => Session::getUser()->getId(), 
                        'sujet_id' => $id
                    ];
                    
                    $messageManager->add($data);
                    Session::addFlash("success", "Message ajouté avec succès");
                } else {
                    Session::addFlash("error", "Le texte du message ne peut pas être vide");
                }
            } else {
                Session::addFlash("error", "Erreur lors de l'ajout du message");
            }
        
            $this->redirectTo("forum", "MessagesBySujet", $id);
        } else {
            // Gérer le cas où aucun utilisateur n'est connecté
            Session::addFlash("error", "Vous devez être connecté pour ajouter un message");
            $this->redirectTo("auth", "login");
        }
    }
}    
