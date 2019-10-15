<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modele\metier;

/**
 * Description of Lieu
 *
 * @author btssio
 */
class Lieu {
    /**
     * identifiant du lieu
     * @var int
     */
    private $lieu_id;
    /**
     * nom du lieu
     * @var string
     */
    private $nom;
    /**
     * adresse du lieu
     * @var string 
     */
    private $adresse;
    /**
     * capacité du lieu
     * @var string
     */
    private $capaciteAccueil;
    
    function __construct($lieu_id, $nom, $adresse, $capaciteAccueil) {
        $this->lieu_id = $lieu_id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->capaciteAccueil = $capaciteAccueil;
    }
    //guetteur
    function getLieu_id() {
        return $this->lieu_id;
    }

    function getNom() {
        return $this->nom;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getCapaciteAccueil() {
        return $this->capaciteAccueil;
    }
    
    //setteurs
    function setLieu_id($lieu_id) {
        $this->lieu_id = $lieu_id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setCapaciteAccueil($capaciteAccueil) {
        $this->capaciteAccueil = $capaciteAccueil;
    }


}
