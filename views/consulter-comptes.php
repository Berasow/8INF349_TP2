<?php include '../templates/header.php' ?>

<h1>Consulter mes comptes</h1>
<div class="content">
    <div class="table-responsive w-50" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
        <table class="table table-dark table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Somme d'argent</th>
                <th>Date de création</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $con = mysqli_connect('localhost', 'root');
            mysqli_select_db($con, 'bank');

            $query = "SELECT * FROM account";
            $result = mysqli_query($con, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $sommeArgent = $row['somme_argent'];
                $date = $row['date_creation'];

                echo "<tr>";
                echo "<td>$id</td>";
                echo "<td>$sommeArgent €</td>";
                echo "<td>$date</td>";
                echo "</tr>";
            }

            mysqli_close($con);
            ?>
            </tbody>
        </table>
    </div>
    <a href="index.php" class="btn btn-outline-danger mt-5">Retour</a>
</div>

<?php include '../templates/footer.php' ?>