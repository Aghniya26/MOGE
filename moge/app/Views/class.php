<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/styles/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/styles/style.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.2.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="<?= base_url('assets/styles/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/styles/js/jquery.min.js') ?>"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


    <title>MOGE</title>
</head>

<body>



    <!-- navigation -->
    <nav class="navbar navbar-expand-xxl navbar-light bg-light" aria-label="Twelfth navbar example">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarsExample10">
                <img class="p-2" src="<?= base_url('assets/images/moge_logo.png') ?>" alt="">

                <div class="p-2">

                    <img class="ml-1" src="<?= base_url('/assets/images/profile.png') ?>" alt="">
                </div>
            </div>
        </div>

    </nav>
    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert"><?= session()->getFlashdata('msg') ?>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="maincontent">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+add class</button>
        </div>
        <div class=" row my-4">
            <?php
            foreach ($class as $c) { ?>

                <div class="col-4">
                    <div class="card" onclick="">
                        <div class="card-header" style="background: #<?= $c->COLOR; ?>; color: white;">
                            <div class="d-flex justify-content-between">
                                <a class="f32 " href="<?= base_url(['detailclass', $c->CLASS_ID]) ?>"><?= $c->TITLE_CLASS; ?></a>
                                <div class="d-flex justify-content-between ">
                                    <a class="icon-edit" data-id="<?= $c->CLASS_ID; ?>" data-title="<?= $c->TITLE_CLASS; ?>" data-color="<?= $c->COLOR; ?>" data-room="<?= $c->ROOM; ?>" data-detail="<?= $c->DETAIL_CLASS; ?>" data-num_meetings="<?= $c->NUM_MEETINGS; ?>">
                                        <i class="bi bi-pencil-square px-2"></i></a>
                                    <span class="icon-delete" data-id="<?= $c->CLASS_ID; ?>"><i class="bi bi-trash px-2"></i></span>

                                </div>
                            </div>
                            <p class="f20"><?= $c->ROOM; ?></p>
                            <p class="f20"><?= $c->DETAIL_CLASS; ?></p>
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>

            <?php

            }
            ?>
        </div>


        <!-- add class modal -->
        <form method="POST" action="<?= base_url('addclass') ?>">
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="detail" class="col-form-label">Detail:</label>
                                <input type="text" class="form-control" id="detail" name="detail" required>
                            </div>
                            <div class="mb-3">
                                <label for="room" class="col-form-label">Room:</label>
                                <input type="text" class="form-control" id="room" name="room" required>
                            </div>
                            <div class="mb-3">
                                <label for="num_meetings" class="col-form-label">Estimate number of meetings:</label>
                                <input type="number" class="form-control" id="num_meetings" name="num_meetings" required>
                            </div>
                            <div class="mb-3">
                                <label for="color" class="col-form-label">Pick Color</label>
                                <input type="text" class="form-control" id="color" name="color" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- modal -->

        <!-- edit class modal -->
        <form method="POST" action="<?= base_url('editclass') ?>">
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Class</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="detail" class="col-form-label">Detail:</label>
                                <input type="text" class="form-control" id="detail" name="detail" required>
                            </div>
                            <div class="mb-3">
                                <label for="room" class="col-form-label">Room:</label>
                                <input type="text" class="form-control" id="room" name="room" required>
                            </div>
                            <div class="mb-3">
                                <label for="num_meetings" class="col-form-label">Estimate number of meetings:</label>
                                <input type="number" class="form-control" id="num_meetings" name="num_meetings" required>
                            </div>
                            <div class="mb-3">
                                <label for="color" class="col-form-label">Pick Color</label>
                                <input type="text" class="form-control" id="color" name="color" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="class_id" class="class_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- modal -->
        <!-- delete class modal -->
        <form action="deleteclass" method="post">
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete class</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/6897/6897039.png" alt="" width="30%">
                            </div>
                            <p class="font-weight-bold f24 text-center">Are you sure?</p>
                            <p class="text-center">You won’t be able to revert this!</p>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <input type="hidden" name="class_id" class="class_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- modal -->
    </div>




    <script>
        $(document).ready(function() {

            // get Edit class
            $('.icon-edit').on('click', function() {
                // get data from button edit
                const id = $(this).data('id');
                const title = $(this).data('title');
                const color = $(this).data('color');
                const detail = $(this).data('detail');
                const num_meetings = $(this).data('num_meetings');
                const room = $(this).data('room');
                console.log(id, title);
                // Set data to Form Edit
                $('input[name=class_id]').val(id);
                $('input[name=title]').val(title);
                $('input[name=detail]').val(detail);
                $('input[name=room]').val(room);
                $('input[name=num_meetings]').val(num_meetings);
                $('input[name=color]').val(color);
                // Call Modal Edit
                $('#editModal').modal('show');
            });

            // get Delete class
            $('.icon-delete').on('click', function() {
                // get data from button edit
                const id = $(this).data('id');
                // Set data to Form Edit
                $('input[name=class_id]').val(id);
                // Call Modal Edit
                $('#deleteModal').modal('show');
            });

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>