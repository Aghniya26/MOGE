<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<div class="maincontent">
    <p>Use this template to import participant data. <a href="#" class="font-weight-bold">Click here</a>
        to download the template. You can only import participant data before you generate Zoom meeting. </p>
    <button class="p-2"><i class="bi bi-upload pr-2"></i>import participant data</button>
    <p class="f24 pt-5">Participant</p>
    <div class="line"></div>
    <table class="table table-hover">
        <?php foreach ($participants as $p) { ?>
            <tr>
                <td><?= $p->ptc_name; ?></td>
                <td><?= $p->ptc_email; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?= $this->endSection(); ?>