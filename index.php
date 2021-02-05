<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta description="Site Vapeur Douce, aide mémoire du livre Plats gourmands, Vapeur Douce de Stéphane Gabrielly">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@https://alescity30.000webhostapp.com/">
    <meta name="twitter:creator" content="@twitter">
    <meta name="twitter:title" content="Vapeur Douce">
    <meta name="twitter:description" content="Site Vapeur Douce, aide mémoire du livre Plats gourmands, Vapeur Douce de Stéphane Gabrielly">
    <meta name="twitter:image" content="img/couvertureLivre.png">
    <meta property="og:url" content="https://alescity30.000webhostapp.com/"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Vapeur Douce" />
    <meta property="og:description" content="Site Vapeur Douce, aide mémoire du livre Plats gourmands, Vapeur Douce de Stéphane Gabrielly" />
    <meta property="og:image" content="img/couvertureLivre.png" />
    <link rel="stylesheet" href="style.css">

    <title>Vapeur Douce</title>
</head>
<body>
    <header>
        <img src='img/logoVapDouce.png'>
        <h1>VAPEUR DOUCE</h1>
    </header>
    <main>
        <form action="" method="POST">
            <label for="search" id='aliment'>Aliment</label>
            <input type="text" id="search" name="search" minlength="3" maxlength="30"> <!--Je limite le nombre d'entrées-->
            <input type="submit" id="ok" value="OK">
        </form>
        <?php

            if (isset($_POST['search'])) { // Vérifie si la variable est déclarée 
            
            $search = htmlspecialchars(ucfirst($_POST['search']), ENT_QUOTES); // Variable aliment saisi dans formulaire + sécurité de l'entrée
            $search = str_replace(' ', '+', $search);
            $search = str_replace('-', '+', $search);
            $search = strtolower($search);// J'enlève les majusules
            $search = ucfirst ($search);// Je mets la 1ère lettre en majuscule
          
            $curl = curl_init(); // Fonction activation l'url 
            
            curl_setopt_array($curl, [ // Paramétrage session curl
                CURLOPT_URL => "https://api.hmz.tf/?id=$search", // Je récupère l'url 
                CURLOPT_RETURNTRANSFER => true, // Retourne une chaine de caractère
                CURLOPT_TIMEOUT => 1, // Durée attente avant réponse du serveur
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // Force l'http/1.1
            ]);
            
            $resultat = curl_exec($curl); // Exécute la session curl
            $resultat = json_decode($resultat, true); // Décodage du fichier json
            
            $status = $resultat['status'];

            if ($status === "error") { // Je vérifie que l'aliment existe dans le tableau
                echo "<div class='error'>",
                "<p> Bientôt un tome 2... </p>",
                "</div>";

            } else {
                   
                echo "<div class='resultat'>",
                     "<h2>" . $resultat['message']['nom'] . "</h2>"; // J'affiche l'aliment
                
            if (array_key_exists('trempage', $resultat['message']['vapeur'])) { // Condition pour vérifer si trempage existe dans le tableau 
                        echo '<p> Trempage : ' . $resultat['message']['vapeur']['trempage'] . '</p>'; // Affiche la valeur du trempage
                    
            } else {
                 echo '<p> Pas de temps de trempage </p>'; // echo différent si pas de trempage
            }
                
            if (array_key_exists('niveau d\'eau', $resultat['message']['vapeur'])) { // Condition pour vérifer si niveau d'eau existe dans le tableau 
                        echo '<p> Niveau d\'eau : ' . $resultat['message']['vapeur']['niveau d\'eau'] . '</p>'; // Affiche la valeur du niveau d'eau
                    
            } else {
                echo '<p> Niveau d\'eau : 0 </p>'; // echo différent si pas de niveau d'eau 
            }
                
                echo "<p> Cuisson : " . $resultat['message']['vapeur']['cuisson'] . "</p></div>"; // J'affiche la cuisson
            }

            curl_close($curl); // Ferme la session curl
            }
        ?>

    </main>
</body>

</html>
