<?php $this->extend("templates/app") ?>

<?php $this->section("content") ?>

<button class="btn btn-lg btn-outline-secondary mb-3 back-tom" 
        data-backto="<?= session("edit") ? $back_to : "" ?>">
        Kembali</button>

<?php if(session("success")) : ?>
    <div class="alert alert-success" role="alert">
        <?= session("success") ?>
    </div>
<?php endif; ?>

<div class="card shadow border-bottom-dark ">
    <div class="card-header">
        <h5><b><?= session("edit") ? "Sunting Jadwal" : "Buat Jadwal" ?></b></h5>
    </div>
    <div class="card-body border-top-primary container-fluid">
        <form id="dataForm" class="user" enctype="multipart/form-data" method="POST" action="#">
            <?= csrf_field() ?>
            <?php if(session("edit")) : ?>
                <input type="hidden" name="_method" value="PATCH">
            <?php endif; ?>
            <div class="form-group">
                <label for="banner">Gambar Tugas</label>
                <input id="banner" type="file" class="form-control" id="validationServer03" aria-describedby="bannerValidate" name="banner" onchange="previewImage()">
                <div id="bannerValidate" class="invalid-feedback d-none">
                    
                </div>
                <img src="<?= base_url() ?>/banners/<?= $tdl["banner"] ?? "default.svg" ?>" alt="image preview" class="m-4 img-preview" width="200px">
            </div>
            <div class="form-group">
                <label for="title">Nama Jadwal</label>
                <input  name="title" id="title" type="text" class="form-control form-control-user" placeholder="MASUKAN NAMA JADWAL" value="<?= $tdl["title"] ?? "" ?>">
            </div>
            <div class="form-group">
                <label for="description">Deskripsi Jadwal</label>
                <textarea name="desc" id="description" cols="30" rows="10" class="form-control" ><?= $tdl["desc"] ?? "" ?></textarea>
            </div>

            <?php if(session("edit")) : ?>
                <?php if($tdl["status"]) : ?>
                    <small><b>Karena Status Sudah Tuntas, maka anda tidak dapat mengedit field dibawah</b></small>
                <?php endif; ?>
            <?php endif; ?>

            <div class="form-group">
                <label for="deadline">Deadline Tugas / Jadwal</label>
                <input name="due_date" id="deadline" type="date" class="form-control" 
                value="<?= session("edit") ? date("Y-m-d", strtotime($tdl["due_date"])) : "" ?>" 
                <?= session("edit") ? ($tdl["status"] ? "readonly" : "") : ""?> >
            </div>

            <?php if(session("edit")) : ?>
            <div class="form-group">
                <label for="status">Status Tugas / Jadwal :</label>
                <select name="status" id="status" class="form-control" <?= $tdl["status"] ? "readonly" : "" ?> >
                    <?php if($tdl["status"]) : ?>
                        <option value="1">Sudah Tuntas</option>
                    <?php else : ?>
                        <option value="0">Belum Tuntas</option>
                        <option value="1">Sudah Tuntas</option>
                    <?php endif; ?>
                </select>
                <small>Cek Lagi Tugas/Jadwal mu ya, pastikan semuanya selesai.</small>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary <?= session("edit") ? "update" : "submit" ?>" 
            <?= session("edit") ? "data-tdl={$tdl['slug']}" : "" ?> >
                <?= session("edit") ? "Sunting" : "Buat" ?>
            </button>
        </form>
    </div>
</div>

<?php $this->endSection() ?>

