<?php
function jour_1_activites($activite) {

    // Récupération de l'ID utilisateur
    if(isset($_SESSION['id'])) {
      $user_id = $_SESSION['id'];
    } else {
      header('Location: login.php');
    }

    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=gypsy', 'admin', '8378Ff++');

    // Préparation de la requête SQL pour les créneaux
    $stmt = $pdo->prepare('SELECT id, creneau FROM jour_1_creneaux_horaires WHERE activite = :activite ORDER BY ordre ASC');

    // Exécution de la requête avec les paramètres
    $stmt->execute(['activite' => $activite]);

    // Récupération des résultats sous forme de tableau
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des résultats
    foreach ($resultats as $resultat) {
        $creneau_id = $resultat['id'];
        $creneau = $resultat['creneau'];
        $activite_creneau = explode(" - ", $creneau);
        $activite = trim($activite_creneau[0]);
        $creneau_horaire = trim($activite_creneau[1]);

        // Requête SQL pour compter le nombre de bénévoles inscrits sur l'activité et le créneau horaire donnés
        $query = "SELECT COUNT(*) AS nb_benevoles FROM jour_1_benevole_activite_creneau WHERE activite_creneau_id = $creneau_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$activite, $creneau_horaire]);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $nb_benevoles = $resultat['nb_benevoles'];

        $stmt = $pdo->prepare($query);
        $stmt->execute([$activite, $creneau_horaire]);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $nb_benevoles = $resultat['nb_benevoles'];

        // Requête SQL pour vérifier si l'utilisateur est déjà inscrit sur cette tâche
        $query_deja_inscrit = "SELECT COUNT(*) AS nb_inscriptions FROM jour_1_benevole_activite_creneau WHERE activite_creneau_id = $creneau_id AND benevole_id = $user_id";
        $stmt_deja_inscrit = $pdo->prepare($query_deja_inscrit);
        $stmt_deja_inscrit->execute();
        $resultat_deja_inscrit = $stmt_deja_inscrit->fetch(PDO::FETCH_ASSOC);
        $est_deja_inscrit = $resultat_deja_inscrit['nb_inscriptions'] > 0;

        // Affichage du résultat avec le nombre de bénévoles inscrits
        if ($est_deja_inscrit) {
            echo '<a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-green text-white" data-id="' . $creneau_id . '" onclick="envoyerRequeteJour1(' . $user_id . ', ' . $creneau_id . ')">' . $creneau . ' <span style="float:right;">' . $nb_benevoles . '/3</span></a>';
        } else {
            if ($nb_benevoles >= 3){
                echo '<a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-rouge text-white" data-id="' . $creneau_id . '">' . $creneau . ' COMPLET <span style="float:right;">' . $nb_benevoles . '/3</span></a>';
            } else {
                echo '<a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-info text-white" data-id="' . $creneau_id . '" onclick="envoyerRequeteJour1(' . $user_id . ', ' . $creneau_id . ')">' . $creneau . '<span style="float:right;">' . $nb_benevoles . '/3</span></a>';
            }
        }



    }
}

function jour_2_activites($activite) {

    // Récupération de l'ID utilisateur
    if(isset($_SESSION['id'])) {
      $user_id = $_SESSION['id'];
    } else {
      header('Location: login.php');
    }

    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=gypsy', 'admin', '8378Ff++');

    // Préparation de la requête SQL pour les créneaux
    $stmt = $pdo->prepare('SELECT id, creneau FROM jour_2_creneaux_horaires WHERE activite = :activite ORDER BY ordre ASC');

    // Exécution de la requête avec les paramètres
    $stmt->execute(['activite' => $activite]);

    // Récupération des résultats sous forme de tableau
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des résultats
    foreach ($resultats as $resultat) {
        $creneau_id = $resultat['id'];
        $creneau = $resultat['creneau'];
        $activite_creneau = explode(" - ", $creneau);
        $activite = trim($activite_creneau[0]);
        $creneau_horaire = trim($activite_creneau[1]);

        // Requête SQL pour compter le nombre de bénévoles inscrits sur l'activité et le créneau horaire donnés
        $query = "SELECT COUNT(*) AS nb_benevoles FROM jour_2_benevole_activite_creneau WHERE activite_creneau_id = $creneau_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$activite, $creneau_horaire]);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $nb_benevoles = $resultat['nb_benevoles'];

        // Requête SQL pour vérifier si l'utilisateur est déjà inscrit sur cette tâche
        $query_deja_inscrit = "SELECT COUNT(*) AS nb_inscriptions FROM jour_2_benevole_activite_creneau WHERE activite_creneau_id = $creneau_id AND benevole_id = $user_id";
        $stmt_deja_inscrit = $pdo->prepare($query_deja_inscrit);
        $stmt_deja_inscrit->execute();
        $resultat_deja_inscrit = $stmt_deja_inscrit->fetch(PDO::FETCH_ASSOC);
        $est_deja_inscrit = $resultat_deja_inscrit['nb_inscriptions'] > 0;


        // Affichage du résultat avec le nombre de bénévoles inscrits
        if ($est_deja_inscrit) {
            echo '<a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-green text-white" data-id="' . $creneau_id . '" onclick="envoyerRequeteJour2(' . $user_id . ', ' . $creneau_id . ')">' . $creneau . '<span style="float:right;">' . $nb_benevoles . '/3</span></a>';
        } else {
            if ($nb_benevoles >= 3){
                echo '<a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-rouge text-white" data-id="' . $creneau_id . '">' . $creneau . ' COMPLET <span style="float:right;">' . $nb_benevoles . '/3</span></a>';
            } else {
                echo '<a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-info text-white" data-id="' . $creneau_id . '" onclick="envoyerRequeteJour2(' . $user_id . ', ' . $creneau_id . ')">' . $creneau . '<span style="float:right;">' . $nb_benevoles . '/3</span></a>';
            }
        }
    }
}

