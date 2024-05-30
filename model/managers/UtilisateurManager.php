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
}