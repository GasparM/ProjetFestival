<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controleur;

use modele\dao\Bdd;
use modele\dao\GroupeDAO;
use modele\metier\Groupe;
use vue\groupe\VueListeGroupes;
use vue\groupe\VueDetailGroupes;
use vue\groupe\VueSaisieGroupes;
use vue\groupe\VueSupprimerGroupes;

/**
 * Description of CtrlGroupe
 *
 * @author btssio
 */
class CtrlGroupes extends ControleurGenerique{
    
    /** controleur= groupe & action= defaut
     * Afficher la liste des groupes     */
    public function defaut() {
        $this->liste();
    }
    
    /** controleur = groupe & action = liste
     * Afficher la liste des groupes    */
    public function liste(){
        $laVue = new VueListeGroupes();
        $this->vue = $laVue;
        // On récupère un tableau composé d'objets de type Groupe lus dans la BDD
        Bdd::connecter();
        $laVue->setLesGroupesAvecNbAttributions($this->getTabGroupesAvecNbAttributions());
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - Groupe");
        $this->vue->afficher();
    }
    
    /** controleur= groupe & action=detail & id=identifiant_groupe
     * Afficher un groupe d'après son identifiant     */
    public function detail() {
        $idGroupe = $_GET["id"];
        $this->vue = new VueDetailGroupes();    
        // Lire dans la BDD les données du groupe à afficher
        Bdd::connecter();
        $this->vue->setUnGroupe(GroupeDAO::getOneById($idGroupe));
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - Groupe");
        $this->vue->afficher();
    }
    
    /** controleur= groupe & action=creer
     * Afficher le formulaire d'ajout d'un groupe  */
    public function creer() {
        $laVue = new VueSaisieGroupes();
        $this->vue = $laVue;
        $laVue->setActionRecue("creer");
        $laVue->setActionAEnvoyer("validerCreer");
        $laVue->setMessage("Nouveau groupe");
        // En création, on affiche un formulaire vide
        $unGroupe = new Groupe("", "", "", "", "", "", "");
        $laVue->setUnGroupe($unGroupe);
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - Groupe");
        $this->vue->afficher();
    }


    public function validerCreer() {
        Bdd::connecter();
        /* @var Groupe unGroupe  : récupération du contenu du formulaire et instanciation d'un groupe */
        $unGroupe = new Groupe($_REQUEST['id'], $_REQUEST['nom'], $_REQUEST['identite'], $_REQUEST['adresse'], $_REQUEST['nbPers'], $_REQUEST['nomPays'], $_REQUEST['hebergement']);
        // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        
        // pour un formulaire de création (paramètre n°1 = true)
        $this->verifierDonneesGroupe($unGroupe, true);
        if (GestionErreurs::nbErreurs() == 0) {
            
            // s'il ny a pas d'erreurs,
            // enregistrer le groupe
            GroupeDAO::insert($unGroupe);
            // revenir à la liste des groupes
            header("Location: index.php?controleur=groupes&action=liste");
        } else {
            // s'il y a des erreurs, 
            // réafficher le formulaire de création
            $laVue = new VueSaisieGroupes();
            $this->vue = $laVue;
            $laVue->setActionRecue("creer");
            $laVue->setActionAEnvoyer("validerCreer");
            $laVue->setMessage("Nouveau groupe");
            $laVue->setUnGroupe($unGroupe);
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - groupes");
            $this->vue->afficher();
        }
    }

    /** controleur= groupe & action=modifier $ id=identifiant du groupe à modifier
     * Afficher le formulaire de modification d'un groupe    */
    public function modifier() {
        $idGroupe = $_GET["id"];
        $laVue = new VueSaisieGroupes();
        $this->vue = $laVue;
        // Lire dans la BDD les données du Groupe à modifier
        Bdd::connecter();
        /* @var Groupe $leGroupe*/
        $leGroupe = GroupeDAO::getOneById($idGroupe);
        $this->vue->setUnGroupe($leGroupe);
        $laVue->setActionRecue("modifier");
        $laVue->setActionAEnvoyer("validerModifier");
        $laVue->setMessage("Modifier le groupe : " . $leGroupe->getNom() . " (" . $leGroupe->getId() . ")");
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - groupes");
        $this->vue->afficher();
    }

