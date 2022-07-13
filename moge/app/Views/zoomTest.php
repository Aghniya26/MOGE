<?= $this->extend('template2'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col-6">
            <center>
                <img src="/assets/images/moge_logo.png" class="mb-3">
            </center>
            <p class="mb-3">Your account already activated, please click the button bellow to integrate your zoom account with our services.</p>
            <div class="mb-3">
                <p class="f24 fw-bold">Features that save your time: </p>
                <p>Automatically create Zoom Meetings at the time an event is scheduled.
                    Instantly share unique conferencing details upon confirmation.
                </p>
            </div>
            <div class="mb-3">
                <p class="f24 fw-bold">Requirements: </p>
                <ul>
                    <li>A Zoom account</li>
                    <li>Your Zoom account administrator</li>
                </ul>
            </div>
            <div class="text-center">
                <a href="https://zoom.us/oauth/authorize?response_type=code&client_id=<?= $client_id ?>&redirect_uri=<?= $redirect_uri ?>"><button class="btn btn-primary"><i class="bi bi-camera-video-fill mr-2"></i>Connect with Zoom</button></a>
            </div>
        </div>
    </div>
</div>
</div>

<?= $this->endSection(); ?>