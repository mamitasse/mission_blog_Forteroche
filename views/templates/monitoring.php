<?php
    /**
     * Template de la page de monitoring du blog.
     * Affiche un tableau récapitulatif de tous les articles avec plusieurs informations :
     *  - le titre de l'article,
     *  - le nombre de vues,
     *  - le nombre de commentaires,
     *  - la date de publication.
     *
     * Les colonnes sont cliquables afin de trier les données par ordre croissant ou décroissant.
     * Le tri est contrôlé via les paramètres `sort` et `order` de l'URL.
     * Les variables suivantes doivent être définies :
     *  - $articlesData : tableau d'articles enrichi des informations de vues et de commentaires.
     *  - $sort : la colonne actuellement triée.
     *  - $order : l'ordre actuel ("asc" ou "desc").
     */
?>

<h2>Monitoring du blog</h2>

<div class="monitoringWrapper">
    <table class="monitoringTable">
        <thead>
            <tr>
                <?php
                // Préparation d'un tableau permettant d'associer des labels conviviaux aux clés de tri.
                $columns = [
                    'title' => 'Titre',
                    'views' => 'Vues',
                    'comments' => 'Commentaires',
                    'date' => 'Date de publication'
                ];
                foreach ($columns as $columnKey => $label) {
                    // Détermine l'ordre à appliquer lors du prochain clic.
                    $newOrder = ($sort === $columnKey && $order === 'asc') ? 'desc' : 'asc';
                    // Affiche une flèche montante ou descendante uniquement pour la colonne en cours de tri.
                    $arrow = '';
                    if ($sort === $columnKey) {
                        $arrow = $order === 'asc' ? ' ▲' : ' ▼';
                    }
                    $url = 'index.php?action=monitoring&sort=' . $columnKey . '&order=' . $newOrder;
                    echo '<th><a href="' . $url . '" class="sortable">' . $label . $arrow . '</a></th>';
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articlesData as $data) { ?>
                <tr>
                    <td><?= htmlspecialchars($data['title']) ?></td>
                    <td><?= (int) $data['views'] ?></td>
                    <td><?= (int) $data['comments'] ?></td>
                    <td><?= Utils::convertDateToFrenchFormat($data['date']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>