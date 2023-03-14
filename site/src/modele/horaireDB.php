<?php
require_once "connexiondb.php";

//SELECT * FROM horaires
function selectAllTimeTable() : array {
    $connexion = createConnection();
    $requete = $connexion->prepare("SELECT * FROM horaires");
    $requete->execute();
    $horaires = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $horaires;
}
