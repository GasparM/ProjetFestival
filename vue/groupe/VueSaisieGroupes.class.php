<?php

namespace vue\groupe;

use vue\VueGenerique;
use modele\metier\Groupe;



class VueSaisieGroupes extends VueGenerique {

    /** @var Groupe à afficher */
    private $unGroupe;

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
        <form method="POST" action="index.php?controleur=groupes&action=<?= $this->actionAEnvoyer ?>">
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
                        <td><input type="text" value="<?= $this->unGroupe->getId() ?>" name="id" size ="10" maxlength="8"></td>
                    </tr>
                    <?php
                } else {
                    // sinon l'id est dans un champ caché 
                    ?>
                    <tr>
                        <td><input type="hidden" value="<?= $this->unGroupe->getId(); ?>" name="id"></td><td></td>
                    </tr>
                    <?php
                }
                ?>
                    
                    
                <tr class="ligneTabNonQuad">
                    <td> Nom*: </td>
                    <td><input type="text" value="<?= $this->unGroupe->getNom() ?>" name="nom" pattern="[a-zA-Z]{1,}" size="50" 
                               maxlength="45"></td>
                </tr>
                
                <tr class="ligneTabNonQuad">
                    <td> Identite*: </td>
                    <td><input type="text" value="<?= $this->unGroupe->getIdentite() ?>" name="identite" 
                               size="7" maxlength="5"></td>
                </tr>
                
                <tr class="ligneTabNonQuad">
                    <td> Adresse : </td>
                    <td><input type="text" value="<?= $this->unGroupe->getAdresse() ?>" name="adresse" 
                               size="50" maxlength="45"></td>
                </tr>

                <tr class="ligneTabNonQuad">
                    <td> Nombre de personne *: </td>
                    <td><input type="text" value="<?= $this->unGroupe->getNbPers() ?>" name="nbPers" size="40" 
                               maxlength="35"></td>
                </tr>
                <tr class="ligneTabNonQuad">
                    <td> Nom du pays : </td>
                    <td><input type="text" value="<?= $this->unGroupe->getNomPays() ?>" name="nomPays" size ="20" 
                               maxlength="35" ></td>
                </tr>
                <tr class="ligneTabNonQuad">
                    <td> Hébergement : </td>
                    <td><input type="text" value="<?= $this->unGroupe->getHebergement() ?>" name= "hebergement" size ="75" ></td>
                </tr>
            </table>

            <table align="center" cellspacing="15" cellpadding="0">
                <tr>
                    <td align="right"><input type="submit" value="Valider" name="valider">
                    </td>
                </tr>
            </table>
            <a href="index.php?controleur=groupes&action=liste">Retour</a>
        </form>
        <?php
        include $this->getPied();
    }

    public function setUnGroupe(Groupe $unGroupe) {
        $this->unGroupe = $unGroupe;
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