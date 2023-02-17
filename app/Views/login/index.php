<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css?v=3.2.0">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= base_url(); ?>/index2.html"><b>Silahkan</b>Login</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <?= form_open('login/cekUser'); ?>
                <?= csrf_field(); ?>
                <div class="input-group mb-3">
                    <?php
                    $isInvalidUser = (session()->getFlashdata('errIdUser')) ? 'is-invalid' : '';
                    $isInvalidPass = (session()->getFlashdata('errPassword')) ? 'is-invalid' : '';
                    ?>
                    <input type="text" class="form-control <?= $isInvalidUser; ?>" name="iduser" placeholder="Masukan ID User" autofocus autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <?php
                    if (session()->getFlashdata('errIdUser')) {
                        echo '<div class="invalid-feedback">' . session()->getFlashdata('errIdUser') . '</div>';
                    }
                    ?>

                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control <?= $isInvalidPass; ?>" name="pass" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <?php
                    if (session()->getFlashdata('errPassword')) {
                        echo '<div class="invalid-feedback">' . session()->getFlashdata('errPassword') . '</div>';
                    }
                    ?>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-block btn-success">Login</button>
                </div>
                <?= form_close(); ?>

            </div>

        </div>
    </div>


    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>

    <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url(); ?>/dist/js/adminlte.min.js?v=3.2.0"></script>
</body>

</html>