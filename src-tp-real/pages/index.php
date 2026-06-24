<?php
    include('../inc/functions.php');
    $departments = get_all_departments();

?>		
<html>
    <head>
        <meta charset="utf-8">
        <title>Les news</title>
        <link rel="stylesheet" href="../design/theme-dark/style.css">
    </head>
    <body>


        <nav class="navbar">
            <ul>
                <li class="brand">Employés DB</li>
                <li><a href="index.php" class="active">Départements</a></li>
                <li><a href="search.php">Rechercher un employé</a></li>
                <li><a href="dept_form.php">➕ Ajouter un département</a></li>
                <li><a href="emp_form.php">➕ Ajouter un employé</a></li>
                <li><a href="stats.php">Statistiques</a></li>
            </ul>
        </nav>
    

    <div class="container">
        <h1>Les departements : </h1>
        <hr>
        <h2>Tableau</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom du département</th>
                    <th>Manager actuel</th>
                    <th>Nb employés</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $line) {?>
                    <tr>
                        <td><a href="employees.php?dept_no=<?= urlencode($line['dept_no']) ?>"><?= $line['dept_no']?></a></td>
                        <td><?=$line['dept_name']?></td>
                        <td><?= $line['manager_name'] ?? '—' ?></td>
                        <td><?= $line['nb_employees'] ?></td>
                        <td><a href="dept_form.php?dept_no=<?= urlencode($line['dept_no']) ?>">Éditer</a></td>
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
