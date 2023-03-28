<?php
require_once "connexiondb.php";


function selectProductByID($id) : array {
    $connexion = createConnection();
    $requeteSQL = "SELECT * FROM produit WHERE id_categorie = :id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue(":id",$id);
    $requete->execute();
    $produits = $requete ->fetchAll(PDO::FETCH_ASSOC);
    return $produits;
}

function selectCategoryByID($id) : array {
    $connexion = createConnection();
    $requeteSQL = "SELECT * FROM categorie WHERE id_categorie = :id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue(":id",$id);
    $requete->execute();
    $produits = $requete ->fetchAll(PDO::FETCH_ASSOC);
    return $produits;
}

function selectAllCategory() : array {
    $connexion = createConnection();
    $requete = $connexion->prepare("SELECT * FROM categorie");
    $requete->execute();
    $categorie = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $categorie;
}

function selectAllProduct() : array {
    $connexion = createConnection();
    $requete = $connexion->prepare("SELECT * FROM produit");
    $requete->execute();
    $categorie = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $categorie;
}