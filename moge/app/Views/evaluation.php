<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<?php print_r($participants); ?>
<div class="maincontent">
    <div class="mb-3">
        <p class="f24 p-1">Generate Passed Student</p>
        <div class="line"></div>
        <p>You can generate list of students who are eligible to pass your course based on minimum presence time in all meetings.</p>


        <form action="<?= base_url('evaluation') ?>" method="POST">
            <div class="form-check-row">
                <br>
                <div class="form-check-row">
                    <div class="col-6"> <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label for="presenceTime" class="mb-2 mr-sm-2 text-wight-bold col-8">Minimum Presence Time in a Meeting <small> (percentage)</small></label>
                    </div> <input type="number" class="form-control mb-2 mr-sm-2 col-6" id="presenceTime" name="pm" value="<?= $percentMin * 100 ?>">
                </div>
                <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary mb-2">Apply</button></div>
        </form>


    </div>


    <div class="d-flex justify-content-between">
        <p class="f24 p-1">Result</p>
        <a href="#" class="p-1">Download</a>
    </div>
    <div class="line"></div>
    <table class="table table-hover">
        <?php foreach ($participant as $p) { ?>
            <tr>
                <td><?= $p->ptc_name; ?></td>
                <td><?= $p->ptc_email; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?= $this->endSection(); ?>