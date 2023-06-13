<?php include '../templates/header.php' ?>

<h1>Créer un compte</h1>
<div class="content">
    <form action="../controllers/CreerCompteController.php" method="post" id="creerCompteForm" class="shadow p-4 rounded">
        <div class="mb-3">
            <label for="idCompte" class="form-label">Nom du compte</label>
            <input type="text" name="idCompte" class="form-control bg-dark text-white">
            <div class="error-message-id text-danger"></div>
        </div>
        <div class="mb-3">
            <label for="argent" class="form-label">Montant de départ</label>
            <input type="text" name="argent" class="form-control bg-dark text-white">
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
        $('#creerCompteForm').submit(function (e) {
            e.preventDefault(); // Empêcher la soumission normale du formulaire

            // Récupérer les valeurs des champs
            var idCompte = $('input[name="idCompte"]').val();
            var argent = $('input[name="argent"]').val();

            // Réinitialiser les messages d'erreur
            $('.error-message-id').empty();
            $('.error-message-argent').empty();

            // Envoyer la requête AJAX
            $.ajax({
                url: "../controllers/CreerCompteController.php",
                type: "POST",
                data: $('#creerCompteForm').serialize(),
                dataType: 'json', // Définir le type de données attendu pour la réponse
                success: function (response) {
                    // Gérer la réponse du serveur
                    if (response.success === false) {
                        if (response.message.includes("nom du compte") || response.message.includes("existant")) {
                            $('.error-message-id').text(response.message);
                        } else {
                            $('.error-message-argent').text(response.message);
                        }
                    } else {
                        $('#successMessage').text(response.message);
                        $('#successModal').modal('show');
                    }
                },
                error: function (xhr, status, error) {
                    // Gérer les erreurs de la requête AJAX
                    console.log(xhr.responseText);
                }
            });
        });

        $('#closeModalButton').on('click', function () {
            window.location.href = "../views/index.php";
        });
    });
</script>

<?php include '../templates/footer.php' ?>
