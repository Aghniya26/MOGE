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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>


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
                        <a class="nav-link" href="<?= base_url('evaluation'); ?>">Evaluations</a>
                    </li>
                </ul>
                <div class="p-2">
                    <a href="<?= base_url('settings') ?>"> <img class="ml-1" src="<?= base_url('/assets/images/profile.png') ?>" alt=""></a>

                </div>
            </div>
        </div>

    </nav>


    <!-- content -->
    <?= $this->renderSection('content'); ?>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>