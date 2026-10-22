<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Mahasiswa</title>
    <?php require __DIR__ . '/../partials/head.php'; ?>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Data Mahasiswa</h2>
                <div>
                    <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-secondary">Dashboard</a>
                    <a href="<?= BASE_URL ?>/mahasiswa/create" class="btn btn-primary">+ Tambah Mahasiswa</a>
                </div>
            </div>

            <?php require __DIR__ . '/../partials/flash.php'; ?>

            <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Angkatan</th>
                        <th>Prodi</th>
                        <th>Status</th>
                        <th style="width: 190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($mahasiswa)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data mahasiswa</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($mahasiswa as $mhs): ?>
                    <tr>
                        <td><?= htmlspecialchars($mhs['nim']) ?></td>
                        <td><?= htmlspecialchars($mhs['nama']) ?></td>
                        <td><?= htmlspecialchars($mhs['email'] ?? '') ?></td>
                        <td><?= htmlspecialchars((string) ($mhs['angkatan'] ?? '')) ?></td>
                        <td><?= htmlspecialchars($mhs['prodi']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($mhs['status'])) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/mahasiswa/detail?id=<?= (int) $mhs['id'] ?>"
                               class="btn btn-sm btn-info">Detail</a>
                            <a href="<?= BASE_URL ?>/mahasiswa/edit?id=<?= (int) $mhs['id'] ?>"
                               class="btn btn-sm btn-warning">Edit</a>

                            <form method="POST" action="<?= BASE_URL ?>/mahasiswa/delete"
                                  class="d-inline">
                                <input type="hidden" name="id" value="<?= (int) $mhs['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>

        </div>
    </div>
</div>
<?php require __DIR__ . '/../partials/scripts.php'; ?>
</body>
</html>
