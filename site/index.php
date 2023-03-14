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
                <img src="image/logo.png" alt="outils de menuiserie">
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
                <a href="organigramme.php">Notre entreprise</a>
            </p>
        </div>
        <div class="contact">
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <header>
        <div class="header">
            <h1>Accueil</h1>
        </div>
    </header>

    <main>
        <div class="content">
            <div class="content_accueil">
                <div class="main_grid_content">
                    <div class="titre_entreprise">
                        <h2>L’entreprise Véritable Menuiserie</h2>
                        <p></p>
                    </div>
                        <p>Forts de notre expérience, nous vous proposons de nombreuses réalisations de menuiseries bois, PVC, alu, ainsi que nos services dans le domaine de la charpente et de l’agencement.
                        Notre équipe de professionnels qualifiés vous garantit un travail soigné et un travail de qualité.</p>
                    <img class="image_batiment_neuf_accueil"  src="image/batiment_neuf.png" alt="depot de l'entreprise neuf">


                    <img class="image_batiment_accueil"  src="image/Depot_entreprise.PNG" alt="depot de l'entreprise">
                    <div class="historique_entreprise">
                        <h2>Historique de l’entreprise</h2>
                    </div>
                    <p>Création d’un atelier de menuiserie en 2010 par Bernard Huard dans un petit village prés de Lyon. Puis il embauchera des nouvelles personnes en 2015 puis finira par s'installer dans un nouveau batiment plus grand et plus récents.</p>

                    <h2 class="organigramme">Organigramme</h2>
                    <div>
                        <p>Voici les differents employés de l'entreprise.</p>
                        <p>Vous pouvez retrouvez les fiches de postes de chaque employé ici :
                            <a href="organigramme.php" class="bouton_fiche_poste"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></p>
                    </div>
                    <img class="image_organigramme" src="image/organigramme.PNG" alt="organigramme de l'entreprise">
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
            <h2>Retrait a notre atelier</h2>
            <p>Gratuit préparé par nos équipes</p>
        </div>
        <div class="rgpd">
            <p>Conformément à la réglementation applicable en matière de données personnelles, vous disposez d'un droit d'accès, de rectification et d'effacement, du droit à la limitation du traitement des données vous concernant. Vous pouvez consulter notre politique de confidentialité</p>
        </div>
        <div class="boutton_acces_espace_client">
            <p><a href="compte_utilisateur.php">Accéder a mon espace</a></p>
        </div>
        <div class="paiement">
            <i class="fa-brands fa-cc-visa"></i>
            <i class="fa-brands fa-cc-mastercard"></i>
            <img class="CB" src="image/CB.svg" alt="">
        </div>
        <div class="copyright">
            <p>© Véritable Menuiserie</p>
        </div>
    </footer>

</div>
</body>
</html>