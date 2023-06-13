<?php include '../templates/header.php' ?>

<h1>Ajouter de l'argent</h1>
<div class="content">
    <form action="../controllers/AjouterArgentController.php" method="post" id="ajouterArgentForm" class="shadow p-4 rounded">
        <div class="form-group">
            <label for="idCompte">Nom du compte</label>
            <input type="text" name="idCompte" class="form-control bg-dark text-white">
            <div class="error-message-id text-danger"></div>
        </div>
        <div class="form-group">
            <label for="montant">Montant</label>
            <input type="text" name="montant" class="form-control bg-dark text-white">
            <div class="error-message-argent text-danger"></div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Valider</button>
    </form>
    <a href="index.php" class="btn btn-outline-danger mt-5">Retour</a>
</div>

<div class="modal" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Action réussie</h5>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="closeModalButton">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#ajouterArgentForm').submit(function (e) {
            e.preventDefault(); // Empêcher la soumission normale du formulaire

            // Récupération des valeurs des champs du formulaire
            var idCompte = $('input[name="idCompte"]').val();
            var argent = $('input[name="montant"]').val();

            // Effacement des messages d'erreur précédents
            $('.error-message-id').empty();
            $('.error-message-argent').empty();

            // Requête AJAX
            $.ajax({
                url: "../controllers/AjouterArgentController.php",
                type: "POST",
                data: $('#ajouterArgentForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success === false) {
                        // Si la réponse indique une erreur

                        if (response.message.includes("nom du compte") || response.message.includes("n'existe")) {
                            // Si le message d'erreur concerne l'absence de texte dans l'input ou l'inexistence du compte
                            $('.error-message-id').text(response.message);
                        } else {
                            // Sinon, le message d'erreur concerne le montant
                            $('.error-message-argent').text(response.message);
                        }
                    } else {
                        // Si la réponse indique une réussite

                        // Affichage du message de succès dans un modal
                        $('#successMessage').text(response.message);
                        $('#successModal').modal('show');
                    }
                },
                error: function (xhr, status, error) {
                    // Callback en cas d'erreur de la requête
                    console.log(xhr.responseText);
                }
            });
        });

        // Action lors du clic sur le bouton de fermeture du modal de succès
        $('#closeModalButton').on('click', function () {
            window.location.href = "../views/index.php";
        });
    });
</script>


<?php include '../templates/footer.php' ?>
