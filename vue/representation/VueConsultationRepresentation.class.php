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
    
    /** @var Array tableau des dates des représentation */    
    private $lesDates;

    public function __construct() {
        parent::__construct();
    }

    public function afficher() {
        include $this->getEntete();
        $i=0;
        foreach($this->lesDates as $uneDate){                                   // foreach pour parcourir tout les dates 
        ?>        
            <table width="45%" cellspacing="0" cellpadding="0" class="tabQuadrille">
            <tr class="enTeteTabQuad">
                <td width="45%">Lieu</td>
                <td width="35%">Groupe</td>
                <td width="35%">Heure Début</td>    
                <td width="35%">Heure Fin</td>
                <td width="20%">Supprimer</td>
                <td width="20%">Modifier</td>
                
            </tr>
            <h3> <?= $uneDate ?></h3>
            <?php
            while($this->lesRepresentations[$i]->getDate() == $uneDate){        //while qui permet d'afficher toute les représentations de chaque date
                ?>
                
                <tr class="ligneTabQuad">
                    <td><?= $this->lesRepresentations[$i]->getLieu()->getNom() ?></td>     <!-- affiche le lieu -->
                    <td><?= $this->lesRepresentations[$i]->getGroupe()->getNom() ?></td>   <!-- affiche le groupe -->
                    <td><?= $this->lesRepresentations[$i]->getHeureDebut() ?></td>         <!-- affiche l'heure du début de la représentation -->
                    <td><?= $this->lesRepresentations[$i]->getHeureFin() ?></td>           <!-- affiche l'heure de fin de la représentation -->
                    <td><a href="index.php?controleur=representation&action=supprimer&id=<?= $this->lesRepresentations[$i]->getId() ?>" >Supprimer</a></td>
                    <td><a href="index.php?controleur=representation&action=modifier&id=<?= $this->lesRepresentations[$i]->getId() ?>" >Modifier</a> </td>
                </tr>
                <?php
                if($i < count($this->lesRepresentations)-1){                    // si pour savoir si on dépasse le nombre de représentations et arrête le while
                    $i+=1;
                }else{
                    break;
                }
            }
        }
        include $this->getPied();?>
        <a href="index.php?controleur=representation&action=creer" >Ajouter une représentation</a>
        <?php
    }
    
    public function setLesRepresentations(array $lesRepresentations){
        $this->lesRepresentations = $lesRepresentations;
    }
    
    public function setLesDates(array $lesDates){
        $this->lesDates = $lesDates;
    }
}
