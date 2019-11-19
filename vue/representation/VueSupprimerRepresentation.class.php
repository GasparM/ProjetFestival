<?php

namespace vue\representation;

use vue\VueGenerique;
use modele\metier\Representation;

/**
 * Page de suppression d'une representation donné
 * @author g07
 * @version 2019
 */
class VueSupprimerRepresentation extends VueGenerique {

    /** @var Representation identificateur de la representation à afficher */
    private $uneRepresentation;

    public function __construct() {
        parent::__construct();
    }

    public function afficher() {
        include $this->getEntete();
        ?>
        <br><center>Voulez-vous vraiment supprimer la representation <?= $this->uneRepresentation->getGroupe() ?> ?
            <h3><br>
                <a href="index.php?controleur=representation&action=validerSupprimer&id=<?= $this->uneRepresenation->getId() ?>">Oui</a>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="index.php?controleur=representation">Non</a></h3>
        </center>
        <?php
        include $this->getPied();
    }

    function setUneRepresentation(Representation $uneRepresentation) {
        $this->uneRepresentation = $uneRepresentation;
    }
}
