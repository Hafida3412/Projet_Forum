<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategorieManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Categorie";
    protected $tableName = "categorie";

    public function __construct(){
        parent::connect();
    }
}
