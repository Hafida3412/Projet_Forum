<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class SujetManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Sujet";
    protected $tableName = "sujet";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategorie($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.categorie_id = :id ORDER BY t.dateCreationSujet DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

        //fonction pour verrouiller un sujet
    public function lockSujet($id){//requête SQL pour update un sujet:
        $sql = "UPDATE sujet
               SET verrouillage = '1'
               WHERE id_sujet = :id";

        return $this->getOneOrNullResult(
            DAO::update($sql, ['id' => $id]), //DAO::update et non select (cf DAO.php)        
            $this->className
        );

    }

    public function unlockSujet($id){//requête SQL pour update un sujet:
        $sql = "UPDATE sujet
               SET verrouillage = '0'
               WHERE id_sujet = :id";

        return $this->getOneOrNullResult(
            DAO::update($sql, ['id' => $id]), //DAO::update et non select (cf DAO.php)        
            $this->className
        );

    }
}