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
use modele\metier\Representation;
use modele\metier\Lieu;
use modele\metier\Groupe;
use vue\representation\VueConsultationRepresentation;
use vue\representation\VueSaisieRepresentation;
use vue\representation\VueSupprimerRepresentation;
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
        Bdd::connecter();
        $laVue->setLesRepresentations(RepresentationDAO::getAll());
        $laVue->setLesDates(RepresentationDAO::getDate());
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - representations");
        $this->vue->afficher();
    }
    
    /** controleur= representation & action=creer
     * Afficher le formulaire d'ajout d'une représentation  */  
    public function creer() {
        $laVue = new VueSaisieRepresentation();
        $this->vue = $laVue;
        $laVue->setActionRecue("creer");
        $laVue->setActionAEnvoyer("validerCreer");
        $laVue->setMessage("Nouvelle Représentation");
        // En création, on affiche un formulaire vide
        /* @var Lieu $unLieu */
        $unLieu = new Lieu(0,"","","");                                     
        /* @var Groupe $unGroupe */
        $unGroupe = new Groupe("","","","","","","");
        /* @var Representation $uneRepre */
        $uneRepre = new Representation("", $unLieu, $unGroupe, "", "", "");
        Bdd::connecter();
        $lesLieux = LieuDAO::getAll();                                          // récupération de tout les lieux pour faire le select
        $lesGroupes = GroupeDAO::getAll();                                      // récupération de tout les groupe pour faire le select
        $this->vue->setUneRepresentation($uneRepre);
        $this->vue->setLesLieux($lesLieux);
        $this->vue->setLesGroupes($lesGroupes); 
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - représentation");
        $this->vue->afficher();
    }

    /** controleur= representation & action=validerCreer
     * ajouter d'une représentation dans la base de données d'après la saisie    */
    public function validerCreer() {
        Bdd::connecter();
        /* @var Lieu $unLieu */
        $unLieu=LieuDAO::getOneById($_REQUEST['lieu']);
        /* @var Groupe $unGroupe */
        $unGroupe=GroupeDAO::getOneById($_REQUEST['groupe']);
        /* @var Representation $uneRepresentation  : récupération du contenu du formulaire et instanciation d'une representation */
        $uneRepresentation = new Representation($_REQUEST['id'],$unLieu, $unGroupe,  $_REQUEST['date'], $_REQUEST['heure_Debut'], $_REQUEST['heure_Fin']);     
        // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        // pour un formulaire de modification (paramètre n°1 = false)
        $this->verifierDonneesRepresentation($uneRepresentation, false);
        if (GestionErreurs::nbErreurs() == 0) {
            // s'il ny a pas d'erreurs,
            // enregistrer la représentation
            RepresentationDAO::insert($uneRepresentation);
            // revenir à la liste des représentation
            header("Location: index.php?controleur=representation&action=consulter");
        } else {
            // s'il y a des erreurs, 
            // réafficher le formulaire de modification
            $laVue = new VueSaisieRepresentation();
            $this->vue = $laVue;
            $laVue->setActionRecue("creer");
            $laVue->setActionAEnvoyer("validerCreer");
            $laVue->setMessage("Nouvelle Représentation");
            $lesLieux = LieuDAO::getAll();                                          // récupération de tout les lieux pour faire le select
            $lesGroupes = GroupeDAO::getAll();                                      // récupération de tout les groupe pour faire le select
            $this->vue->setUneRepresentation($uneRepresentation);
            $this->vue->setLesLieux($lesLieux);
            $this->vue->setLesGroupes($lesGroupes);
            $laVue->setMessage("Modifier la representation : " . $uneRepresentation->getId());
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - representations");
            $this->vue->afficher();
        }
    }
    
    
    /*controleur= representation & action= modifier & id = identifiant de la representation visé
     * Modifier les représentations  */
    function modifier() {
        $laVue = new VueSaisieRepresentation();
        $this->vue = $laVue;
        // Lecture de l'id de la representation
        $idRep = $_GET['id'];    
        Bdd::connecter();
        $uneRepresentation = RepresentationDAO::getOneById($idRep);
        $lesLieux = LieuDAO::getAll();                                          // récupération de tout les lieux pour faire le select
        $lesGroupes = GroupeDAO::getAll();                                      // récupération de tout les groupes pour faire le select
        $this->vue->setUneRepresentation($uneRepresentation);
        $this->vue->setLesLieux($lesLieux);
        $this->vue->setLesGroupes($lesGroupes);    
        $laVue->setActionRecue("modifier");
        $laVue->setActionAEnvoyer("validerModifier");
        $laVue->setMessage("Modifier la representation : " . $uneRepresentation->getId());
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - representations");
        $this->vue->afficher();
    }
    
    /** controleur= representation & action=validerModifier
     * modifier une representation dans la base de données d'après la saisie    */
    public function validerModifier() {
        Bdd::connecter();
        /* @var Lieu $unLieu */
        $unLieu=LieuDAO::getOneById($_REQUEST['lieu']);
        /* @var Groupe $unGroupe */
        $unGroupe=GroupeDAO::getOneById($_REQUEST['groupe']);
        /* @var Representation $uneRepresentation  : récupération du contenu du formulaire et instanciation d'une representation */
        $uneRepresentation = new Representation($_REQUEST['id'],$unLieu, $unGroupe,  $_REQUEST['date'], $_REQUEST['heure_Debut'], $_REQUEST['heure_Fin']);     
        // // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        // pour un formulaire de modification (paramètre n°1 = false)
        $this->verifierDonneesRepresentation($uneRepresentation, false);
        if (GestionErreurs::nbErreurs() == 0) {
            // s'il ny a pas d'erreurs,
            // enregistrer les modifications pour la representation
            RepresentationDAO::update($uneRepresentation->getId(), $uneRepresentation);
            // revenir à la liste des représentations
            header("Location: index.php?controleur=representation&action=consulter");
        } else {
            // s'il y a des erreurs, 
            // réafficher le formulaire de modification
            $laVue = new VueSaisieRepresentation();
            $this->vue = $laVue;
            $lesLieux = LieuDAO::getAll();                                          // récupération de tout les lieux pour faire le select
            $lesGroupes = GroupeDAO::getAll();                                      // récupération de tout les groupe pour faire le select
            $this->vue->setUneRepresentation($uneRepresentation);
            $this->vue->setLesLieux($lesLieux);
            $this->vue->setLesGroupes($lesGroupes); 
            $laVue->setActionRecue("modifier");
            $laVue->setActionAEnvoyer("validerModifier");
            $laVue->setMessage("Modifier la representation : " . $uneRepresentation->getId());
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - representations");
            $this->vue->afficher();
        }
    }
    
    /** controleur= representation & action=supprimer & id=identifiant_representation
     * Supprimer une representation d'après son identifiant     */
    public function supprimer() {
        $idRep = $_GET["id"];
        $this->vue = new VueSupprimerRepresentation();
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
    
    /**
     * Vérification des données du formulaire de saisie
     * @param Représentation $uneRepre représentation vérifier
     * @param bool $creation : =true si formulaire de création d'une nouvelle représentation ; =false sinon
     */
    private function verifierDonneesRepresentation(Representation $uneRepre, bool $creation) {
        // Vérification des champs obligatoires.
        // Dans le cas d'une création, on vérifie aussi l'id
        if ($creation && $uneRepre->getId() == "" || $uneRepre->getHeureDebut() == "" || $uneRepre->getHeureFin() == "" || $uneRepre->getDate()=="") {
            GestionErreurs::ajouter('Chaque champ suivi du caractère * est obligatoire');
        }
        // En cas de création, vérification du format de l'id et de sa non existence
        if ($creation && $uneRepre->getId() != "") {
            // Si l'id est constitué d'autres caractères que de lettres non accentuées 
            // et de chiffres, une erreur est générée
            if (!estAlphaNumerique($uneRepre->getId())) {
                GestionErreurs::ajouter("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
            } else {
                if (RepresentationDAO::isAnExistingId($uneRepre->getId())) {
                    GestionErreurs::ajouter("La représentation " . $uneRepre->getId() . " existe déjà");
                }
            }
        }
    }

}


