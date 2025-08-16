<table class="monitoring-table">
    <thead>
        <tr>
            <?php $nextDir = $dir === 'ASC' ? 'DESC' : 'ASC'; ?>
            <th><a href="index.php?action=adminMonitoring&order=title&dir=<?= $nextDir ?>">Titre</a></th>
            <th><a href="index.php?action=adminMonitoring&order=date_creation&dir=<?= $nextDir ?>">Création</a></th>
            <th><a href="index.php?action=adminMonitoring&order=date_update&dir=<?= $nextDir ?>">Mise à jour</a></th>
            <th><a href="index.php?action=adminMonitoring&order=views&dir=<?= $nextDir ?>">Vues</a></th>
            <th><a href="index.php?action=adminMonitoring&order=comment_count&dir=<?= $nextDir ?>">Commentaires</a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $index => $article): ?>
            <?php
                $aid = $article->getId();
                $isOpen = isset($showArticleId) && $showArticleId == $aid;
            ?>
            <tr class="<?= $index % 2 === 0 ? 'row-even' : 'row-odd' ?>">
                <td><?= htmlspecialchars($article->getTitle()) ?></td>
                <td><?= $article->getDateCreation()->format('Y-m-d H:i') ?></td>
                <td><?= $article->getDateUpdate() ? $article->getDateUpdate()->format('Y-m-d H:i') : '—' ?></td>
                <td><?= $article->getViews() ?></td>
                <td>
                    <?= $article->getCommentCount() ?>
                    &nbsp;<a class="btn-view" href="index.php?action=adminMonitoring&order=<?= $order ?>&dir=<?= $dir ?>&show=<?= $aid ?>">Voir</a>
                </td>
            </tr>

            <?php if ($isOpen): ?>
                <tr class="comment-row">
                    <td colspan="5">
                        <h3>Commentaires :</h3>
                        <?php if (empty($shownComments)): ?>
                            <p class="info">Aucun commentaire</p>
                        <?php else: ?>
                            <ul class="comment-list">
                                <?php foreach ($shownComments as $c): ?>
                                    <li class="comment-item">
                                        <strong><?= htmlspecialchars($c->getPseudo()) ?></strong> :
                                        <?= htmlspecialchars($c->getContent()) ?>
                                        <em>(<?= $c->getDateCreation()->format('Y-m-d H:i') ?>)</em>
                                        <?php if (isset($_SESSION['user'])): ?>
                                            <a class="btn-delete"
                                               href="index.php?action=deleteComment&id=<?= $c->getId() ?>"
                                               onclick="return confirm('Supprimer ce commentaire ?')">🗑 Supprimer</a>
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
