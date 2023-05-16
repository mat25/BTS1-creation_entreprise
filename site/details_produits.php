<?php

require_once "./src/modele/produitsDB.php";
require_once "./src/utils/prix.php";


$id = null;
$page=null;
$erreur = null;
if (!empty($_GET["id"])) {
    // Le parametre existe
    $id=$_GET["id"];
} else {
    // Le paramettre n'existe pas ou ets vide
    $erreur = "L'URL n'est pas valide !";
}
$produits = selectProductByID($id);
$categorie = selectCategoryByID($id)
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
<?php
if (isset($erreur) ) { ?>
    <div class="erreur">
        <h2>Erreur</h2>
        <p><?= $erreur?></p>
    </div>
<?php } else { ?>
    <div class="container">
        <nav class="navigation">
            <div class="image">
                <a href="index.php">
                    <img src="image/logo_entreprise.png" alt="outils de menuiserie">
                </a>
            </div>
            <div class="panier_utilisateur">
                <a href="panier.php">Panier</a>
                <a href="compte_utilisateur.php"><i class="fa-solid fa-user"></i>Se connecter</a>
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
                <h1><?= $categorie[0]["Libelle_categorie"]?></h1>
            </div>
            <div class="chemin_produit">
                <p>
                    <a href="produit.php"><i class="fa-solid fa-house"></i></a>
                    >
                </p>
                <p>
                    <?= $categorie[0]["Libelle_categorie"]?>
                </p>
            </div>
        </header>

        <main>
            <div class="content">
                <div class="content_details_produit">
                    <div class="grille_produit">
                        <?php
                        foreach ($produits as $produit) { ?>
                            <div class="carte">
                                    <img src="./image/produit/<?= $produit["photo"]?>" alt="">
                                    <h2><?= $produit["nom_produit"]?></h2>
                                    <p><?= formatPrix($produit["prix_ht"])?>
                                    <i class="fa-solid fa-cart-plus"></i></p>
                            </div>
                        <?php } ?>

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

    <?php } ?>
</body>
</html>