<?php
/**
 * Description Page de consultation de la liste des groupes
 * -> affiche Uun tableau constitué d'une ligne d'entête et d'une ligne par groupe
 * @author btssio
 */
namespace vue\groupe;

use vue\VueGenerique;

class VueListeGroupes extends VueGenerique {
    
    /** @var array liste des groupes à afficher avec leur nombre d'atttributions */
    private $lesGroupesAvecNbAttributions;
    

    public function __construct() {
        parent::__construct();
    }

    public function afficher() {
        include $this->getEntete();
        ?>
        <br>
        <table width="55%" cellspacing="0" cellpadding="0" class="tabNonQuadrille" >

            <tr class="enTeteTabNonQuad" >
                <td colspan="4" ><strong>Groupes</strong></td>
            </tr>
            <?php
            // Pour chaque groupe lu dans la base de données
            foreach ($this->lesGroupesAvecNbAttributions as $unGroupeAvecNbAttrib) {
                $unGroupe = $unGroupeAvecNbAttrib["groupe"];
                $id = $unGroupe->getId();
                $nom = $unGroupe->getNom();
                ?>
                <tr class="ligneTabNonQuad" >
                    <td width="52%" ><?= $nom ?></td>

                    <td width="16%" align="center" > 
                        <a href="index.php?controleur=groupes&action=detail&id=<?= $id ?>" >
                            Voir détail</a>
                    </td>

                    <td width="16%" align="center" > 
                        <a href="index.php?controleur=groupes&action=modifier&id=<?= $id ?>" >
                            Modifier
                        </a>
                    </td>
                    <td width="16%" align="center" > 
                        <a href="index.php?controleur=groupes&action=supprimer&id=<?= $id ?>" >
                            Supprimer
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <a href="index.php?controleur=groupes&action=creer" >
            Création d'un groupe</a >
        <?php
        include $this->getPied();
    }

    function getLesGroupesAvecNbAttributions() {
        return $this->lesGroupesAvecNbAttributions;
    }

    function setLesGroupesAvecNbAttributions($lesGroupesAvecNbAttributions) {
        $this->lesGroupesAvecNbAttributions = $lesGroupesAvecNbAttributions;
    }



}
