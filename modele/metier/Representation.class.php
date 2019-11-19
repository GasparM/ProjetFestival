<?php
namespace modele\metier;

/**
 * Description d'une offre d'hébergement
 * 
 * @author prof
 */
class Representation {
    
    /**
     * id de la représentation
     * @var int
     */
    private $id;
    
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
     * @var date
     */
    private $date;
    
    /**
     * heure du début de la représentation
     * @var string
     */
    private $heureDebut;
    
    /**
     * heure de fin de la représentation 
     * @var string 
     */
    private $heureFin;

    
    function __construct($id, Lieu $lieu, Groupe $groupe, $date, $heureDebut, $heureFin) {
        $this->id=$id;
        $this->lieu = $lieu;
        $this->groupe = $groupe;
        $this->date = $date;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
    }

    function getId(){
        return $this->id;
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

    function getHeureFin(): String {
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

    function setId($id) {
        $this->id = $id;
    }

    function setHeureDebut($heureDebut) {
        $this->heureDebut = $heureDebut;
    }

    function setHeureFin($heureFin) {
        $this->heureFin = $heureFin;
    }
    
}
