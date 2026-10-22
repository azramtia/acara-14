<?php

class Mahasiswa
{
    private $id;
    private $nim;
    private $nama;
    private $email;
    private $angkatan;
    private $prodi;
    private $status;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = (int) $id; }

    public function getNim() { return $this->nim; }
    public function setNim($nim) { $this->nim = trim($nim); }

    public function getNama() { return $this->nama; }
    public function setNama($nama) { $this->nama = trim($nama); }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = strtolower(trim($email)); }

    public function getAngkatan() { return $this->angkatan; }
    public function setAngkatan($angkatan) { $this->angkatan = (int) $angkatan; }

    public function getProdi() { return $this->prodi; }
    public function setProdi($prodi) { $this->prodi = trim($prodi); }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = strtolower(trim($status)); }
}
