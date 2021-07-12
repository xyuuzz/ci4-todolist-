<?php $this->extend("templates/app") ?>

<?php $this->section("content") ?>

<button class="btn btn-lg btn-outline-secondary mb-3 create-button">Buat Jadwal</button>

<input type="text" class="form-control mt-3 mb-3 col-lg-4 searchInput d-none-sm" placeholder="Cari jadwal / tugas">

<?php if(session("success")) : ?>
    <div class="alert alert-success" role="alert">
        <?= session("success") ?>
    </div>
<?php endif; ?>

<div class="alert alert-danger d-none" role="alert">
    Gagal melakukan permintaan yang dikirimkan..
</div>

<div class="card shadow mb-4 border-bottom-info ">
    <?php if(count($data)) : ?>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List To Do List yang telah dibuat</h6>
    </div>
    <div class="card-body container-fluid dataTdl">
        <?php foreach($data as $tdl) : ?>
            <div class="card mb-5">
                <div class="card-header">
                    <?= $tdl->title ?>
                </div>
                <div class="card-body">
                    <div class="d-lg-flex">
                        <img class="img-thumbnail" src="<?= base_url() ?>/banners/<?= $tdl->banner ?>" alt="thumbnail jadwal" width="300">
                        <div class="ml-lg-5 mt-3">
                            <p><b>Deskripsi Jadwal :</b> <?= $tdl->desc ?></p>
                        </div>
                    </div>
                    <div class="float-lg-right mt-sm-3">
                        <!-- <button class="btn btn-danger btn-sm delete-tdl" data-tdl="<?= $tdl->slug ?>">Hapus</button>
                        <button class="btn btn-primary btn-sm update-tdl" data-tdl="<?= $tdl->slug ?>">Sunting</button> -->
                        <button class="btn btn-outline-info btn-sm show-tdl mr-4" data-tdl="<?= $tdl->slug ?>">Detail</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
    <div class="card-header text-center ">
        <b>Anda Tidak mempunyai jadwal, silahkan buat terlebih dahulu</b>
        <div class="d-flex justify-content-center">
            <a href="/buat/todolist" class="btn btn-outline-primary mt-3 mb-2">Buat Jadwal</a>
        </div>
    </div>
    <?php endif; ?>
</div>


<?php $this->endSection() ?>



<script
src="https://code.jquery.com/jquery-3.6.0.js"
integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
crossorigin="anonymous"></script>