    /** controleur= groupe & action=validerModifier
     * modifier un groupe dans la base de données d'après la saisie    */
    public function validerModifier() {
        Bdd::connecter();
        /* @var Groupe $unGroupe  : récupération du contenu du formulaire et instanciation d'un groupe */
        $unGroupe = new Groupe($_REQUEST['id'], $_REQUEST['nom'], $_REQUEST['identite'], $_REQUEST['adresse'], $_REQUEST['nbPers'], $_REQUEST['nomPays'], $_REQUEST['hebergement']);
        // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        // pour un formulaire de modification (paramètre n°1 = false)
        $this->verifierDonneesGroupe($unGroupe, false);
        if (GestionErreurs::nbErreurs() == 0) {
            // s'il ny a pas d'erreurs,
            // enregistrer les modifications pour le groupe
            GroupeDAO::update($unGroupe->getId(), $unGroupe);
            // revenir à la liste des établissements
            header("Location: index.php?controleur=groupes&action=liste");
        } else {
            // s'il y a des erreurs, 
            // réafficher le formulaire de modification
            $laVue = new VueSaisieGroupes();
            $this->vue = $laVue;
            $laVue->setUnGroupe($unGroupe);
            $laVue->setActionRecue("modifier");
            $laVue->setActionAEnvoyer("validerModifier");
            $laVue->setMessage("Modifier le groupe : " . $unGroupe->getNom() . " (" . $unGroupe->getId() . ")");
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - groupes");
            $this->vue->afficher();
        }
    }
    
      /** controleur= groupes & action=supprimer & id=identifiant_groupe
     * Supprimer un groupe d'après son identifiant     */
    public function supprimer() {
        $idGroupe = $_GET["id"];
        $this->vue = new \vue\groupe\VueSupprimerGroupes();
        // Lire dans la BDD les données du groupe à supprimer
        Bdd::connecter();
        $this->vue->setUnGroupe(GroupeDAO::getOneById($idGroupe));
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - Groupe");
        $this->vue->afficher();
    }

    /** controleur= groupe & action= validerSupprimer
     * supprimer un groupe dans la base de données après confirmation   */
    public function validerSupprimer() {
        Bdd::connecter();
        if (!isset($_GET["id"])) {
            // pas d'identifiant fourni
            GestionErreurs::ajouter("Il manque l'identifiant de l'établissement à supprimer");
        } else {
            // suppression du groupe d'après son identifiant
            GroupeDAO::delete($_GET["id"]);
        }
        // retour à la liste des groupes
        header("Location: index.php?controleur=groupes&action=liste");
    }
    
    /**
     * Vérification des données du formulaire de saisie
     * @param Groupe $unGroupe groupe à vérifier
     * @param bool $creation : =true si formulaire de création d'un nouvel groupe ; =false sinon
     */
    private function verifierDonneesGroupe(Groupe $unGroupe, bool $creation) {
        // Vérification des champs obligatoires.
        // Dans le cas d'une création, on vérifie aussi l'id
        if (($creation && $unGroupe->getId() == "") || $unGroupe->getNom() == "" || $unGroupe->getIdentite()=="" 
            || $unGroupe->getHebergement()=="" || $unGroupe->getNbPers() =="" || $unGroupe->getNomPays()==""){
            GestionErreurs::ajouter('Chaque champ suivi du caractère * est obligatoire');
        }
        // En cas de création, vérification du format de l'id et de sa non existence
        if ($creation && $unGroupe->getId() != "") {
            // Si l'id est constitué d'autres caractères que de lettres non accentuées 
            // et de chiffres, une erreur est générée
            if (!estAlphaNumerique($unGroupe->getId())) {
                GestionErreurs::ajouter("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
            } else {
                if (GroupeDAO::isAnExistingId($unGroupe->getId())){
                    GestionErreurs::ajouter("Le groupe " . $unGroupe->getId() . " existe déjà");
                }
            }
        }
        // Vérification qu'un groupe de même nom n'existe pas déjà (id + nom si création)
        if ($unGroupe->getNom() != "" && GroupeDAO::isAnExistingName($creation, $unGroupe->getId(), $unGroupe->getNom())) {
            GestionErreurs::ajouter("Le groupe  " . $unGroupe->getNom() . " existe déjà");
        }
    }

    /*****************************************************************************
     * Méthodes permettant de préparer les informations à destination des vues
     ******************************************************************************/

    /**
     * Retourne la liste de tous les Groupe et du nombre d'attributions de chacun
     * @return Array tableau associatif à 2 dimensions : 
     *      - dimension 1, l'index est l'id de l'établissement
     *      - dimension 2, index "groupe" => objet de type Groupe
     *      - dimension 2, index "nbAttrib" => nombre d'attributions pour ce groupe
     */
    public function getTabGroupesAvecNbAttributions(): Array {
        $lesGroupesAvecNbAttrib = Array();
        $lesGroupes = GroupeDAO::getAll();
        foreach ($lesGroupes as $unGroupe) {
            /* @var Groupe $unGroup */
            $lesGroupesAvecNbAttrib[$unGroupe->getId()]['groupe'] = $unGroupe;
        }
        return $lesGroupesAvecNbAttrib;
    }
}
