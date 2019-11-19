<?php
/**
 * Description Page de consultation des représentation groupées par lieu et par date
 * @author groupe 7
 * @version 2019
 */

namespace vue\representation;

use vue\VueGenerique;
use modele\metier\Representation;
use modele\metier\Groupe;
use modele\metier\Lieu;

class VueConsultationRepresentation extends VueGenerique {

    /** @var array liste des groupes */
    private $lesGroupes;

    /** @var array liste des lieux */
    private $lesLieux;
    
    /** @var Array tableau associatif des représentations par groupe, par lieu */
    private $tabRepresentation;
    

    public function __construct() {
        parent::__construct();
    }

    public function afficher() {
        include $this->getEntete();

        // IL FAUT QU'IL Y AIT AU MOINS UN GROUPE ET UN LIEU POUR QUE L'AFFICHAGE SOIT EFFECTUÉ        
        if (count($this->lesGroupes) != 0 && count($this->lesLieux) != 0) {
            // POUR CHAQUE GROUPE : AFFICHAGE DU NOM ET D'UN TABLEAU COMPORTANT 1
            // LIGNE D'EN-TÊTE ET 1 LIGNE PAR LIEU
            foreach ($this->lesGroupes as $unGroupe) {
                // AFFICHAGE DU NOM DU GROUPE ET D'UN LIEN VERS LE FORMULAIRE DE MODIFICATION
                ?>
                <strong><?= $unGroupe->getNom() ?></strong><br>
                <a href="index.php?controleur=representation&action=modifier&id=<?= $unGroupe->getId() ?>">
                    Modifier
                </a>
                <table width="45%" cellspacing="0" cellpadding="0" class="tabQuadrille">
                    <!--AFFICHAGE DE LA LIGNE D'EN-TÊTE-->
                    <tr class="enTeteTabQuad">
                        <td width="30%">Lieu</td>
                        <td width="35%">Groupe</td>
                        <td width="35%">Heure Début</td> 
                        <td width="35%">Heure Fin</td>
                    </tr>
                    <?php
                    // BOUCLE SUR LES LIEUX (AFFICHAGE D'UNE LIGNE PAR LIEU AVEC LA REPRESENTATION POUR 
                    // LE lieu)
                    /* @var lieu $unLieu */
                    foreach ($this->lesLieux as $unLieu) {
                        ?>
                        <tr class="ligneTabQuad">
                            <td><?= $unLieu->getNom() ?></td>
                            <td><?= $unGroupe->getNom() ?></td>
                            <td><?= $uneRepresentation->getHeureDebut() ?></td>
                            <td><?= $uneRepresentation->getHeureFin() ?></td>
                            <?php
                            // On récupère le lieu et le groupe
                            // pour la représentation actuellement traités
                            $Representation = $this->tabRepresentation[$unGroupe->getId()][$unLieu->getLieu_Id()];
                            ?>
                            <td><?= $Representation ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table><br>
                <?php
            }
            include $this->getPied();
        }
    }

    public function setLesGroupes(array $lesGroupes) {
        $this->lesGroupes = $lesGroupes;
    }

    public function setLesLieux(array $lesLieux) {
        $this->lesLieux = $lesLieux;
    }
    
    public function setTabRepresentation(Array $tabRepresentation) {
        $this->tabRepresentation = $tabRepresentation;
    }

    

}
