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
                <ul class="navbar-nav p-2">
                    <li class="nav-item mx-lg-5">
                        <a class="nav-link" aria-current="page" href="<?= base_url('attendance'); ?>">Attendance</a>
                    </li>
                    <li class="nav-item mx-lg-5">
                        <a class="nav-link" href="<?= base_url('participant'); ?>">Participants</a>
                    </li>
                    <li class="nav-item mx-lg-5">
                        <a class="nav-link" href="#">Evaluations</a>
                    </li>
                </ul>
                <div class="p-2">
                    <img class="mr-1" src="<?= base_url('assets/images/setting.png') ?>" alt="">
                    <img class="ml-1" src="<?= base_url('/assets/images/profile.png') ?>" alt="">
                </div>
            </div>
        </div>

    </nav>

    <!-- content -->
    <?= $this->renderSection('content'); ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>