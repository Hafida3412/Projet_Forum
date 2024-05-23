<?php
namespace Model\Entities;

use App\Entity;

final class Message extends Entity{

    private $id;
    private $texte;
    private $utilisateur;
    private $sujet;
    private $dateCreationMessage;

    public function __construct($data){         
        $this->hydrate($data);   

}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTexte()
    {
        return $this->texte;
    }

    public function setTexte($texte)
    {
        $this->texte = $texte;

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

    public function getSujet()
    {
        return $this->sujet;
    }
 
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getDateCreationMessage()
    {
        return $this->dateCreationMessage;
    }


    public function setDateCreationMessage($dateCreationMessage)
    {
        $this->dateCreationMessage = $dateCreationMessage;

        return $this;
    }
}