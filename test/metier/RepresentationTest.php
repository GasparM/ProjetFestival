<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lieu Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Lieu;
        use modele\metier\Groupe;
        use modele\metier\Representation;
        require_once __DIR__ . '/../../includes/autoload.inc.php';
        echo "<h2>Test unitaire de la classe métier Représentation </h2>";
        $lieu = new Lieu(1,"Soirée","24 rue professeur Dubuisson", 200000);
        $groupe = new Groupe("g999","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","N");
        $objet = new Representation($lieu, $groupe, "2017/07/11", "12:30", "14:30");
        var_dump($objet);
        ?>
    </body>
</html>
