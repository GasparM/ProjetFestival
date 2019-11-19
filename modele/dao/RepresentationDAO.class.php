<?php

namespace modele\dao;

use modele\metier\Representation;
use modele\metier\Lieu;
use modele\metier\Groupe;
use PDOStatement;
use PDO;

class RepresentationDAO {

    /**
     * crée un objet métier à partir d'un enregistrement de la table Representation et des tables liées
     * @param array $enreg Description
     * @return Representation objet métier obtenu
     */
    protected static function enregVersMetier($enreg) {
        $id = $enreg['ID'];
        $idGroupe = $enreg['ID_GROUPE'];
        $idLieu = $enreg['ID_LIEU'];
        $date= $enreg['DATE'];
        $heureDebut = $enreg["HEURE_DEBUT"];
        $heureFin = $enreg["HEURE_FIN"];
        // construire les objets Etablissement et TypeChambre à partir de leur identifiant       
        $objetGroupe = GroupeDAO::getOneById($idGroupe);
        $objetLieu = LieuDAO::getOneById($idLieu);
        // instancier l'objet Offre
        $objetMetier = new Representation($id, $objetLieu, $objetGroupe, $date, $heureDebut, $heureFin);

        return $objetMetier;
    }

    /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param Representation $objetMetier
     * @param PDOStatement $stmt
     */
    protected static function metierVersEnreg(Representation $objetMetier, PDOStatement $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        /* @var $groupe Groupe */
        $groupe = $objetMetier->getGroupe();
        /* @var $lieu Lieu */
        $lieu = $objetMetier->getLieu();
        $stmt->bindValue(':id', $objetMetier->getId());
        $stmt->bindValue(':id_groupe', $groupe->getId());
        $stmt->bindValue(':id_lieu', $lieu->getLieu_id());
        $stmt->bindValue(':date', $objetMetier->getDate());
        $stmt->bindValue(':heureDebut', $objetMetier->getHeureDebut());
        $stmt->bindValue(':heureFin', $objetMetier->getHeureFin());
    }

    /**
     * Retourne la liste de toutes les représentation
     * @return array tableau d'objets de type Representation
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Representation ORDER BY DATE";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Construire un objet d'après son identifiant, à partir des des enregistrements de la table Representation
     * @param string $id identifiant de la Reprensentation
     * @return Representation : objet métier si trouvé dans la BDD, null sinon
     */
    public static function getOneById($idRepre) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Representation WHERE ID = :idRepre ";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idRepre', $idRepre);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }

        return $objetConstruit;
    }

    /**
     * Détruire un enregistrement de la table Representation d'après son identifiant
     * @param string $id identifiant de la representation
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($idRepre) {
        $ok = false;
        $requete = "DELETE FROM Representation "
                . " WHERE ID = :idRepre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idRepre', $idRepre);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param Representation objet métier à insérer
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insert(Representation $objet) {
        $ok = false;
        $requete = "INSERT INTO Representation VALUES(:id, :date, :heureDebut, :heureFin, :id_lieu, :id_groupe)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Mise à jour de la representation
     * @param string $idEtab identifiant de l'établissement concerné par l'offre
     * @param string $idTypeCh identifiant du type de chambre concerné par l'offre
     * @param int $nb nouveau nombre de chambre 
     * @return boolean =true si la mise à jour a été correcte
     */
    public static function update($id, Representation $objet) {
        $ok = false;
        $requete = "UPDATE Representation SET DATE=:date, HEURE_DEBUT=:heureDebut,
           HEURE_FIN=:heureFin, ID_LIEU=:id_lieu, ID_GROUPE=:id_groupe WHERE ID=:id";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }
    

}
