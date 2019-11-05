<?php
namespace modele\dao;

use modele\metier\Lieu;
use PDOStatement;
use PDO;

/**
 * Description of GroupeDAO
 * Classe métier :  Groupe
 * @author prof
 * @version 2017
 */
class LieuDAO {


    /**
     * Instancier un objet de la classe Lieu à partir d'un enregistrement de la table Lieu
     * @param array $enreg
     * @return Lieu
     */
    protected static function enregVersMetier(array $enreg) {
        $id = $enreg['LIEU_ID'];
        $nom = $enreg['NOM'];
        $adresse = $enreg['ADRESSE'];
        $capaMax = $enreg['CAPACITEACCUEIL'];
        $unLieu = new Groupe($id, $nom, $adresse, $capaMax);

        return $unLieu;
    }

    /**
     * Retourne la liste de tous les Lieux
     * @return array tableau d'objets de type Lieu
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Lieu";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau groupe au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Recherche un lieu selon la valeur de son id
     * @param string $id
     * @return Lieu le lieu trouvé ; null sinon
     */
    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Lieu WHERE LIEU_ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

}
