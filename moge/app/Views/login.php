<?= $this->extend('template2'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5 py-5">

    <div class="row justify-content-md-center">

        <div class="col-4">
            <center>
                <img src="/assets/images/moge_logo.png" class="mb-3">
            </center>
            <p>We will help you to monitor and control your online classroom Zoom participant attendance.</p>
            <p>Welcome back! Please Sign in here.</p>
            <?php if (session()->getFlashdata('msg')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert"><?= session()->getFlashdata('msg') ?>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('auth') ?> " method="post">
                <div class="mb-3">
                    <label for="InputForEmail" class="form-label">Email </label>
                    <input type="email" name="user_email" id="user_email" class="form-control" id="InputForEmail">
                </div>
                <label for="InputForPassword" class="form-label">Password</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="user_password" name="user_password" required>
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="password_show_hide();">
                            <i class="bi bi-eye" id="show_eye"></i>
                            <i class="bi bi-eye-slash d-none" id="hide_eye"></i>
                        </span>
                    </div>
                </div>
                <span style="float: right">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </span>
                <span style="float: left">
                    <a>
                        <href>Don't have an account? <a href="<?= base_url('register') ?>" class="font-weight-bold">Sign up</a>
                </span>
            </form>
        </div>

    </div>
</div>



<script>
    function password_show_hide() {
        var x = document.getElementById("user_password");
        var show_eye = document.getElementById("show_eye");
        var hide_eye = document.getElementById("hide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }
</script>

<?= $this->endSection(); ?>