<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class MessageManager extends Manager{
    protected $className = "Model\Entities\Message";
    protected $tableName = "message";

    public function __construct(){
        parent::connect();
    }
    
    //Requête pour récupérer tous les sujets
    public function findMessagesBySujet($id) {

        $sql ="SELECT * 
                FROM ".$this->tableName. " t
                WHERE sujet_id = :id ORDER BY t.dateCreationMessage ASC";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }
        
    //Requête pour supprimer un message
    public function deleteMessage($id) {
        $sql ="DELETE
                FROM ".$this->tableName. " t
                WHERE id_message = :id";
    //la requête renvoie un seul ou aucun résultat
        return  $this->getOneOrNullResult(
            DAO::delete($sql, ['id' => $id]), //on précise "delete"
            $this->className
        );
    }

}