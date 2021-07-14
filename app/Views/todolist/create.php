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
        <div class="d-lg-flex justify-content-between">
            <form class="user dataForm col-lg-6" enctype="multipart/form-data" method="POST" action="#">
                <?= csrf_field() ?>

                <?php if(session("edit")) : ?>
                    <input type="hidden" name="_method" value="PATCH">
                <?php else : ?>
                    <input type="hidden" name="row" value="1">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="banner">Gambar Tugas</label>
                    <input required type="file" class="form-control" id="validationServer03" aria-describedby="bannerValidate" name="banner" onchange="previewImage(this)">
                    <div id="bannerValidate" class="invalid-feedback d-none">
                        
                    </div>
                    <img src="<?= base_url() ?>/banners/<?= $tdl["banner"] ?? "default.svg" ?>" alt="image preview" class="m-4 img-preview" width="200px">
                </div>
                <div class="form-group">
                    <label for="title">Nama Jadwal</label>
                    <input required  name="title" id="title" type="text" class="form-control form-control-user" placeholder="MASUKAN NAMA JADWAL" value="<?= $tdl["title"] ?? "" ?>">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi Jadwal</label>
                    <textarea required name="desc" id="description" cols="30" rows="10" class="form-control" ><?= $tdl["desc"] ?? "" ?></textarea>
                </div>

                <?php if(session("edit")) : ?>
                    <?php if($tdl["status"]) : ?>
                        <small><b>Karena Status Sudah Tuntas, maka anda tidak dapat mengedit field dibawah</b></small>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="form-group">
                    <label for="deadline">Deadline Tugas / Jadwal</label>
                    <input required name="due_date" id="deadline" type="date" class="form-control" 
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
            </form>
        </div>

        <?php if(!session("edit")) : ?>
            <button type="button" class="btn btn-info d-block mb-3 mt-5 " onclick="addRow(this)">
                Tambahkan Form Jadwal
            </button>
        <?php endif; ?>
        
        <!-- untuk insert batch kita garap besok saja -->

        <button type="button" class="btn btn-primary <?= session("edit") ? "update" : "submit float-lg-right" ?>" 
        <?= session("edit") ? "data-tdl={$tdl['slug']}" : "" ?> >
            <?= session("edit") ? "Sunting" : "Buat" ?>
        </button>
    </div>
</div>

<?php $this->endSection() ?>

