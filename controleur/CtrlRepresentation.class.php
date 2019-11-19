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
}


