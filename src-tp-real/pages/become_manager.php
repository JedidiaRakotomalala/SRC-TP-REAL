<?php
    include('../inc/functions.php');

    $emp_no   = $_GET['emp_no'] ?? '';
    $employee = get_one_employee($emp_no);
    $current_dept = get_current_department($emp_no);   // département dont il deviendra manager

    $error   = '';
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $current_dept) {
        $start = $_POST['from_date'] ?? '';
        $manager = get_current_manager($current_dept['dept_no']);

        if ($start === '') {
            $error = "Veuillez saisir une date de début.";
        } elseif ($manager && $start < $manager['from_date']) {
            // c. Erreur si la date est antérieure à celle du manager actuel
            $error = "La date de début ($start) ne peut pas être antérieure à celle du manager actuel (" . $manager['from_date'] . ").";
        } else {
            make_manager($emp_no, $current_dept['dept_no'], $start);
            $success = true;
        }
    }

    // b. Manager en cours (rechargé après un éventuel changement pour vérifier)
    $manager = $current_dept ? get_current_manager($current_dept['dept_no']) : null;
?>
<html>
    <head>
        <title>Devenir manager</title>
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
        <p><a href="fiche.php?emp_no=<?= urlencode($emp_no) ?>" class="btn">&larr; Retour à la fiche</a></p>

        <?php if (!$employee) { ?>
            <h1>Employé introuvable</h1>
        <?php } elseif (!$current_dept) { ?>
            <h1>Cet employé n'a pas de département actuel.</h1>
        <?php } else { ?>
            <h1><?= $employee['first_name'] ?> <?= $employee['last_name'] ?> — devenir manager de <?= $current_dept['dept_name'] ?></h1>

            <?php if ($success) { ?>
                <p style="color:green;">C'est fait : l'employé est désormais le manager du département.
                   <a href="index.php">Vérifier dans la liste des départements &rarr;</a></p>
            <?php } ?>
            <?php if ($error !== '') { ?>
                <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php } ?>

            <h2 class="mt">Formulaire</h2>
            <div class="card">
                <p><strong>Manager en cours :</strong>
                    <?= $manager ? $manager['manager_name'] . ' (depuis le ' . $manager['from_date'] . ')' : 'aucun' ?>
                <!-- b. Manager en cours affiché en haut -->
                </p>

                <form method="post" action="become_manager.php?emp_no=<?= urlencode($emp_no) ?>">
                    <div class="form-group">
                        <label for="from_date">Date de début</label>
                        <input class="form-control" type="date" id="from_date" name="from_date">
                    </div>
                    <input type="submit" class="btn" value="Devenir manager">
                </form>
            </div>
        <?php } ?>
        </div>

    </body>
</html>
