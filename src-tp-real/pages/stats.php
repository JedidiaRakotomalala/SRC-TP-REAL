<?php
    include('../inc/functions.php');
    $stats = get_jobs_stats();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Statistiques par emploi </title>
        <link rel="stylesheet" href="../design/theme-dark/style.css">
    </head>
    <body>

        <nav class="navbar">
            <ul>
                <li class="brand">Employés DB</li>
                <li><a href="index.php">Départements</a></li>
                <li><a href="search.php">Rechercher un employé</a></li>
                <li><a href="dept_form.php">➕ Ajouter un département</a></li>
                <li><a href="emp_form.php">➕ Ajouter un employé</a></li>
                <li><a href="stats.php" class="active" >Statistiques</a></li>
            </ul>
        </nav>
    

    <div class="container">

        <h1>Les statistiques :</h1>

        <hr>
        <br>


        <h2 class="mt">Statistiques par emploi</h2>
        <br>
        <table class="table">
            <thead>
                <th>Emploi</th>
                <th>Hommes</th>
                <th>Femmes</th>
                <th>Total</th>
                <th>Salaire moyen</th>
            </thead>
            <tbody>
                <?php foreach ($stats as $row) { ?>
                    <tr>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['nb_hommes'] ?></td>
                        <td><?= $row['nb_femmes'] ?></td>
                        <td><?= $row['nb_total'] ?></td>
                        <td><?= number_format($row['salaire_moyen'], 0, ',', ' ') ?> €</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br>
        <br>
        <a href="../../" class="btn btn-secondary"><- Quiter</a>

    </div>


    </body>
</html>
