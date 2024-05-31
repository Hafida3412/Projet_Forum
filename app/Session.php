<?php
namespace App;

class Session{

    private static $categories = ['error', 'success'];

    /**
    *   ajoute un message en session, dans la catégorie $categ
    */
    public static function addFlash($categ, $msg){
        $_SESSION[$categ] = $msg;
    }

    /**
    *   renvoie un message de la catégorie $categ, s'il y en a !
    */
    public static function getFlash($categ){
        
        if(isset($_SESSION[$categ])){
            $msg = $_SESSION[$categ];  
            unset($_SESSION[$categ]);
        }
        else $msg = "";
        
        return $msg;
    }

    /**
    *   met un user dans la session (pour le maintenir connecté)
    */
    public static function setUtilisateur($utilisateur){
        $_SESSION["utilisateur"] = $utilisateur;
    }


    /**
     * La méthode suivante permet de vérifier qu'un utilisateur est bien connecté:
     */
    public static function getUtilisateur(){
        return (isset($_SESSION['utilisateur'])) ? $_SESSION['utilisateur'] : false;
    }

    public static function isAdmin(){
        // attention de bien définir la méthode "hasRole" dans l'entité User en fonction de la façon dont sont gérés les rôles en base de données
        if(self::getUtilisateur()) {//&& self::getUtilisateur()->hasRole("ROLE_ADMIN")){
            return true;
        }
        return false;
    }
}