<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;
use Model\Managers\SujetManager;

class UtilisateurManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Utilisateur";
    protected $tableName = "utilisateur";

    public function __construct(){
        parent::connect();
    }

    public function checkUserExists($email) {//Requ^te qui permet de vérifier si l'utilisateur existe via son mail
        $sql ="SELECT * 
                FROM ".$this->tableName. " t
                WHERE email = :email";

        // la requête renvoie un objet ou rien --> getOneOrNullResult (cf fonctions dans Manager)
        return  $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false), //on rajoute "false" car la  public static function select dans DAO renvoie des réponses multiples "true"
            $this->className
        );
    }

}