<?php
namespace modele\metier;

/**
 * Description d'une offre d'hébergement
 * 
 * @author prof
 */
class Representation {
    
    /** 
     * lieu concerné par la représentation
     * @var modele\metier\Lieu
     */
    private $lieu;
    
    /** 
     * groupe concerné par la représentation
     * @var modele\metier\Groupe
     */
    private $groupe;
    
    /**
     * date de la représentation
     * @var 
     */
    private $date;
    
    /**
     * heure du début de la représentation
     * @var float
     */
    private $heureDebut;
    
    /**
     * heure de fin de la représentation 
     * @var type 
     */
    private $heureFin;

    
    function __construct(Lieu $lieu, Groupe $groupe, $date, $heureDebut, type $heureFin) {
        $this->lieu = $lieu;
        $this->groupe = $groupe;
        $this->date = $date;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
    }

    function getLieu(): Lieu {
        return $this->lieu;
    }

    function getGroupe(): Groupe {
        return $this->groupe;
    }

    function getDate() {
        return $this->date;
    }

    function getHeureDebut() {
        return $this->heureDebut;
    }

    function getHeureFin(): type {
        return $this->heureFin;
    }

    function setLieu(Lieu $lieu) {
        $this->lieu = $lieu;
    }

    function setGroupe(Groupe $groupe) {
        $this->groupe = $groupe;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setHeureDebut($heureDebut) {
        $this->heureDebut = $heureDebut;
    }

    function setHeureFin(type $heureFin) {
        $this->heureFin = $heureFin;
    }
    
}
