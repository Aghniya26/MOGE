<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/styles/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/styles/style.css') ?>">
    <title>MOGE</title>
</head>

<body>
    <nav class="navbar navbar-expand-xxl navbar-light bg-light" aria-label="Twelfth navbar example">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarsExample10">
                <img class="p-2" src="<?= base_url('assets/images/moge_logo.png') ?>" alt="">
                <ul class="navbar-nav p-2">
                    <li class="nav-item mx-lg-5">
                        <a class="nav-link active" aria-current="page" href="#">Attendance</a>
                    </li>
                    <li class="nav-item mx-lg-5">
                        <a class="nav-link" href="#">Participants</a>
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

    <div class="d-flex justify-content-around container1">
        <div class="p-2">
            <h1 class="f32">Proyek TA</h1>
            <p class="f20">3C D-III</p>
            <button>+ Add Meeting</button>
        </div>
        <div class="p-2 d-flex justify-content-between">
            <div class="p-2 center">
                <h2 class="f64">0%</h2>
                <p class="f20">Students</p>
            </div>
            <div class="p-2 center">
                <h2 class="f64">0</h2>
                <p class="f20">Average Attendance</p>
            </div>
        </div>
    </div>

    <!-- no data ui -->
    <!-- <div class="d-flex justify-content-around">
        <div class="p-2">
            <h1 class="f24">Overall Attendance</h1>
            <hr>
            <p class="f20">No data</p>
        </div>
        <div class="p-2">
            <h1 class="f24">Top 5</h1>
            <hr>
            <p class="f20">No data</p>
        </div>
    </div> -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>