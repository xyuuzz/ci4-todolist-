<?php $this->extend("templates/app") ?>

<?php $this->section("content") ?>

<button class="btn btn-lg btn-outline-secondary mb-3 back-tom">Kembali</button>

<div class="card shadow border-bottom-dark ">
    <div class="card-header">
        <h5><b>Buat Jadwal</b></h5>
    </div>
    <div class="card-body border-top-primary container-fluid">
        <form id="dataForm" class="user" enctype="multipart/form-data" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="banner">Gambar Tugas</label>
                <input id="banner" type="file" class="form-control" id="validationServer03" aria-describedby="bannerValidate" name="banner" onchange="previewImage()">
                <div id="bannerValidate" class="invalid-feedback d-none">
                    
                </div>
                <img src="<?= base_url() ?>/profiles/default.svg" alt="image preview" class="m-4 img-preview" width="200px">
            </div>
            <div class="form-group">
                <label for="title">Nama Jadwal</label>
                <input  name="title" id="title" type="text" class="form-control form-control-user" placeholder="MASUKAN NAMA JADWAL">
            </div>
            <div class="form-group">
                <label for="description">Deskripsi Jadwal</label>
                <textarea name="desc" id="description" cols="30" rows="10" class="form-control" ></textarea>
            </div>
            <div class="form-group">
                <label for="deadline">Deadline Tugas / Jadwal</label>
                <input   name="due_date" id="deadline" type="date" class="form-control" >
            </div>

            <button type="submit" class="btn btn-primary submit">Buat</button>
        </form>
    </div>
</div>

<?php $this->endSection() ?>

