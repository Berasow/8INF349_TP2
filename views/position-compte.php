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

            var idCompte = $('input[name="idCompte"]').val();

            $.ajax({
                url: "../controllers/PositionCompteController.php",
                type: "POST",
                data: $('#positionCompteForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success === true) {
                        var derniereOperation = response.derniereOperation;
                        var resultat = 'Dernière opération du compte ' + idCompte + ' : ';

                        if (derniereOperation == null) {
                            resultat += "Aucune action réalisée dernièrement";
                        } else {
                            resultat += derniereOperation;
                        }

                        $('#erreurPosition').text("");
                        $('#resultatPosition').text(resultat);
                    } else {
                        $('#resultatPosition').text("");
                        $('#erreurPosition').text(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

<?php include '../templates/footer.php' ?>