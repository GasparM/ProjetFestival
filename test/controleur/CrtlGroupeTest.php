<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        use controleur\CtrlGroupes;
        use modele\dao\Bdd;
        use controleur\Session;
        require_once __DIR__ . '/../../includes/autoload.inc.php';
        Session::demarrer();
        Bdd::connecter();

        // Test n°1
        echo "<h3>1- getTabGrouepeAvecNbAttributions </h3>";
        try {
            $unControleur = new CtrlGroupes();
            $tab = $unControleur->getTabGroupesAvecNbAttributions();
            var_dump($tab);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
                ?>
    </body>
</html>