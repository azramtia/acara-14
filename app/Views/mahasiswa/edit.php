<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Mahasiswa</title>
    <?php require __DIR__ . '/../partials/head.php'; ?>
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 640px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4">Edit Mahasiswa</h2>

            <?php require __DIR__ . '/../partials/flash.php'; ?>

            <?php
            $action      = BASE_URL . '/mahasiswa/update';
            $data        = $mahasiswa;
            $id          = $mahasiswa['id'];
            $submitLabel = 'Simpan Perubahan';
            require __DIR__ . '/_form.php';
            ?>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../partials/scripts.php'; ?>
</body>
</html>
