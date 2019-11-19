<?php
/**
 * Description Page de consultation des représentation groupées par lieu et par date
 * @author groupe 7
 * @version 2019
 */

namespace vue\representation;

use vue\VueGenerique;
use modele\metier\Representation;
use modele\metier\Lieu;
use modele\metier\Groupe;

class VueConsultationRepresentation extends VueGenerique {

    /** @var Array tableau associatif des représentations par groupe, par lieu */
    private $lesRepresentations;
    

    public function __construct() {
        parent::__construct();
    }

    public function afficher() {
        include $this->getEntete();
        ?>
        <table width="45%" cellspacing="0" cellpadding="0" class="tabQuadrille">
            <!--AFFICHAGE DE LA LIGNE D'EN-TÊTE-->
            <tr class="enTeteTabQuad">
                <td width="30%">Lieu</td>
                <td width="35%">Groupe</td>
                <td width="35%">Heure Début</td> 
                <td width="35%">Heure Fin</td>
            </tr>
        <?php
        $datePrecedent = $this->lesRepresentations[0]->getDate();           //initialise la date de la première représentation
        foreach ($this->lesRepresentations as $uneRepresentation){          //foreach pour parcourir toute les représentations
        ?>
            <tr class="ligneTabQuad">
                <td><?= $uneRepresentation->getLieu()->getNom() ?></td>     <!-- affiche le lieu -->
                <td><?= $uneRepresentation->getGroupe()->getNom() ?></td>   <!-- affiche le groupe -->
                <td><?= $uneRepresentation->getHeureDebut() ?></td>         <!-- affiche l'heure du début de la représentation -->
                <td><?= $uneRepresentation->getHeureFin() ?></td>           <!-- affiche l'heure de fin de la représentation -->
            </tr>
            <?php
            if($uneRepresentation->getDate() != $datePrecedent){        // vérifie si la date de la réprésentation est la même que la précédente, si oui alors créer une nouvelle table
                $datePrecedent=$uneRepresentation->getDate();           // prend la nouvelle date
                ?> 
                <h3><?= $datePrecedent?></h3>                           <!-- affiche la date -->
                </table><br>                                            <!-- creer un nouveau tableau -->
                <table width="45%" cellspacing="0" cellpadding="0" class="tabQuadrille">
                <tr class="enTeteTabQuad">
                    <td width="30%">Lieu</td>
                    <td width="35%">Groupe</td>
                    <td width="35%">Heure Début</td> 
                    <td width="35%">Heure Fin</td>
                </tr>
                <?php
            }
        }
        include $this->getPied();
    }
    
    public function setLesRepresentations(array $lesRepresentations){
        $this->lesRepresentations = $lesRepresentations;
    }
    
}
