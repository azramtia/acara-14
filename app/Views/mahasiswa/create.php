<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Mahasiswa</title>
    <?php require __DIR__ . '/../partials/head.php'; ?>
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 640px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4">Tambah Mahasiswa</h2>

            <?php require __DIR__ . '/../partials/flash.php'; ?>

            <?php
            $action      = BASE_URL . '/mahasiswa/store';
            $data        = $old;
            $submitLabel = 'Simpan';
            require __DIR__ . '/_form.php';
            ?>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../partials/scripts.php'; ?>
</body>
</html>
