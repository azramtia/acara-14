<?php

$fields = [
    'nim'      => ['NIM', 'text'],
    'nama'     => ['Nama Mahasiswa', 'text'],
    'email'    => ['Email', 'text'],
    'angkatan' => ['Angkatan', 'text'],
];
?>
<form method="POST" action="<?= $action ?>" novalidate>

    <?php if (isset($id)): ?>
        <input type="hidden" name="id" value="<?= (int) $id ?>">
    <?php endif; ?>

    <?php foreach ($fields as $name => [$label, $type]): ?>
        <div class="mb-3">
            <label class="form-label" for="<?= $name ?>"><?= $label ?></label>
            <input type="<?= $type ?>"
                   id="<?= $name ?>"
                   name="<?= $name ?>"
                   class="form-control <?= isset($errors[$name]) ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars((string) ($data[$name] ?? '')) ?>">
            <?php if (isset($errors[$name])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors[$name]) ?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="mb-3">
        <label class="form-label" for="prodi">Program Studi</label>
        <select id="prodi" name="prodi"
                class="form-select <?= isset($errors['prodi']) ? 'is-invalid' : '' ?>">
            <option value="">-- Pilih Prodi --</option>
            <?php foreach ($prodiList as $namaProdi): ?>
                <option value="<?= htmlspecialchars($namaProdi) ?>"
                    <?= ($data['prodi'] ?? '') === $namaProdi ? 'selected' : '' ?>>
                    <?= htmlspecialchars($namaProdi) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['prodi'])): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($errors['prodi']) ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <label class="form-label" for="status">Status</label>
        <select id="status" name="status"
                class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>">
            <option value="">-- Pilih Status --</option>
            <?php foreach (['Aktif', 'Lulus', 'Cuti'] as $opt): ?>
                <option value="<?= $opt ?>"
                    <?= strcasecmp($data['status'] ?? '', $opt) === 0 ? 'selected' : '' ?>>
                    <?= $opt ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['status'])): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($errors['status']) ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary"><?= $submitLabel ?></button>
    <a href="<?= BASE_URL ?>/mahasiswa" class="btn btn-outline-secondary">Batal</a>

</form>
