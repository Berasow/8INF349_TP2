<?php include '../templates/header.php' ?>

<h1>Position d'un compte</h1>
<div class="content">
    <form action="../controllers/PositionCompteController.php" method="post" id="positionCompteForm" class="shadow-lg p-4 rounded">
        <div class="form-group">
            <label for="idCompte">Nom du compte</label>
            <input type="text" name="idCompte" class="form-control bg-dark text-white">
            <div id="erreurPosition" class="mt-2 text-danger"></div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Valider</button>
    </form>
    <div id="resultatPosition" class="mt-2"></div>
    <a href="index.php" class="btn btn-outline-danger mt-5">Retour</a>
</div>

<script>
    $(document).ready(function() {
        $('#positionCompteForm').submit(function(e) {
            e.preventDefault(); // Empêcher la soumission normale du formulaire

            // Récupération de la valeur du champ idCompte
            var idCompte = $('input[name="idCompte"]').val();

            $('#resultatPosition').empty();
            $('#erreurPosition').empty();

            // Requête AJAX
            $.ajax({
                url: "../controllers/PositionCompteController.php",
                type: "POST",
                data: $('#positionCompteForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success === true) {
                        // Si la réponse indique une réussite

                        var derniereOperation = response.derniereOperation;
                        var resultat = 'Dernière opération du compte ' + idCompte + ' : ';

                        if (derniereOperation == null) {
                            // Si aucune opération récente n'est disponible
                            resultat += "Aucune action réalisée dernièrement";
                        } else {
                            // Sinon, afficher la dernière opération
                            resultat += derniereOperation;
                        }

                        // Affichage du résultat
                        $('#resultatPosition').text(resultat);
                    } else {
                        // Si la réponse indique une erreur

                        // Affichage du message d'erreur
                        $('#erreurPosition').text(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Callback en cas d'erreur de la requête
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

<?php include '../templates/footer.php' ?>