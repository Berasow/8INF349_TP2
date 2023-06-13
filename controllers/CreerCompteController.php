<?php
// On établit la connexion avec la base de données
$con = mysqli_connect('localhost', 'root');
// On sélectionne la base de données bank
mysqli_select_db($con, 'bank');

// On récupère les valeurs des inputs dans le formulaire pour les stocker dans des variables
$id = $_POST['idCompte'];
$argent = $_POST['argent'];

// Vérifier si le compte existe déjà
$queryTest = "SELECT * FROM account WHERE id = '$id'";
$result = mysqli_query($con, $queryTest);

// On vérifie si le nom du compte est vide
if (empty($id)) {
    $response = array(
        'success' => false,
        'message' => "Le nom du compte ne peut pas être vide"
    );
    echo json_encode($response);
    exit();
}
// On vérifie si le compte existe déjà dans la table "account"
elseif (mysqli_num_rows($result) > 0) {
    $response = array(
        'success' => false,
        'message' => "Compte déjà existant"
    );
    echo json_encode($response);
    exit();
}
// Vérifier si le montant est positif et supérieur à zéro
elseif ($argent <= 0) {
    $response = array(
        'success' => false,
        'message' => "Le montant doit être strictement positif et supérieur à zéro"
    );
    echo json_encode($response);
    exit();
} else {
    // Obtenir la date et l'heure actuelle
    $dateCreation = date('Y-m-d H:i:s');

    // On insère les valeurs dans la table "account"
    $query = "INSERT INTO account (id, somme_argent, date_creation) VALUES ('$id', '$argent', '$dateCreation');";
    mysqli_query($con, $query);

    // On insère l'id du compte dans la table "position"
    $queryInsertPosition = "INSERT INTO position (id) VALUES ('$id');";
    mysqli_query($con, $queryInsertPosition);

    // On renvoie une réponse "succès" pour qu'elle soit traitée par AJAX
    $response = array(
        'success' => true,
        'message' => "Le compte a été créé avec succès."
    );
    echo json_encode($response);
    exit();
}
?>