<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre,
    c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. 
    En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Categorie extends Entity{

    private $id;
    private $categorie;

    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
    public function __construct($data){         
        $this->hydrate($data);        
    }

    // GET ET SET DE L'ID
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    // GET ET SET DE LA CATEGORIE
    public function getCategorie()
        {
            return $this->categorie;
        }
    public function setCategorie($categorie)
        {
            $this->categorie = $categorie;
            
            return $this;
        }
        
    // METHODE TO__STRING POUR L'AFFICHAGE
        public function __toString()
        {
            return $this->categorie;
        }

}