// Ajout d'un script JavaScript pour envoyer une requête AJAX au même fichier PHP avec les paramètres
echo '<script>
function envoyerRequeteJour1(benevole_id, activite_creneau_id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./scripts/enregistrer_benevole_activite_jour_1.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Traitement de la réponse du serveur
            console.log(this.responseText);
            location.reload()
        }
    }
    xhr.send("benevole_id=" + benevole_id + "&activite_creneau_id=" + activite_creneau_id);
}
function envoyerRequeteJour2(benevole_id, activite_creneau_id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./scripts/enregistrer_benevole_activite_jour_2.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Traitement de la réponse du serveur
            console.log(this.responseText);
            location.reload()
        }
    }
    xhr.send("benevole_id=" + benevole_id + "&activite_creneau_id=" + activite_creneau_id);
    element_a.innerHTML = this.responseText;
}
</script>';
?>
<?php include('menu.php'); ?>
<!DOCTYPE html>
<html>
      <header>
         <meta charset="utf-8" />
         <title>Bénévoles Gypsy Camp 2023 - Planning</title>
         <link rel="stylesheet" href="planning-style.css">
      </header>
      <body>
       <div class="container-fluid">
         <h1>Bénévoles Gypsy Camp 2023</h1>
         <h2>Planning</h2>
         <div class="row day-border d-none d-sm-flex p-1 bg-dark text-white day-border">
            <h5 class="col-sm p-1 text-center">Vendredi</h5>
            <h5 class="col-sm p-1 text-center">Samedi</h5>
         </div>
         <!-- première ligne -->
         <div class="row border border-right-0 border-bottom-0">
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Entrée</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_1_activites('Entree');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Jetons</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_1_activites('Jetons');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Bar</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_1_activites('Bar');
                  ?>
            </div>
            <div class="day col-sm p-2 box-border border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Entrée</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_2_activites('Entree');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Jetons</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_2_activites('Jetons');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Bar</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_2_activites('Bar');
                  ?>
            </div>
         </div>
         <!-- fin première ligne -->
         <!-- deuxième ligne -->
         <div class="row border border-right-0 border-bottom-0">
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Parking</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_1_activites('Parking');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Route Parking</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_1_activites('Route Parking');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Route Fontaine</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_1_activites('Route Fontaine');
                  ?>
            </div>
            <div class="day col-sm p-2 box-border border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Parking</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_2_activites('Parking');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Route Parking</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_2_activites('Route Parking');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Route Fontaine</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_2_activites('Route Fontaine');
                  ?>
            </div>
            <div class="w-100"></div>
         </div>
         <!-- fin deuxieme ligne -->
         <div class="row border border-right-0 border-bottom-0">
            <!-- troisieme ligne -->
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Camping</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_1_activites('Camping');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <!--Empty-->
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <!--Empty-->
            </div>
            <div class="day col-sm p-2 box-border border-top-0 text-truncate ">
               <h5 class="row align-items-center">
                  <span class="date col-1">Camping</span>
                  <small class="col d-sm-none text-center text-muted"></small>
                  <span class="col-1"></span>
               </h5>
               <?php
                  jour_2_activites('Camping');
                  ?>
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <!--Empty-->
            </div>
            <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
               <!--Empty-->
            </div>
         </div>
         <!-- fin troisieme ligne -->
         <div id="myModal" class="modal">
           <div class="modal-content">
             <span class="close">&times;</span>
             <p id="error-message"></p>
           </div>
         </div>
      </body>
</html>
