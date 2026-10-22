<?php

require_once __DIR__ . '/../Core/Logger.php';
require_once __DIR__ . '/../Core/DataException.php';
require_once __DIR__ . '/../Models/MahasiswaRepository.php';
require_once __DIR__ . '/../Models/ProdiRepository.php';


class MahasiswaService
{
    private const STATUS_VALID  = ['aktif', 'lulus', 'cuti'];
    private const ANGKATAN_MIN  = 2000;

    public function __construct(
        private MahasiswaRepository $repo,
        private ProdiRepository $prodiRepo
    ) {}

    public function all(): array
    {
        return $this->read(
            fn() => $this->repo->all(),
            'MahasiswaService::all',
            'Data mahasiswa gagal dimuat'
        );
    }

    public function find(int $id)
    {
        return $this->read(
            fn() => $this->repo->find($id),
            'MahasiswaService::find',
            'Data mahasiswa gagal dimuat'
        );
    }

    public function findDetail(int $id)
    {
        return $this->read(
            fn() => $this->repo->findDetail($id),
            'MahasiswaService::findDetail',
            'Data mahasiswa gagal dimuat'
        );
    }

    public function prodiOptions(): array
    {
        return $this->read(
            fn() => $this->prodiRepo->names(),
            'MahasiswaService::prodiOptions',
            'Daftar program studi gagal dimuat'
        );
    }

    public function create(array $input): array
    {
        try {
            $input  = $this->normalize($input);
            $errors = $this->validate($input);

            if (!empty($errors)) {
                return $this->fail($errors);
            }

            $id = $this->repo->create($input);

            return [
                'success' => true,
                'id'      => $id,
                'message' => 'Data mahasiswa berhasil ditambahkan',
            ];
        } catch (Exception $e) {
            return $this->failFromException($e, 'MahasiswaService::create', 'Data gagal disimpan', true);
        }
    }

    public function update(int $id, array $input): array
    {
        try {
            if ($id <= 0 || !$this->repo->find($id)) {
                return $this->fail(['_global' => 'Data mahasiswa tidak ditemukan']);
            }

            $input  = $this->normalize($input);
            $errors = $this->validate($input, $id);

            if (!empty($errors)) {
                return $this->fail($errors);
            }

            $this->repo->update($id, $input);

            return [
                'success' => true,
                'id'      => $id,
                'message' => 'Data mahasiswa berhasil diubah',
            ];
        } catch (Exception $e) {
            return $this->failFromException($e, 'MahasiswaService::update', 'Data gagal disimpan', true);
        }
    }

    public function delete(int $id): array
    {
        try {
            if ($id <= 0 || !$this->repo->find($id)) {
                return $this->fail(['_global' => 'Data mahasiswa tidak ditemukan']);
            }

            $this->repo->delete($id);

            return [
                'success' => true,
                'message' => 'Data mahasiswa berhasil dihapus',
            ];
        } catch (Exception $e) {
            return $this->failFromException($e, 'MahasiswaService::delete', 'Data gagal dihapus');
        }
    }

    private function validate(array $input, ?int $exceptId = null): array
    {
        $errors = [];

        // NIM
        if ($input['nim'] === '') {
            $errors['nim'] = 'NIM wajib diisi';
        } elseif (!preg_match('/^[0-9]+$/', $input['nim'])) {
            $errors['nim'] = 'NIM harus berupa angka';
        } elseif (strlen($input['nim']) > 20) {
            $errors['nim'] = 'NIM maksimal 20 karakter';
        } elseif ($this->repo->existsByNim($input['nim'], $exceptId)) {
            $errors['nim'] = 'NIM sudah terdaftar';
        }

        // Nama
        if ($input['nama'] === '') {
            $errors['nama'] = 'Nama wajib diisi';
        } elseif (strlen($input['nama']) > 100) {
            $errors['nama'] = 'Nama maksimal 100 karakter';
        }

        // Email
        if ($input['email'] === '') {
            $errors['email'] = 'Email wajib diisi';
        } elseif (strlen($input['email']) > 100) {
            $errors['email'] = 'Email maksimal 100 karakter';
        } elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid';
        }

        $maxTahun = (int) date('Y');

        if ($input['angkatan'] === '') {
            $errors['angkatan'] = 'Angkatan wajib diisi';
        } elseif (!preg_match('/^\d{4}$/', $input['angkatan'])
            || (int) $input['angkatan'] < self::ANGKATAN_MIN
            || (int) $input['angkatan'] > $maxTahun) {
            $errors['angkatan'] = 'Angkatan harus berupa tahun ' . self::ANGKATAN_MIN . '-' . $maxTahun;
        }

        // Prodi
        if ($input['prodi'] === '') {
            $errors['prodi'] = 'Program studi wajib dipilih';
        } elseif (!$this->prodiRepo->existsByNama($input['prodi'])) {
            $errors['prodi'] = 'Program studi tidak tersedia';
        }

        // Status
        if ($input['status'] === '') {
            $errors['status'] = 'Status wajib dipilih';
        } elseif (!in_array(strtolower($input['status']), self::STATUS_VALID, true)) {
            $errors['status'] = 'Status tidak valid';
        }

        return $errors;
    }

    private function normalize(array $input): array
    {
        return [
            'nim'      => trim((string) ($input['nim'] ?? '')),
            'nama'     => trim((string) ($input['nama'] ?? '')),
            'email'    => trim((string) ($input['email'] ?? '')),
            'angkatan' => trim((string) ($input['angkatan'] ?? '')),
            'prodi'    => trim((string) ($input['prodi'] ?? '')),
            'status'   => trim((string) ($input['status'] ?? '')),
        ];
    }

    private function read(callable $fn, string $context, string $userMessage)
    {
        try {
            return $fn();
        } catch (PDOException $e) {
            Logger::exception($e, $context);

            throw new DataException($userMessage, 0, $e);
        }
    }

    private function failFromException(
        Exception $e,
        string $context,
        string $userMessage,
        bool $checkDuplicateNim = false
    ): array {
        Logger::exception($e, $context);

        if ($checkDuplicateNim && $e instanceof PDOException && $e->getCode() === '23000') {
            return $this->fail(['nim' => 'NIM sudah terdaftar']);
        }

        return $this->fail(['_global' => $userMessage]);
    }

    private function fail(array $errors): array
    {
        return [
            'success' => false,
            'errors'  => $errors,
        ];
    }
}
