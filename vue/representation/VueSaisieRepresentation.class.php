<?php

namespace vue\representation;

use vue\VueGenerique;
use modele\metier\Representation;

/**
 * Description Page de saisie/modification des representation
 * @author g07
 * @version 2019
 */
class VueSaisieRepresentation extends VueGenerique {

    /** @var Represenation à afficher */
    private $uneRepresentation;

    /** @var Array de Lieu */
    private $lesLieux;
    
    /** @var Array de Groupe */
    private $lesGroupes;
    
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
                        <td><input type="hidden" value="<?= $this->uneRepresentation->getId() ?>" name="id"></td><td></td>
                    </tr>
                    <?php
                }
                ?>
   
                <tr class="ligneTabNonQuad">
                    <td> Lieu : </td>
                    <td><select name="lieu"
                    <?php 
                        // création du spinner lieux
                        foreach ($this->lesLieux as $unLieu){ 
                            if ($unLieu->getLieu_Id() == $this->uneRepresentation->getLieu()->getLieu_Id()){ ?>
                                <option selected="selected" value="<?= $unLieu->getLieu_Id() ?>" ><?= $unLieu->getNom()?></option>
                            <?php
                            }else{ ?> 
                                <option value="<?= $unLieu->getLieu_Id() ?>"><?= $unLieu->getNom()?></option>
                            <?php 
                            }
                        } ?>
                    </select></td>
                </tr>
                
                <tr class="ligneTabNonQuad">
                    <td> Groupe : </td>
                    <<td><select name="groupe"
                    <?php 
                        // création du spinner groupe
                        foreach ($this->lesGroupes as $unGroupe){ 
                            if ($unGroupe->getId() == $this->uneRepresentation->getGroupe()->getId()){ ?>
                                <option selected="selected" value="<?= $unGroupe->getId() ?>"  ><?= $unGroupe->getNom()?></option>
                            <?php
                            }else{ ?> 
                                <option value="<?= $unGroupe->getId() ?>"><?= $unGroupe->getNom()?></option>
                            <?php 
                            }?> 
                        <?php 
                        } ?>
                    </select></td>
                </tr>
                
                <tr class="ligneTabNonQuad">
                    <td> Date : </td>
                    <td><input type="text" value="<?= $this->uneRepresentation->getDate() ?>" name="date" 
                               size="50" maxlength="45" placeholder="AAAA/MM/JJ"></td>
                </tr>
                
                <tr class="ligneTabNonQuad">
                    <td> Heure Debut : </td>
                    <td><input type="text" value="<?= $this->uneRepresentation->getHeureDebut() ?>" name="heure_Debut" 
                               size="50" maxlength="45" placeholder="HH:MM:SS"></td>
                </tr>

                <tr class="ligneTabNonQuad">
                    <td> Heure Fin : </td>
                    <td><input type="text" value="<?= $this->uneRepresentation->getHeureFin() ?>" name="heure_Fin" size="40" 
                               maxlength="35" placeholder="HH:MM:SS"></td>
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

    public function setUneRepresentation(Representation $uneRepresentation) {
        $this->uneRepresentation = $uneRepresentation;
    }
    
    function setLesLieux(array $lesLieux) {
        $this->lesLieux = $lesLieux;
    }

    function setLesGroupes(array $lesGroupes) {
        $this->lesGroupes = $lesGroupes;
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


