<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bénéfices par période</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f9f9f9; }
        h2 { color: #333; margin-bottom: 20px; }
        .filters { 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            margin-bottom: 30px; 
            display: inline-block; 
            width: 70%;
        }
        .filters label { margin-right: 10px; font-weight: bold; }
        .filters select, .filters button { 
            padding: 10px; 
            font-size: 16px; 
            margin-right: 10px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }
        .filters button { 
            background: #4CAF50; 
            color: white; 
            cursor: pointer; 
            border: none; 
        }
        .filters button:hover { background: #45a049; }
        .section { margin-top: 50px; }
        .section h3 { color: #4CAF50; }
        table { border-collapse: collapse; width: 70%; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #e8f5e9 !important; }
        .current-filter { font-style: italic; color: #666; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Bénéfices par période</h2>

    <!-- Formulaire de filtre -->
    <div class="filters">
        <form method="GET" action="">
            <label for="annee">Année :</label>
            <select name="annee" id="annee">
                <option value="">Toutes</option>
                <?php
                // Récupère les années disponibles (de byDay pour plus de précision)
                $annees = [];
                foreach ($byDay as $row) {
                    $annees[] = substr($row['date_livraison'], 0, 4);
                }
                $annees = array_unique($annees);
                sort($annees);
                foreach ($annees as $y) {
                    $selected = ($_GET['annee'] ?? '') == $y ? 'selected' : '';
                    echo "<option value='$y' $selected>$y</option>";
                }
                ?>
            </select>

            <label for="mois">Mois :</label>
            <select name="mois" id="mois">
                <option value="">Tous</option>
                <?php
                $moisNoms = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                for ($m = 1; $m <= 12; $m++) {
                    $selected = ($_GET['mois'] ?? '') == $m ? 'selected' : '';
                    echo "<option value='$m' $selected>{$moisNoms[$m]}</option>";
                }
                ?>
            </select>

            <label for="jour">Jour :</label>
            <select name="jour" id="jour">
                <option value="">Tous</option>
                <?php for ($d = 1; $d <= 31; $d++) {
                    $selected = ($_GET['jour'] ?? '') == $d ? 'selected' : '';
                    echo "<option value='$d' $selected>$d</option>";
                } ?>
            </select>

            <button type="submit">Filtrer</button>
            <a href="/benefices" style="margin-left: 20px; text-decoration: none; color: #4CAF50;">Réinitialiser</a>
        </form>
    </div>

    <?php
    // Récupération des filtres
    $filtreAnnee = $_GET['annee'] ?? null;
    $filtreMois = $_GET['mois'] ?? null;
    $filtreJour = $_GET['jour'] ?? null;

    // Message du filtre actuel
    if ($filtreAnnee || $filtreMois || $filtreJour) {
        $msg = "Filtre actif : ";
        if ($filtreJour) $msg .= "$filtreJour/";
        if ($filtreMois) {
            $moisNoms = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            $msg .= $moisNoms[(int)$filtreMois] . " ";
        }
        $msg .= $filtreAnnee ?? '';
        echo "<p class='current-filter'>$msg</p>";
    }
    ?>

    <!-- Bénéfices par jour -->
    <div class="section">
        <h3>Bénéfices par jour</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Bénéfice (Ar)</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalDay = 0; $hasData = false; ?>
                <?php foreach ($byDay as $row):
                    $date = $row['date_livraison'];
                    $y = substr($date, 0, 4);
                    $m = ltrim(substr($date, 5, 2), '0');
                    $d = ltrim(substr($date, 8, 2), '0');

                    if ($filtreAnnee && $y != $filtreAnnee) continue;
                    if ($filtreMois && $m != $filtreMois) continue;
                    if ($filtreJour && $d != $filtreJour) continue;

                    $hasData = true;
                    $totalDay += $row['benefice_journalier'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($date))) ?></td>
                        <td><?= number_format($row['benefice_journalier'], 0, ',', ' ') ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if ($hasData): ?>
                    <tr class="total-row">
                        <td>Total</td>
                        <td><?= number_format($totalDay, 0, ',', ' ') ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="2">Aucune donnée pour cette période</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Par mois -->
    <div class="section">
        <h3>Par mois</h3>
        <table>
            <thead>
                <tr>
                    <th>Mois</th>
                    <th>Bénéfice (Ar)</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalMonth = 0; $hasDataMonth = false; ?>
                <?php foreach ($byMonth as $row):
                    $periode = $row['periode']; // ex: 2025-12
                    $y = substr($periode, 0, 4);
                    $m = substr($periode, 5, 2);

                    if ($filtreAnnee && $y != $filtreAnnee) continue;
                    if ($filtreMois && $m != $filtreMois) continue;

                    $hasDataMonth = true;
                    $totalMonth += $row['total_benefice'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['periode_libelle']) ?></td>
                        <td><?= number_format($row['total_benefice'], 0, ',', ' ') ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if ($hasDataMonth): ?>
                    <tr class="total-row">
                        <td>Total</td>
                        <td><?= number_format($totalMonth, 0, ',', ' ') ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="2">Aucune donnée mensuelle pour cette période</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Par année -->
    <div class="section">
        <h3>Par année</h3>
        <table>
            <thead>
                <tr>
                    <th>Année</th>
                    <th>Bénéfice (Ar)</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalYear = 0; $hasDataYear = false; ?>
                <?php foreach ($byYear as $row):
                    if ($filtreAnnee && $row['periode'] != $filtreAnnee) continue;

                    $hasDataYear = true;
                    $totalYear += $row['total_benefice'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['periode']) ?></td>
                        <td><?= number_format($row['total_benefice'], 0, ',', ' ') ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if ($hasDataYear): ?>
                    <tr class="total-row">
                        <td>Total</td>
                        <td><?= number_format($totalYear, 0, ',', ' ') ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="2">Aucune donnée annuelle pour cette période</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>