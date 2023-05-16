<?php

require_once "connexiondb.php";

function addDevis(string $date,bool $valide,string $nom,string $prenom,string $email,string $telephone) {
    $connexion = createConnection();
    $requeteSQL = "INSERT INTO devis (date_devis,devis_valide,nom_client,prenom_client,email_client,numero_tel_client) 
                VALUES (:date,:valide,:nom,:prenom,:email,:telephone)";
    $requete = $connexion->prepare($requeteSQL);

    $requete->bindValue(":date",$date);
    $requete->bindValue(":valide",$valide);
    $requete->bindValue(":nom",$nom);
    $requete->bindValue(":prenom",$prenom);
    $requete->bindValue(":email",$email);
    $requete->bindValue(":telephone",$telephone);

    return $requete->execute();
}

function selectIdBydate($date) {
    $connexion = createConnection();
    $requeteSQL = "SELECT id_devis FROM devis WHERE date_devis = :date";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue(":date",$date);
    $requete->execute();
    $id = $requete->fetch();
    return $id;
}

function addContenuDevis(string $idDevis,string $idProduit,string $quantite) {
    $connexion = createConnection();
    $requeteSQL = "INSERT INTO contenu_devis (id_devis,id_produit,quantite_produit_commande) 
                VALUES (:idDevis,:idProduit,:quantite)";
    $requete = $connexion->prepare($requeteSQL);

    $requete->bindValue(":idDevis",$idDevis);
    $requete->bindValue(":idProduit",$idProduit);
    $requete->bindValue(":quantite",$quantite);

    return $requete->execute();
}

function updateStock(string $idProduit, string $quantite) {
    $connexion = createConnection();
    $requeteSQL = "UPDATE produit SET quantité_stock = quantité_stock - :qteAchete WHERE id_produit = :idProduit";
    $requete = $connexion->prepare($requeteSQL);

    $requete->bindValue(":qteAchete",$quantite);
    $requete->bindValue(":idProduit",$idProduit);

    return $requete->execute();
}



