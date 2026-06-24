<?php
    include('../inc/functions.php');

    $emp_no   = $_GET['emp_no'] ?? '';
    $employee = get_one_employee($emp_no);
    $current  = get_current_department($emp_no);

    $error   = '';
    $success = false;

    // Traitement du formulaire (méthode POST car on modifie la base)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_dept = $_POST['dept_no']   ?? '';
        $start    = $_POST['from_date'] ?? '';

        if ($new_dept === '' || $start === '') {
            $error = "Veuillez choisir un département et une date de début.";
        } elseif ($current && $start < $current['from_date']) {
            // c. Erreur si la date de début est antérieure à celle du département actuel
            $error = "La date de début ($start) ne peut pas être antérieure à celle du département actuel (" . $current['from_date'] . ").";
        } else {
            change_department($emp_no, $new_dept, $start);
            $success = true;
            // a. On recharge le département courant pour vérifier qu'il a bien changé
            $current = get_current_department($emp_no);
        }
    }

    // b. La liste déroulante exclut le département actuel
    $departments = get_departments_except($current ? $current['dept_no'] : '');
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Changer de departement</title>
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



            <?php if (!$employee) { ?>
                <h1 class="alert alert-error" >Employé introuvable</h1>
            <?php } else { ?>
                <h1>Changer le département de <?= $employee['first_name'] ?> <?= $employee['last_name'] ?></h1>

                <hr>
                <br>

                <?php if ($success) { ?>
                    <p style="color:green;">Changement effectué.</p>
                <?php } ?>
                <?php if ($error !== '') { ?>
                    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
                <?php } ?>



                <h2 class="mt">Formulaire</h2>
                <div class="card">
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="first_name">Departement actuelle : </label>
                            <input class="form-control" type="text" id="first_name" value="<?= $current ? $current['dept_name'] . ' (depuis le ' . $current['from_date'] . ')' : 'aucun' ?>" name="first_nam" readonly >
                        </div>
                        <div class="form-group">
                            <label for="gender">Nouveau département : </label>
                            <select class="form-control" id="gender" name="dept_no">
                                <option value="">— Choisir —</option>
                                <?php foreach ($departments as $d) { ?>
                                    <option value="<?= $d['dept_no'] ?>"><?= $d['dept_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hire_date">Date de début : </label>
                            <input class="form-control" type="date" id="hire_date" name="from_date" >
                        </div>
                        <br>
                        <button type="submit" class="btn">Enregistrer</button>
                    </form>
                </div>

                <br>
                <hr>
                <br>



            <?php } ?>


        <br>
        <br>
        <a href="../../" class="btn btn-secondary"><- Quiter</a>



        </div>



    </body>
</html>