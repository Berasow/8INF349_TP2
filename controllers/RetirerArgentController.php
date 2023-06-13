<?php
// On établit la connexion avec la base de données
$con = mysqli_connect('localhost', 'root');
// On sélectionne la base de données bank
mysqli_select_db($con, 'bank');

// On récupère les valeurs des inputs dans le formulaire pour les stocker dans des variables
$id = $_POST['idCompte'];
$montant = $_POST['montant'];

// On effectue une requête de "test" pour vérifier certaines conditions puis on stocke le résultat dans une variable
$queryTest = "SELECT * FROM account WHERE id = '$id'";
$result = mysqli_query($con, $queryTest);

// On vérifie si le champ "idCompte" est vide
if (empty($id)) {
    $response = array(
        'success' => false,
        'message' => "Le nom du compte ne peut pas être vide"
    );
    echo json_encode($response);
    exit();
}
// On vérifie si le compte existe dans la base de données
elseif (mysqli_num_rows($result) == 0) {
    $response = array(
        'success' => false,
        'message' => "Le compte n'existe pas"
    );
    echo json_encode($response);
    exit();
}
// On vérifie si le champ "montant" est strictement supérieur à zéro
elseif ($montant <= 0) {
    $response = array(
        'success' => false,
        'message' => "Le montant ne peut pas être inférieur à zéro"
    );
    echo json_encode($response);
    exit();
}
// Si tous les tests sont passés, alors on ajoute les valeurs en base de données
else {
    // On récupère la somme d'argent actuelle associée au compte
    $querySelect = "SELECT somme_argent FROM account WHERE id = '$id'";
    $resultSelect = mysqli_query($con, $querySelect);
    $row = mysqli_fetch_assoc($resultSelect);
    $sommeActuelle = $row['somme_argent'];

    // On vérifie que le montant retiré n'est pas supérieur à la somme actuelle du compte
    if ($montant > $sommeActuelle) {
        $response = array(
            'success' => false,
            'message' => "Le montant à retirer est supérieur à la somme disponible sur le compte"
        );
        echo json_encode($response);
        exit();
    }

    // On calcule la nouvelle somme en ajoutant le montant spécifié
    $nouvelleSomme = $sommeActuelle - $montant;

    // On met à jour la valeur de la somme d'argent pour le compte spécifié
    $query = "UPDATE account SET somme_argent = '$nouvelleSomme' WHERE id = '$id'";
    mysqli_query($con, $query);

    // On met à jour la date de dernière opération dans la table "position"
    $date = date('Y-m-d H:i:s');
    mysqli_query($con, "UPDATE position SET derniere_operation = '$date' WHERE id = '$id'");

    // On renvoie une réponse "succès" pour qu'elle soit traitée par AJAX
    $response = array(
        'success' => true,
        'message' => "L'argent a été retiré avec succès."
    );
    echo json_encode($response);
    exit();
}
?>