<?php

/**
 * Contrôleur de gestion des representations
 * @author groupe 7
 * @version 2019
 */

namespace controleur;

use modele\dao\GroupeDAO;
use modele\dao\LieuDAO;
use modele\dao\RepresentationDAO;
use modele\dao\Bdd;
use vue\representation\VueConsultationRepresentation;
//use vue\offres\VueSaisieOffres;

class CtrlRepresentation extends ControleurGenerique {
    
    /** controleur= representation & action= defaut
     * Afficher la liste des representation      */
    public function defaut() {
        $this->consulter();
    }

    /** controleur= representation & action= consulter
     * Afficher la liste des representations      */
    function consulter() {
        $laVue = new VueConsultationRepresentation();
        $this->vue = $laVue;
        // La vue a besoin de la liste des groupes et de celle des lieux
        Bdd::connecter();
        $laVue->setLesRepresentations(RepresentationDAO::getAll());
        //$laVue->setTabRepresentation($this->getTabRepresentationParGroupeParLieu());
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - representations");
        $this->vue->afficher();
    }
    
        /*controleur= representation & action= modifier & id = identifiant de la representation visé
     * Modifier les offres d'hébergement proposées par un établissement  */
    function modifier() {
        $laVue = new VueSaisieRepresentation();
        $this->vue = $laVue;
        // Lecture de l'id de la representation
        $idRep = $_GET['id'];    
        Bdd::connecter();
        $laRepresentation = RepresentationDAO::getOneById($idRep);
        $this->vue->setUneRepresenation($laRepresentation);
        $laVue->setActionRecue("modifier");
        $laVue->setActionAEnvoyer("validerModifier");
        $laVue->setMessage("Modifier la representation : " . $laRepresentation->getId());
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - representations");
        $this->vue->afficher();
    }
    /** controleur= representation & action=validerModifier
     * modifier une representation dans la base de données d'après la saisie    */
    public function validerModifier() {
        Bdd::connecter();
        /* @var Representation $uneRepresentation  : récupération du contenu du formulaire et instanciation d'une representation */
        $uneRepresentation = new Representation($_REQUEST['id'], $_REQUEST['lieu'], $_REQUEST['groupe'], $_REQUEST['date'], $_REQUEST['heureDebut'], $_REQUEST['heureFin']);
        // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        // pour un formulaire de modification (paramètre n°1 = false)
        $this->verifierDonneesRepresentation($uneRepresentation, false);
        if (GestionErreurs::nbErreurs() == 0) {
            // s'il ny a pas d'erreurs,
            // enregistrer les modifications pour la representation
            RepresentationDAO::update($uneRepresentation->getId(), $uneRepresentation);
            // revenir à la liste des representations
            header("Location: index.php?controleur=representation");
        } else {
            // s'il y a des erreurs, 
            // réafficher le formulaire de modification
            $laVue = new VueSaisieRepresentation();
            $this->vue = $laVue;
            $laVue->setUneRepresentation($uneRepresentation);
            $laVue->setActionRecue("modifier");
            $laVue->setActionAEnvoyer("validerModifier");
            $laVue->setMessage("Modifier la representation : " . $laRepresentation->getId());
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - representations");
            $this->vue->afficher();
        }
    }
    
      /** controleur= representation & action=supprimer & id=identifiant_representation
     * Supprimer une representation d'après son identifiant     */
    public function supprimer() {
        $idRep = $_GET["id"];
        $this->vue = new \vue\groupe\VueSupprimerRepresentation();
        // Lire dans la BDD les données de la representation à supprimer
        Bdd::connecter();
        $this->vue->setUneRepresentation(RepresentationDAO::getOneById($idRep));
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - representations");
        $this->vue->afficher();
    }

    /** controleur= representation & action= validerSupprimer
     * supprimer une representation dans la base de données après confirmation   */
    public function validerSupprimer() {
        Bdd::connecter();
        if (!isset($_GET["id"])) {
            // pas d'identifiant fourni
            GestionErreurs::ajouter("Il manque l'identifiant de la representation à supprimer");
        } else {
            // suppression de la representation d'après son identifiant
            RepresentationDAO::delete($_GET["id"]);
        }
        // retour à la liste des representations
        header("Location: index.php?controleur=representation");
    }

    public static function getTabRepresentationParGroupeParLieu(): Array {
        $tabRepresentation = Array();
        $lesGroupes = GroupeDAO::getAll();
        $lesLieux = LieuDAO::getAll();
        foreach ($lesGroupes as $unGroupe) {
            foreach ($lesLieux as $unLieu) {
                $representation = RepresentationDAO::getOneById($unGroupe->getId(), $unLieu->getLieu_Id());
                if (is_null($representation)) {
                    $nbRepresentation = 0;
                } else {
                    $nbRepresentation = $representation->getGroupe();
                }
                $tabRepresentation[$unGroupe->getId()][$unLieu->getLieu_Id()] = $nbRepresentation;
            }
        }
        return $tabRepresentation;
    }

}


