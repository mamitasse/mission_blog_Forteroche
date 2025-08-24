<table class="monitoring-table">
    <thead>
        <tr>
            <?php 
            // Alterne la direction de tri pour le prochain clic
            $nextDir = $dir === 'ASC' ? 'DESC' : 'ASC'; 

            // Petite fonction pour afficher une flèche si la colonne est active
            function sortArrow($col, $order, $dir) {
                if ($col === $order) {
                    return $dir === 'ASC' ? ' 🔼' : ' 🔽';
                }
                return '';
            }
            ?>
            <th>
                <a href="index.php?action=adminMonitoring&order=title&dir=<?= $nextDir ?>">
                    Titre<?= sortArrow('title', $order, $dir) ?>
                </a>
            </th>
            <th>
                <a href="index.php?action=adminMonitoring&order=date_creation&dir=<?= $nextDir ?>">
                    Création<?= sortArrow('date_creation', $order, $dir) ?>
                </a>
            </th>
            <th>
                <a href="index.php?action=adminMonitoring&order=date_update&dir=<?= $nextDir ?>">
                    Mise à jour<?= sortArrow('date_update', $order, $dir) ?>
                </a>
            </th>
            <th>
                <a href="index.php?action=adminMonitoring&order=views&dir=<?= $nextDir ?>">
                    Vues<?= sortArrow('views', $order, $dir) ?>
                </a>
            </th>
            <th>
                <a href="index.php?action=adminMonitoring&order=comment_count&dir=<?= $nextDir ?>">
                    Commentaires<?= sortArrow('comment_count', $order, $dir) ?>
                </a>
            </th>
        </tr>
    </thead>


    <tbody>
        <?php foreach ($articles as $index => $article): ?>
            <?php
                // ID de l'article courant
                $aid = $article->getId();

                // Est-ce que cet article est "déplié" ? (via GET ?show=<id>)
                $isOpen = isset($showArticleId) && $showArticleId == $aid;
            ?>

            <!-- Ligne principale de l'article, avec alternance de style -->
            <tr class="<?= $index % 2 === 0 ? 'row-even' : 'row-odd' ?>">
                <td><?= htmlspecialchars($article->getTitle()) ?></td>
                <td><?= $article->getDateCreation()->format('Y-m-d H:i') ?></td>
                <td><?= $article->getDateUpdate() ? $article->getDateUpdate()->format('Y-m-d H:i') : '—' ?></td>
                <td><?= $article->getViews() ?></td>
                <td>
                    <!-- Affiche le nombre de commentaires -->
                    <?= $article->getCommentCount() ?>

                    <!-- Lien Voir / Replier -->
                    <?php if ($isOpen): ?>
                        <!-- Si les commentaires sont déjà affichés : bouton Replier -->
                        &nbsp;<a class="btn-view" 
                                 href="index.php?action=adminMonitoring&order=<?= $order ?>&dir=<?= $dir ?>">
                            Replier
                        </a>
                    <?php else: ?>
                        <!-- Sinon : bouton Voir -->
                        &nbsp;<a class="btn-view" 
                                 href="index.php?action=adminMonitoring&order=<?= $order ?>&dir=<?= $dir ?>&show=<?= $aid ?>">
                            Voir
                        </a>
                    <?php endif; ?>
                </td>
            </tr>

            <?php if ($isOpen): ?>
                <!-- Sous-ligne affichée uniquement quand on a cliqué sur "Voir" -->
                <tr class="comment-row">
                    <td colspan="5">
                        <h3>Commentaires :</h3>

                        <?php if (empty($shownComments)): ?>
                            <!-- Aucun commentaire -->
                            <p class="info">Aucun commentaire</p>
                        <?php else: ?>
                            <!-- Liste des commentaires -->
                            <ul class="comment-list">
                                <?php foreach ($shownComments as $c): ?>
                                    <li class="comment-item">
                                        <!-- Auteur + contenu + date -->
                                        <strong><?= htmlspecialchars($c->getPseudo()) ?></strong> :
                                        <?= htmlspecialchars($c->getContent()) ?>
                                        <em>(<?= $c->getDateCreation()->format('Y-m-d H:i') ?>)</em>

                                        <?php if (isset($_SESSION['user'])): ?>
                                            <!-- Bouton suppression visible uniquement si admin connecté -->
                                            <a class="btn-delete"
                                               href="index.php?action=deleteComment&id=<?= $c->getId() ?>"
                                               onclick="return confirm('Supprimer ce commentaire ?')">
                                               🗑 Supprimer
                                            </a>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>

        <?php endforeach; ?>
    </tbody>
</table>
