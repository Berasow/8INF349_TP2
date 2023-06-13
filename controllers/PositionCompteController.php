<?php
// On établit la connexion avec la base de données
$con = mysqli_connect('localhost', 'root');
// On sélectionne la base de données bank
mysqli_select_db($con, 'bank');

// On récupère la valeur de l'input dans le formulaire pour la stocker dans des variables
$idCompte = $_POST['idCompte'];

// Requête pour récupérer la dernière opération du compte dans la table position
$query = "SELECT derniere_operation FROM position WHERE id = '$idCompte'";
$result = mysqli_query($con, $query);

// On vérifie si le nom du compte est vide
if (empty($idCompte)) {
    $response = array(
        'success' => false,
        'message' => "Le nom du compte ne peut pas être vide"
    );
}
// On vérifie si le compte existe
elseif (mysqli_num_rows($result) == 0) {
    $response = array(
        'success' => false,
        'message' => "Le compte n'existe pas"
    );
} else {
    // On récupère la dernière position du compte à partir du résultat de la requête
    $row = mysqli_fetch_assoc($result);
    $derniereOperation = $row['derniere_operation'];

    // On renvoie une réponse "succès" pour qu'elle soit traitée par AJAX
    $response = array(
        'success' => true,
        'derniereOperation' => $derniereOperation
    );
}

// On convertit la réponse au format JSON
echo json_encode($response);

// Fermer la connexion à la base de données
mysqli_close($con);
?>