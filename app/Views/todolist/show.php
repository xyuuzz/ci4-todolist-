<?php $this->extend("templates/app") ?>


<?php $this->section("content") ?>

<button class="btn btn-lg btn-outline-secondary mb-3 back-tom">Kembali</button>

<?php if(session("success")) : ?>
    <div class="alert alert-success" role="alert">
        <?= session("success") ?>
    </div>
<?php endif; ?>

<div class="card shadow mb-4 border-bottom-info ">
    <div class="card-header">
        <h5>Detail Jadwal : <?= $tdl["title"] ?></h5>
    </div>
    <div class="card-body">
        <div class="d-lg-flex">
            <img class="img-thumbnail mb-3" src="<?= base_url() ?>/banners/<?= $tdl["banner"] ?>" alt="thumbnail jadwal" width="300">
            <div class="ml-lg-5 mb-3">
                <p>Deskripsi : <?= $tdl["desc"] ?></p>
                <p><b>Tenggat Waktu : </b> <?= date_format(date_create($tdl["due_date"]), "d/m/Y") ?></p>
                <p><b>Status : </b>
                            <?php if($tdl["status"]) : ?>
                                <span class="btn btn-success btn-sm">Selesai</span>
                            <?php elseif(!$tdl["status"] && 
                            date_format(date_create("now"), "Y-m-d H:I:s" ) < $tdl["due_date"]) : ?>
                                <span class="btn btn-warning btn-sm">Belum Tuntas</span>
                            <?php else : ?>
                                <span class="btn btn-danger btn-sm">Tidak Tuntas</span>
                            <?php endif; ?>
                            </p>
            </div>
        </div>
        <div class="float-right">
        <button class="btn btn-danger btn-sm delete-tdl mr-2" data-tdl="<?= $tdl["slug"] ?>">Hapus</button>
        <button class="btn btn-primary btn-sm update-tdl mr-3" data-tdl="<?= $tdl["slug"] ?>" 
        <?= $tdl["status"] ||  !$tdl["status"] && date_format(date_create("now"), "Y-m-d H:I:s" ) > 
        $tdl["due_date"] ? "disabled" : "" ?> >
        Sunting</button>
        </div>
    </div>
</div>

<?php $this->endSection() ?>