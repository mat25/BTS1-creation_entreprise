<?php
session_start();
require_once "./src/modele/produitsDB.php";
if (!isset($_SESSION["panier"])) {
    // Création du panier
    $_SESSION["panier"] = [];
}
require_once "./src/modele/produitsDB.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST);
    if(isset($_POST["boutton-ajout"])) {
        $id = $_POST["all-product"];

        $produitChoisi = selectProductByIDProduct($id);
        print_r($produitChoisi);
        $nomProduit = $produitChoisi[0]["nom_produit"];
        $prixProduit = $produitChoisi[0]["prix_ht"];
        if (array_key_exists($id, $_SESSION["panier"])) {
            $erreurs = "Ce produit est deja ajouter au panier";
        } else {
            $produit = [
                "nom" => $nomProduit,
                "prix" => $prixProduit,
                "quantite" => 1,
            ];
            $_SESSION["panier"][$nomProduit] = $produit;
        }
    } elseif (isset($_POST["btn-modif"])) {
        $nom = $_POST["nom-produit"];
        $quantite = $_POST["quantite-produit"];
        $_SESSION["panier"][$nom]["quantite"] = $quantite;
    } elseif (isset($_POST["btn-suppr"])) {
        $nom = $_POST["nom-produit"];
        unset($_SESSION["panier"][$nom]);
    } elseif (isset($_POST["vider-panier"])) {
        foreach ($_SESSION["panier"] as $produit) {
            $nom = $produit["nom"];
            unset($_SESSION["panier"][$nom]);
        }
    }
}


require_once "./src/modele/produitsDB.php";
$produits = selectAllProduct();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="style.css">
    <title>Véritable Menuiserie</title>
</head>
<body>
<div class="container">
    <nav class="navigation">
        <div class="image">
            <a href="index.php">
                <img src="image/logo_entreprise.png" alt="outils de menuiserie">
            </a>
        </div>
        <div class="panier_utilisateur">
            <a href="panier.php"><i class="fa-solid fa-basket-shopping"></i></a>
            <a href="compte_utilisateur.php"><i class="fa-solid fa-user"></i></a>
        </div>
        <div class="accueil">
            <p>
                <a href="index.php">Accueil</a>
            </p>
        </div>
        <div class="produits">
            <p>
                <a href="produit.php">Nos produits</a>
            </p>
        </div>
        <div class="services">
            <p>
                <a href="organigramme.php">Notre personnel</a>
            </p>
        </div>
        <div class="contact">
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <header>
        <div class="header">
            <h1>Panier</h1>
        </div>
    </header>

    <main>
        <div class="content">

            <div class="formulaire_ajout_panier">
                <h1>Ajouter un article au devis</h1>
                <form action="" method="post">
                    <input type="text" name="prenom" placeholder="Prénom">

                    <input type="text" name="nom" placeholder="Nom">

                    <select name="all-product" id="all-product">
                        <option value="">Veuillez choisir votre produit</option>
                        <?php
                        $idBefore = 0;
                        foreach ($produits as $produit) {
                            $idNow = $produit["id_categorie"];
                            if ($idNow <> $idBefore) {
                                $idBefore = $idNow;
                                $categorie = selectCategoryByID($idNow);
                            ?>
                                </optgroup>
                                <optgroup  label="<?= $categorie[0]["Libelle_categorie"]?>">
                            <?php } ?>
                            <option value="<?= $produit["id_produit"]?>"><?= $produit["nom_produit"]?></option>
                        <?php } ?>
                        </optgroup>
                    </select>
                    <input type="number" name="quantite" min="1" placeholder="Veuillez saisir une quantité">
                    <input type="submit" value="Ajouter au devis" name="boutton-ajout">
                </form>
            </div>

            <div class="table">
                <table class="blueTable">
                    <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>total</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION["panier"] as $produit) {
                        $totalProduit = $produit["prix"] * $produit["quantite"];
                        $total += $totalProduit;
                        ?>
                        <tr>
                            <td><?= $produit["nom"]?></td>
                            <td><?= $produit["prix"]?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="nom-produit" value="<?= $produit["nom"]?>">
                                    <input type="number" name="quantite-produit" min="1" value="<?= $produit["quantite"]?>">
                                    <button type="submit" class="btn-modif" name="btn-modif">Modifier</button>
                                </form>
                            </td>
                            <td><?= $totalProduit?> €</td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="nom-produit" value="<?= $produit["nom"]?>">
                                    <button type="submit" class="btn-suppr" name="btn-suppr">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="3">
                            Total
                        </td>
                        <td><div class="total"><?= $total?> €</div></td>
                        <td>
                            <form method="post">
                                <button type="submit" class="btn-suppr" name="vider-panier">Vider panier</button>
                            </form>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <div class="btn-retour-commande">
                    <p><a href="index.php">Valider le devis</a></p>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="fabrication_francaise">
            <img src="image/fabrication_francaise.png" alt="drapeau Français">
            <h2>Fabrication Française</h2>
            <p>Dans notre atelier prés de Lyon</p>
        </div>
        <div class="pose_pro">
            <img src="image/pose_pro.png" alt="Casquet rouge">
            <h2>Pose par un pro</h2>
            <p>Des artisans avec beaucoup d'expérience</p>
        </div>
        <div class="livraison">
            <img src="image/livraison.png" alt="Carton">
            <h2>Livraison à domicile</h2>
            <p>Par transporteur partenaire</p>
        </div>
        <div class="retrait_atelier">
            <img src="image/retrait.png" alt="Devanture de magasin">
            <h2>Retrait à notre atelier</h2>
            <p>Gratuit préparé par nos équipes</p>
        </div>
        <div class="rgpd">
            <p>Conformément à la réglementation applicable en matière de données personnelles, vous disposez d'un droit d'accès, de rectification et d'effacement, du droit à la limitation du traitement des données vous concernant. Vous pouvez consulter notre politique de confidentialité</p>
        </div>
        <div class="paiement">
            <a href="https://www.facebook.com"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://twitter.com/?lang=fr"><i class="fa-brands fa-twitter"></i></a>
            <a href="https://fr.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
            <div class="boutton_acces_espace_client">
                <a href="contact.php">Nous contactez</a>
            </div>
        </div>
        <div class="copyright">
            <p>© Véritable Menuisier</p>
        </div>
    </footer>

</div>
</body>
</html>