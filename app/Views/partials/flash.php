<?php

if (!empty($flash)):
    $map = [
        'success' => ['success', '✓'],
        'danger'  => ['danger',  '✕'],
        'warning' => ['warning', '!'],
        'info'    => ['info',    'i'],
    ];
    [$cls, $icon] = $map[$flash['type']] ?? $map['info'];
?>
    <div class="alert alert-<?= $cls ?> alert-dismissible fade show" role="alert">
        <strong><?= $icon ?></strong>
        <?= htmlspecialchars($flash['message']) ?>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>
