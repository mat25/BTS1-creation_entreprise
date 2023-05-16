
<?php
require_once "./src/modele/horaireDB.php";
require_once "./src/utils/jour.php";
$horaires = selectAllTimeTable();
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
    <title>Véritable Menuisier</title>
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
        </div>
    </header>

    <main>
        <div class="content">
            <div class="grille_contact">
                <div class="descritpion_et_horaire">
                    <h1>Horaire d'ouverture</h1>

                    <?php
                    $jourFr = jourDeLaSemaine();
                    foreach ($horaires as $horaire) {
                        if (empty($horaire["horaire_debut_matin"])) {

                            if ($horaire["jour"] == $jourFr) { ?>
                                <div class="JourDAujourdHui">
                                    <p><?= $horaire["jour"]?> : Fermer</p>
                                </div>
                            <?php } else { ?>
                                <p><?= $horaire["jour"]?> : Fermer</p>
                            <?php }?>

                        <?php } elseif (empty($horaire["horaire_debut_aprés_midi"])) {

                            if ($horaire["jour"] == $jourFr) { ?>
                                <div class="JourDAujourdHui">
                                    <p><?= $horaire["jour"]?> : <?= $horaire["horaire_debut_matin"]?> - <?= $horaire["horaire_fin_matin"]?> </p>
                                </div>
                            <?php } else { ?>
                                <p><?= $horaire["jour"]?> : <?= $horaire["horaire_debut_matin"]?> - <?= $horaire["horaire_fin_matin"]?> </p>
                            <?php }?>


                        <?php } else {

                            if ($horaire["jour"] == $jourFr) { ?>
                                <div class="JourDAujourdHui">
                                    <p><?= $horaire["jour"]?> : <?= $horaire["horaire_debut_matin"]?> - <?= $horaire["horaire_fin_matin"]?> |
                                        <?= $horaire["horaire_debut_aprés_midi"]?> - <?= $horaire["horaire_fin_apres_midi"]?></p>
                                </div>
                            <?php } else { ?>
                                <p><?= $horaire["jour"]?> : <?= $horaire["horaire_debut_matin"]?> - <?= $horaire["horaire_fin_matin"]?> |
                                    <?= $horaire["horaire_debut_aprés_midi"]?> - <?= $horaire["horaire_fin_apres_midi"]?></p>
                            <?php }?>

                        <?php } ?>
                    <?php } ?>
                </div>

                <div class="formulaire_contact">
                    <h1>Contactez Nous !</h1>
                    <form action="" method="post">

                        <input type="text" name="prenom" placeholder="Prénom">

                        <input class="nom" type="text" name="nom" placeholder="Nom">

                        <input type="text" name="email" placeholder="Email">

                        <input type="text" name="telephone" placeholder="Téléphone">

                        <input type="text" name="promotion" placeholder="Promotion">

                        <input type="text" name="sujet" placeholder="Sujet de votre message">

                        <textarea class="message" name="message" rows="5" placeholder="Votre message"></textarea>

                        <input type="submit" value="Envoyer">
                    </form>
                </div>

                <div class="info_general">
                    <div class="logo_reseau_sociaux">
                        <a href="https://www.facebook.com"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://twitter.com/?lang=fr"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://fr.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
                    </div>

                    <div class="ville">
                        <h2>Lyon</h2>
                    </div>

                    <div class="numero">
                        <h2>03 85 65 74 84</h2>
                    </div>

                    <div class="addresse">
                        <p>23 Rue des Macchabées,</p>
                        <p>69005 Lyon</p>
                    </div>

                    <div class="localisation">
                        <a href="https://goo.gl/maps/dNTG2usT5czjNcJU7"><p><i class="fa-solid fa-location-dot"></i>Venir nous voir</p></a>
                    </div>

                    <div class="contact_info">
                        <a href="mailto: contact@BestStudent.fr">contact@VéritableMenuisier.fr</a>
                    </div>

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