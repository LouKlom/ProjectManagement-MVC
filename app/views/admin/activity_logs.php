<?php ob_start(); ?>

<h1>Historique d'activité</h1>

<?php if (!empty($logs)): ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Utilisateur</th>
                <th>Type d'action</th>
                <th>Description</th>
                <th>Entité</th>
                <th>ID Entité</th>
                <th>Adresse IP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars(date('d/m/Y H:i:s', strtotime($log['created_at']))); ?></td>
                    <td><?= htmlspecialchars($log['user_username'] ?? 'N/A'); ?></td>
                    <td><?= htmlspecialchars($log['action_type']); ?></td>
                    <td><?= htmlspecialchars($log['description']); ?></td>
                    <td><?= htmlspecialchars($log['entity_type'] ?? 'N/A'); ?></td>
                    <td><?= htmlspecialchars($log['entity_id'] ?? 'N/A'); ?></td>
                    <td><?= htmlspecialchars($log['ip_address']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/?route=admin&action=viewActivityLogs&page=<?= $i; ?>" class="<?= ($i == $page) ? 'active' : ''; ?>">
                <?= $i; ?>
            </a>
        <?php endfor; ?>
    </div>

<?php else: ?>
    <p>Aucune activité enregistrée pour le moment.</p>
<?php endif; ?>

<p><a href="/?route=admin&action=index" class="button-secondary">Retour au panneau d'administration</a></p>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>