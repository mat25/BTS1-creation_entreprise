<?php
session_start();
require_once "./src/modele/devisDB.php";
require_once "./src/modele/produitsDB.php";
require_once "./src/utils/prix.php";
if (!isset($_SESSION["panier"])) {
    // Création du panier
    $_SESSION["panier"] = [];
}
$erreurs = [];
$quantite_form = null;
$prenom_validation = null;
$nom_validation = null;
$email_validation = null;
$num_telephone_validation = null;
require_once "./src/modele/produitsDB.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["boutton-ajout"])) {

        if (empty(trim($_POST["all-product"]))) {
            $erreurs["produit"] = "Il faut choisir un produit !";
        }
        if (empty(trim($_POST["quantite"]))) {
            $erreurs["quantite"] = "Il faut choisir une quantite !";
        } elseif ($_POST["quantite"] <= 0) {
            $erreurs["quantite"] = "Il faut choisir une quantite superieur a 0 !";
        } else {
            $quantite_form = trim($_POST["quantite"]);
        }


        if (empty($erreurs)) {
            $id = $_POST["all-product"];
            $produitChoisi = selectProductByIDProduct($id);
            $idProduit = $produitChoisi[0]["id_produit"];
            $nomProduit = $produitChoisi[0]["nom_produit"];
            $prixProduit = $produitChoisi[0]["prix_ht"];
            $qteDisponnible = $produitChoisi[0]["quantité_stock"];
            $image = $produitChoisi[0]["photo"];
            $qteProduit = $_POST["quantite"];
            if ($qteProduit > $qteDisponnible) {
                $erreurs["produit"] = "Il ne reste que $qteDisponnible produit en stock !";
            }
            if (isset($_SESSION["panier"][$nomProduit])) {
                $erreurs["produit"] = "Ce produit est deja ajouter au panier";
            }
        }

        if (empty($erreurs)) {
            $produit = [
                "id" => $idProduit,
                "image-produit" => $image,
                "nom" => $nomProduit,
                "prix" => $prixProduit,
                "quantite" => $qteProduit,
            ];
            $_SESSION["panier"][$nomProduit] = $produit;
        }

    } elseif (isset($_POST["btn-modif"])) {
        $id = $_POST["id-produit"];
        $produitChoisi = selectProductByIDProduct($id);
        $qteDisponnible = $produitChoisi[0]["quantité_stock"];
        $nom = $_POST["nom-produit"];
        $quantite = $_POST["quantite-produit"];
        if ($quantite > $qteDisponnible) {
            $erreurs[$nom] = "Il ne reste que $qteDisponnible produit en stock !";
        } elseif ($quantite > 0) {
            $_SESSION["panier"][$nom]["quantite"] = $quantite;
        }
    } elseif (isset($_POST["btn-suppr"])) {
        $nom = $_POST["nom-produit"];
        unset($_SESSION["panier"][$nom]);

        if (empty($_SESSION["panier"])) {
            unset($_SESSION["user_panier"]);
        }


    } elseif (isset($_POST["vider-panier"])) {
        foreach ($_SESSION["panier"] as $produit) {
            $nom = $produit["nom"];
            unset($_SESSION["panier"][$nom]);
        }
        unset($_SESSION["user_panier"]);

    } elseif (isset($_POST["valid-devis"])) {
        if (empty(trim($_POST["prenom_validation"]))) {
            $erreurs["prenom_validation"] = "Le prenom est obligatoire";
        } else {
            $prenom_validation = $_POST["prenom_validation"];
        }

        if (empty(trim($_POST["nom_validation"]))) {
            $erreurs["nom_validation"] = "Le nom est obligatoire";
        } else {
            $nom_validation = $_POST["nom_validation"];
        }

        if (empty(trim($_POST["email_validation"]))) {
            $erreurs["email_validation"] = "L'email est obligatoire";
        } elseif (!filter_var(trim($_POST["email_validation"]), FILTER_VALIDATE_EMAIL)) {
            $erreurs["email_validation"] = "L'email n'est pas valide !";
        } else {
            $email_validation = $_POST["email_validation"];
        }

        if (empty(trim($_POST["num_telephone_validation"]))) {
            $erreurs["num_telephone_validation"] = "Le numero de téléphone est obligatoire";
        } else {
            $num_telephone_validation = $_POST["num_telephone_validation"];
        }

        if (empty($_SESSION["panier"])) {
            $erreurs["valide_panier"] = "il faut ajouter des produits au panier !";
        }

        if (empty($erreurs)) {
            // Requete SQL qui ajoute le panier dans la BDD
            $heure = date("Y-m-d H:i:s");
            $valide = true;
            addDevis($heure,$valide,$nom_validation,$prenom_validation,$email_validation,$num_telephone_validation);
            $ArrayId = selectIdBydate($heure);
            $id = $ArrayId["id_devis"];
            foreach ($_SESSION["panier"] as $produit) {
                addContenuDevis($id,$produit["id"],$produit["quantite"]);
                updateStock($produit["id"],$produit["quantite"]);
            }
            foreach ($_SESSION["panier"] as $produit) {
                $nom = $produit["nom"];
                unset($_SESSION["panier"][$nom]);
            }
            unset($_SESSION["user_panier"]);
            header("location:index.php");
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
            <h1>Panier</h1>
        </div>
    </header>

    <main>
        <div class="content">

            <div class="formulaire_ajout_panier">
                <h1>Ajouter un article au devis</h1>
                <form action="" method="post">
                    <select name="all-product" id="all-product">
                        <option value="">Veuillez choisir votre produit</option>
                        <?php
                        $idBefore = 0;
                        foreach ($produits

                        as $produit) {
                        $idNow = $produit["id_categorie"];
                        if ($idNow <> $idBefore) {
                        $idBefore = $idNow;
                        $categorie = selectCategoryByID($idNow);
                        ?>
                        </optgroup>
                        <optgroup label="<?= $categorie[0]["Libelle_categorie"] ?>">
                            <?php } ?>
                            <option value="<?= $produit["id_produit"] ?>"><?= $produit["nom_produit"] . " (" . formatPrix($produit["prix_ht"]) . ")" ?></option>
                            <?php } ?>
                        </optgroup>
                    </select>
                    <?php if (isset($erreurs["produit"])) { ?>
                        <div class="erreur_validation">
                            <p><?= $erreurs["produit"] ?></p>
                        </div>
                    <?php } ?>
                    <input type="number" name="quantite" min="1" placeholder="Veuillez saisir une quantité"
                           value="<?= $quantite_form ?>">
                    <?php if (isset($erreurs["quantite"])) { ?>
                        <div class="erreur_validation">
                            <p><?= $erreurs["quantite"] ?></p>
                        </div>
                    <?php } ?>
                    <input type="submit" value="Ajouter au devis" name="boutton-ajout">
                </form>
            </div>

            <div class="table">
                <h1>Récapitulatif du devis</h1>
                <table class="blueTable">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
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
                            <td><img src="image/produit/<?= $produit["image-produit"]?>" alt="image du produit" width="200px" height="150px"></td>
                            <td><?= $produit["nom"] ?></td>
                            <td><?= formatPrix($produit["prix"] . " ") ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="nom-produit" value="<?= $produit["nom"] ?>">
                                    <input type="hidden" name="id-produit" value="<?= $produit["id"] ?>">
                                    <input type="number" name="quantite-produit" min="1"
                                           value="<?= $produit["quantite"] ?>">
                                    <button type="submit" class="btn-modif" name="btn-modif">Modifier</button>
                                    <?php if (isset($erreurs[$produit["nom"]])) { ?>
                                        <div class="erreur_validation">
                                            <p><?= $erreurs[$produit["nom"]] ?></p>
                                        </div>
                                    <?php } ?>
                                </form>
                            </td>
                            <td><?= $totalProduit ?> €</td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="nom-produit" value="<?= $produit["nom"] ?>">
                                    <button type="submit" class="btn-suppr" name="btn-suppr">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="2">
                        </td>
                        <td>Total</td>
                        <td>
                            <div class="total"><?= $total ?> €</div>
                        </td>
                        <td>
                            <form method="post">
                                <button type="submit" class="btn-suppr" name="vider-panier">Vider panier</button>
                            </form>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <h1>Validation du devis</h1>
                <div class="btn-retour-commande">
                    <p>
                        <?php if (isset($erreurs["valide_panier"])){ ?>
                    <div class="erreur_validation">
                        <p><?= $erreurs["valide_panier"] ?></p>
                    </div>
                    <?php } ?>
                    <div class="formulaire_ajout_panier">
                        <form method="post">

                            <input type="text" name="prenom_validation" placeholder="Prénom"
                                   value="<?= $prenom_validation ?>"></input>
                            <?php if (isset($erreurs["prenom_validation"])) { ?>
                                <div class="erreur_validation">
                                    <p><?= $erreurs["prenom_validation"] ?></p>
                                </div>
                            <?php } ?>

                            <input type="text" name="nom_validation" placeholder="Nom"
                                   value="<?= $nom_validation ?>"></input>
                            <?php if (isset($erreurs["nom_validation"])) { ?>
                                <div class="erreur_validation">
                                    <p><?= $erreurs["nom_validation"] ?></p>
                                </div>
                            <?php } ?>

                            <input type="text" name="email_validation" placeholder="Email"
                                   value="<?= $email_validation ?>"></input>
                            <?php if (isset($erreurs["email_validation"])) { ?>
                                <div class="erreur_validation">
                                    <p><?= $erreurs["email_validation"] ?></p>
                                </div>
                            <?php } ?>

                            <input type="text" name="num_telephone_validation" placeholder="Numéro de téléphone"
                                   value="<?= $num_telephone_validation ?>"></input>
                            <?php if (isset($erreurs["num_telephone_validation"])) { ?>
                                <div class="erreur_validation">
                                    <p><?= $erreurs["num_telephone_validation"] ?></p>
                                </div>
                            <?php } ?>

                            <button type="submit" class="btn-valid-devis" name="valid-devis">Valider le devis</button>
                        </form>
                    </div>
                    </p>
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
            <p>Conformément à la réglementation applicable en matière de données personnelles, vous disposez d'un droit
                d'accès, de rectification et d'effacement, du droit à la limitation du traitement des données vous
                concernant. Vous pouvez consulter notre politique de confidentialité</p>
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