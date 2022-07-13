<?= $this->extend('template2'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">

    <div class="row justify-content-md-center">

        <div class="col-6">
            <center>
                <img src="/assets/images/moge_logo.png">
            </center>
            <p>We will help you to monitor and control your online classroom Zoom participant attendance.</p>
            <p>Sign up with Moge fo free!</p>
            <?php if (session()->getFlashdata('msg')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert"><?= session()->getFlashdata('msg') ?>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('register') ?>" method="post">
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="InputForFirstName" class="form-label">First Name</label>
                        <input type="text" name="f_name" id="f_name" class="form-control" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="InputForLastName" class="form-label">Last Name</label>
                        <input type="text" name="l_name" id="l_name" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="InputForEmail" class="form-label">Email </label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="InputForPassword" class="form-label">Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup="validatePassword()" required>
                    <div id="message" class="form-text">Must contain upper and lower case letter, a number, at least 8 caharacters long</div>
                </div>
                <div class="mb-3">
                    <label for="InputForConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" name="con_new_password" class="form-control" id="con_new_password" onkeyup="checkInput()" required>
                </div>
                <span style="float: right">
                    <button type="submit" class="btn btn-primary" id="save_data">Get Started</button>
                </span>
                <span style="float: left">
                    Already have an account?<a href="<?= base_url('/') ?>" class="fw-bold"> Sign In</a>
                </span>
            </form>
        </div>
    </div>
</div>

<script>
    // validarion confirm new password
    const input1 = document.querySelector("#con_new_password");
    const input2 = document.querySelector("#new_password");
    const submitButton = document.querySelector("#save_data");


    function checkInput() {
        var cn_pass = document.getElementById("con_new_password").value;
        var n_pass = document.getElementById("new_password").value;

        if (cn_pass.length > 0) {
            if (cn_pass != n_pass) {
                input1.classList.add("is-invalid");
                submitButton.disabled = true;
            } else {
                input1.classList.remove("is-invalid");
                input1.classList.add("is-valid");
                input2.classList.add("is-valid");
                submitButton.disabled = false;
            }
        }
    }

    function validatePassword() {
        var n_pass = document.getElementById("new_password").value;
        var lowerCaseLetters = /[a-z]/g;
        var upperCaseLetters = /[A-Z]/g;
        var numbers = /[0-9]/g;

        if (n_pass.length >= 8 && n_pass.match(lowerCaseLetters) && n_pass.match(upperCaseLetters) && n_pass.match(numbers)) {
            input2.classList.remove("is-invalid");
            input2.classList.add("is-valid");
            submitButton.disabled = false;
        } else {
            input2.classList.add("is-invalid");
            submitButton.disabled = true;
        }
    }
</script>
<?= $this->endSection(); ?>