<?php

namespace vue\representation;

use vue\VueGenerique;
use modele\metier\Representation;

/**
 * Description Page de saisie/modification des representations
 * @author g07
 * @version 2019
 */
class VueSaisieRepresentation extends VueGenerique {

    /** @var Represenation à afficher */
    private $uneRepresentation;

    /** @var string ="creer" ou = "modifier" en fonction de l'utilisation du formulaire */
    private $actionRecue;

    /** @var string ="validerCreer" ou = "validerModifier" en fonction de l'utilisation du formulaire */
    private $actionAEnvoyer;

    /** @var string à afficher en tête du tableau */
    private $message;

    public function __construct() {
        parent::__construct();
    }

    public function afficher() {
        include $this->getEntete();
        ?>
        <form method="POST" action="index.php?controleur=representation&action=<?= $this->actionAEnvoyer ?>">
            <br>
            <table width="85%" cellspacing="0" cellpadding="0" class="tabNonQuadrille">

                <tr class="enTeteTabNonQuad">
                    <td colspan="3"><strong><?= $this->message ?></strong></td>
                </tr>

                <?php
                // En cas de création, l'id est accessible à la saisie           
                if ($this->actionRecue == "creer") {
                    // On a le souci de ré-afficher l'id tel qu'il a été saisi
                    ?>
                    <tr class="ligneTabNonQuad">
                        <td> Id*: </td>
                        <td><input type="text" value="<?= $this->uneRepresentation->getId() ?>" name="id" size ="10" maxlength="8"></td>
                    </tr>
                    <?php
                } else {
                    // sinon l'id est dans un champ caché 
                    ?>
                    <tr>
                        <td><input type="hidden" value="<?= $this->uneRepresentation->getId(); ?>" name="id"></td><td></td>
                    </tr>
                    <?php
                }
                ?>
                    
                    
                <tr class="ligneTabNonQuad">
                    <td> Nom groupe : </td>
                    <td><input type="text" value="<?= $this->uneRepresentation->getGroupe() ?>" name="nom_groupe" pattern="[a-zA-Z]{1,}" size="50" 
                               maxlength="45"></td>
                </tr>
                
                <tr class="ligneTabNonQuad">
                    <td> Lieu : </td>
                    <td><input type="text" value="<?= $this->uneRepresentation->getLieu() ?>" name="nom_lieu" 
                               size="50" maxlength="50"></td>
                </tr>
                
                <tr class="ligneTabNonQuad">
                    <td> Heure Debut : </td>
                    <td><input type="text" value="<?= $this->uneRepresentation->getHeureDebut() ?>" name="heure_debut" 
                               size="50" maxlength="45"></td>
                </tr>

                <tr class="ligneTabNonQuad">
                    <td> Heure Fin : </td>
                    <td><input type="text" value="<?= $this->uneRepresentation->getHeureFin() ?>" name="heure_fin" size="40" 
                               maxlength="35"></td>
                </tr>
            </table>

            <table align="center" cellspacing="15" cellpadding="0">
                <tr>
                    <td align="right"><input type="submit" value="Valider" name="valider">
                    </td>
                </tr>
            </table>
            <a href="index.php?controleur=representation">Retour</a>
        </form>
        <?php
        include $this->getPied();
    }

    public function getUneRepresentation(): Representation {
        return $this->uneRepresentation;
    }

    public function setUneRepresentation(Representation $uneRepresentation) {
        $this->uneRepresentation = $uneRepresentation;
    }

    public function setActionRecue(string $action) {
        $this->actionRecue = $action;
    }

    public function setActionAEnvoyer(string $action) {
        $this->actionAEnvoyer = $action;
    }

    public function setMessage(string $message) {
        $this->message = $message;
    }

}


