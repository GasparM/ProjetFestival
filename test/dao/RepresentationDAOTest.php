<?php 
    use modele\dao\RepresentationDAO;
    use modele\metier\Groupe;
    use modele\metier\Lieu;
    use modele\metier\Representation;
    use modele\dao\Bdd;
    use controleur\Session;
    require_once __DIR__ . '/../../includes/autoload.inc.php';

    Session::demarrer();
    Bdd::connecter()
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ReprésentationDAO : test</title>
    </head>

    <body>

        <?php

        $id = '1';

        echo "<h2>Test RepresentationDAO</h2>";

        // Test n°1
        echo "<h3>1- Test getOneById</h3>";
        try {
            $objet = RepresentationDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- Test getAll</h3>";
        try {
            $lesObjets = RepresentationDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°3
        echo "<h3>3- Test insert BDD</h3>";
        try {
            $id = '99';
            $groupe = new Groupe('g001', 'Bagad Plougastel', 'Dan Ar Braz', 'Plougastel-Daoulas',98,'France - Bretagne','N');
            $lieu = new Lieu(1, "test", "testAdresse", 200);
            $objet1= new Representation($id, $lieu, $groupe, "12/12/2000", "10H00", "12H00");
            $ok = RepresentationDAO::insert($objet1);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = RepresentationDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $objet1->setHeureDebut("20H00");
            $ok = RepresentationDAO::update($id, $objet1);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = RepresentationDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°5
        echo "<h3>5- delete</h3>";
        try {
            $ok = RepresentationDAO::delete($id);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la supression ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        
        Bdd::deconnecter();
        Session::arreter();
        ?>

    </body>
</html>
