<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>LieuDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\LieuDAO;
        use modele\dao\Bdd;
        use controleur\Session;

require_once __DIR__ . '/../../includes/autoload.inc.php';

        $id = '1';
        Session::demarrer();
        Bdd::connecter();

        echo "<h2>Test LieuDAO</h2>";

        // Test n°1
        echo "<h3>1- Test getOneById</h3>";
        try {
            $objet = LieuDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- Test getAll</h3>";
        try {
            $lesObjets = LieuDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        Bdd::deconnecter();
        Session::arreter();
        ?>

    </body>
</html>
