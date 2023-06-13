<?php include '../templates/header.php' ?>

<h1>Retirer de l'argent</h1>
<div class="content">
    <form action="../controllers/RetirerArgentController.php" method="post" id="retirerArgentForm" class="shadow p-4 rounded">
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
    $(document).ready(function() {
        $('#retirerArgentForm').submit(function(e) {
            e.preventDefault(); // Empêcher la soumission normale du formulaire

            // Récupération des valeurs des champs idCompte et montant
            var idCompte = $('input[name="idCompte"]').val();
            var argent = $('input[name="montant"]').val();

            // Suppression des messages d'erreur
            $('.error-message-id').empty();
            $('.error-message-argent').empty();

            // Requête AJAX
            $.ajax({
                url: "../controllers/RetirerArgentController.php",
                type: "POST",
                data: $('#retirerArgentForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success === false) {
                        // Si la réponse indique une erreur

                        if (response.message.includes("nom du compte") || response.message.includes("existe")) {
                            // Si le message d'erreur concerne l'absence de texte dans l'input ou l'inexistence du compte
                            $('.error-message-id').text(response.message);
                        } else {
                            // Sinon, l'erreur concerne le montant
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

        $('#closeModalButton').on('click', function () {
            // Gestion de l'événement clic sur le bouton de fermeture de la fenêtre modal
            window.location.href = "../views/index.php";
        });
    });
</script>


<?php include '../templates/footer.php' ?>
