<?= $this->extend("templates/app") ?>


<?= $this->section("content") ?>

<?php if(session("success")) : ?>
    <div class="alert alert-success mt-5 mb-4" role="alert">
        <?= session("success") ?>
    </div>
<?php endif; ?>

<div class="card mb-3 shadow rounded">
    <div class="card-body">
        <p class="text-center">
            <img src="<?= base_url() . "/profiles/" .$user["image"] ?>" alt="foto profil" class="img-thumbnail img-preview" width="300">
        </p>
        <form action="<?= base_url() ?>/profile/update" method="post" class="container profileForm">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="row" value="1" class="rowCount">

            <p class="text-center">
                <input id="banner" type="file" name="image" class="form-control-sm" onchange="previewImage()">
            </p>

            <div class="form-group">
                <label for="fullname">Nama Lengkap</label>
                <input required name="fullname" id="fullname" type="text" class="form-control form-control-user " value="<?= $user["fullname"]?>">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input required name="username" id="username" type="text" class="form-control form-control-user " value="<?= $user["username"]?>">
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input required name="email" id="email" type="text" class="form-control form-control-user " value="<?= $user["email"]?>">
            </div>


            <div class="form-group">
                <label for="password">Ubah Password</label>
                <input name="password" id="password" type="text" class="form-control form-control-user " placeholder="Ketik password baru">
            </div>
            
            <button type="submit" class="btn btn-outline-primary float-right mt-3 submitProfile">Simpan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>