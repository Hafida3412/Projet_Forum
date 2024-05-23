<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Sujet extends Entity{

    private $id;
    private $titre;
    private $utilisateur;
    private $categorie;
    private $dateCreationSujet;
    private $verrouillage;


    public function __construct($data){         
        $this->hydrate($data);        
    }

   
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
        
        return $this;
    }
    
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
    
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;
        
        return $this;
    }
    
    public function getCategorie()
    {
        return $this->categorie;
    }
    
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        
        return $this;
    }
        
    public function getDateCreationSujet()
    {
        return $this->dateCreationSujet;
    }
    
        public function setDateCreationSujet($dateCreationSujet)
    {
        $this->dateCreationSujet = $dateCreationSujet;
        
        return $this;
    }
    
    public function getVerrouillage()
    {
        return $this->verrouillage;
    }
        
    public function setVerrouillage($verrouillage)
    {
        $this->verrouillage = $verrouillage;
        
        return $this;
    }
    
    public function __toString(){
        return $this->titre;
    }
}