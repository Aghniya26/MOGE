<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>

<div class="maincontent2">

    <p>Use this template to import participant data. <a href="<?= base_url('assets/download/participant.xlsx') ?>" class="font-weight-bold" download="">Click here</a>
        to download the template. You can only import participant data before you generate Zoom meeting. </p>
    <button class="p-2" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bi bi-upload pr-2"></i>import participant data</button>
    <p class="f24 pt-5">Participant</p>
    <div class="line"></div>
    <?php if ($participants[0] == null) { ?>
        <p>No data</p>

    <?php
    } else { ?>

        <table class="table table-hover">
            <?php foreach ($participants as $p) { ?>
                <tr>
                    <td><?= $p->ptc_name; ?></td>
                    <td><?= $p->ptc_email; ?></td>
                    <td><i class="bi bi-pencil-square px-2 icon-edit" data-id="<?= $p->ptc_id; ?>" data-name="<?= $p->ptc_name; ?>" data-email="<?= $p->ptc_email; ?>"></i></td>
                    <td><i class="bi bi-trash px-2 icon-delete" data-id="<?= $p->ptc_id; ?>"></i></td>

                </tr>
            <?php } ?>
        </table>
    <?php

    } ?>


    <!-- edit class modal -->
    <form method="POST" action="<?= base_url('/participant/edit') ?>">
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Participant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ptc_id" class="ptc_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- modal -->
    <!-- delete class modal -->
    <form action="<?= base_url('/participant/delete') ?>" method="post">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Participant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="https://cdn-icons-png.flaticon.com/512/6897/6897039.png" alt="" width="30%">
                        </div>
                        <p class="font-weight-bold f24 text-center">Are you sure?</p>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="ptc_id" class="ptc_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Remove</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- modal -->

    <!-- import class modal -->
    <form action="<?= base_url('/participant/import') ?>" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>File Excel</label>
                            <input type="file" name="fileexcel" class="form-control" id="file" required accept=".xls, .xlsx" required></p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- modal -->

    <script type="text/javascript">
        Dropzone.options = {
            maxFilesize: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
        };
    </script>
    <script>
        $(document).ready(function() {

            // get Edit class
            $('.icon-edit').on('click', function() {
                // get data from button edit
                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                console.log(id, email);
                // Set data to Form Edit
                $('input[name=ptc_id]').val(id);
                $('input[name=name]').val(name);
                $('input[name=email]').val(email);
                // Call Modal Edit
                $('#editModal').modal('show');
            });

            // get Delete class
            $('.icon-delete').on('click', function() {
                // get data from button edit
                const id = $(this).data('id');
                // Set data to Form Edit
                $('input[name=ptc_id]').val(id);
                // Call Modal Edit
                $('#deleteModal').modal('show');
            });

        });
    </script>
    <?= $this->endSection(); ?>