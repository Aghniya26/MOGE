<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<div class="maincontent2">
    <div class="row g-4 align-items-center">
        <!-- name display -->
        <div class="col-3">
            <img src="https://cdn-icons.flaticon.com/png/512/3177/premium/3177440.png?token=exp=1656352745~hmac=bd90571c5a585aa9af966b00bcf1cce3" alt="" width="60px">
        </div>

        <div class="col-7">
            <td><?= $user[0]->FIRST_NAME . " " . $user[0]->LAST_NAME; ?></td>
        </div>
        <div class="col-2">
            <span class="edit-name" data-f_name="<?= $user[0]->FIRST_NAME; ?>" data-l_name="<?= $user[0]->LAST_NAME; ?>" data-id="<?= $user[0]->USER_ID; ?>"><i class="bi bi-pencil-square px-2"></i></span>
        </div>
        <!-- email display -->
        <div class="col-3">Email</div>
        <div class="col-7">
            <td><?= $user[0]->EMAIL; ?></td>
        </div>
        <div class="col-2">
            <span class="edit-email" data-email="<?= $user[0]->EMAIL; ?>" data-id="<?= $user[0]->USER_ID; ?>"><i class="bi bi-pencil-square px-2"></i></span>
        </div>
        <!-- password display -->
        <div class="col-3">Password</div>
        <div class="col-7"><?php
                            for ($x = 1; $x <= strlen($user[0]->PASSWORD); $x++) {
                                echo "*";
                            } ?></div>
        <div class="col-2">
            <span class="edit-password" data-password="<?= $user[0]->PASSWORD; ?>" data-id="<?= $user[0]->USER_ID; ?>"><i class="bi bi-pencil-square px-2"></i> </span>
        </div>
        <!-- delete user -->

        <button type="button" class="btn btn-danger col-4 text-center mt-5 delete-user" data-id="<?= $user[0]->USER_ID; ?>"><i class=" bi bi-person-x-fill mr-2"></i>Delete Account</button>
        <span class="col-4"></span>
        <a href="<?= base_url('logout') ?>" class="col-4 text-center mt-5"> <button class="btn btn-primary ">Log Out</button></a>

    </div>

</div>

<!--Modal edit name  -->

<form method="POST" action="<?= base_url('/settings/editUser') ?>">
    <div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="f_name" class="col-form-label">First Name</label>
                        <input type="text" class="form-control" id="f_name" name="f_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="l_name" class="col-form-label">Last Name</label>
                        <input type="text" class="form-control" id="l_name" name="l_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" class="user_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- modal edit email -->
<form method="POST" action="<?= base_url('/settings/editUser') ?>">
    <div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" class="user_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- modal edit password -->
<form method="POST" action="<?= base_url('/settings/editUser') ?>">
    <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="cur_password" class="col-form-label">Current Password</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="cur_password" name="cur_password" required>
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="password_show_hide();">
                                <i class="bi bi-eye" id="show_eye"></i>
                                <i class="bi bi-eye-slash d-none" id="hide_eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="col-form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="con_new_password" class="col-form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="con_new_password" name="con_new_password" onkeyup="checkInput()" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" class="user_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_password" onclick="checkInput();">UPDATE</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- delete modal -->
<!-- delete class modal -->
<form action="/settings/deleteUser" method="post">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete class</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/6897/6897039.png" alt="" width="30%">
                    </div>
                    <p class="font-weight-bold f24 text-center">Do you really want to remove your account?
                    </p>
                    <p class="text-center">ATTENTION! if you decide to delete your account, your account and personal data will be deleted permanently and irreversible. Please make sure you do not have any valuable information in there.</p>

                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="user_id" class="user_id">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Remove</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {

        //    edit name
        $('.edit-name').on('click', function() {

            const id = $(this).data('id');
            const f_name = $(this).data('f_name');
            const l_name = $(this).data('l_name');
            $('input[name=user_id]').val(id);
            $('input[name=f_name]').val(f_name);
            $('input[name=l_name]').val(l_name);
            $('#editNameModal').modal('show');
        });


        //    edit email
        $('.edit-email').on('click', function() {

            const id = $(this).data('id');
            const email = $(this).data('email');
            $('input[name=user_id]').val(id);
            $('input[name=email]').val(email);
            $('#editEmailModal').modal('show');
        });

        //    edit password
        $('.edit-password').on('click', function() {
            const id = $(this).data('id');
            $('input[name=user_id]').val(id);
            $('#editPasswordModal').modal('show');
        });

        // delete user
        //    edit password
        $('.delete-user').on('click', function() {
            const id = $(this).data('id');
            $('input[name=user_id]').val(id);
            $('#deleteModal').modal('show');
        });

    });
</script>

<script>
    // validarion confirm new password
    const input1 = document.querySelector("#con_new_password");
    const input2 = document.querySelector("#new_password");
    const submitButton = document.querySelector("#update_password");


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
</script>
<script>
    function password_show_hide() {
        var x = document.getElementById("cur_password");
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