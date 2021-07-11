<?php $this->extend("auth/templates/app") ?>

<?php $this->section("content") ?>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?=lang('Auth.register')?></h1>
                            </div>

                            <?= view('Myth\Auth\Views\_message_block') ?>

                            <form action="<?= route_to('register') ?>" method="post" class="user">
                            <?= csrf_field() ?>
                                <div class="form-group">
                                    <input name="fullname" type="text" class="form-control form-control-user " id="name"
                                        placeholder="Your name" value="<?= old('fullname') ?>" autofocus=>
                                </div>
                                <div class="form-group">
                                    <input name="username" type="text" class="form-control form-control-user " id="username"
                                        placeholder="Username your account" value="<?= old('username') ?>">
                                </div>
                                <div class="form-group">
                                    <input name="email" type="email" class="form-control form-control-user  <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" id="exampleInputEmail"
                                        placeholder="Email Address" value="<?= old('email') ?>">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="password" type="password" class="form-control form-control-user <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>"
                                            id="exampleInputPassword" placeholder="Password" autocomplete="off">
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="pass_confirm" type="password" class="form-control form-control-user <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                                            id="exampleRepeatPassword" placeholder="Repeat Password" autocomplete='off'>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-block"><?=lang('Auth.register')?></button>
                            </form>
                            <div class="text-center">
                                <!-- <a class="small" href="/login">Already have an account? Login!</a> -->
                                <a href="<?= route_to('login') ?>">
                                    <?=lang('Auth.alreadyRegistered')?>
                                    <?=lang('Auth.signIn')?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register Page</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<?php $this->endSection() ?>