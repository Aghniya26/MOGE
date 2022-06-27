<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>

<div class="maincontent">
    <div class="row  text-center ">
        <div class="col-6 d-flex align-items-center justify-content-center">
            <p class="f24"><?= $participant[0]->ptc_name ?></p>
        </div>
        <div class="col-6">
            <p class="f32"><?= round($avg_atd[0]->averageAtd * 100) ?>%</p>
            <p class="f16">Average Attendance</p>
        </div>
    </div>
    <div class="line  py-3"></div>
    <table class="table">
        <tr>
            <th colspan="2" class="text-center">Detail Attendance</th>
        </tr>
        <?php foreach ($meetings as $m) { ?>
            <?php
            $status = 0;
            $start_time;
            $end_time;
            foreach ($atdDetail as $a) {
                if ($a->meeting_id == $m->meeting_id) {
                    $status = 1;
                    $start_time = $a->start_time;
                    $end_time = $a->end_time;
                    $totalDuration = strtotime($a->end_time) - strtotime($a->start_time);
                }
                $dt_join = DateTime::createFromFormat("Y-m-d H:i:s", $a->start_time);
                $dt_leave = DateTime::createFromFormat("Y-m-d H:i:s", $a->end_time);
                $t1 = $dt_join->format('H:i');
                $t2 = $dt_leave->format('H:i');
            }
            if ($status == 0) {
            ?>
                <tr>
                    <td style="width: 25%;">Meeting 1</td>
                    <td style="width: 75%;">
                        <div class="progress">
                            <div class="progress-bar bar-red" role="progressbar" style="width: 100%; " aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="<?= $t1 ?>-<?= $t2 ?>"></div>
                        </div>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td style="width: 25%;"><?= $m->meeting_id; ?></td>
                    <td style="width: 75%;">
                        <div class="progress">
                            <?php

                            foreach ($atdCount as $c) {
                                if ($m->meeting_id == $c->meeting_id) {
                                    $count = $c->total;
                                }
                            }
                            $i = 1;
                            $stp;
                            foreach ($atdDetail as $a) {
                                if ($a->meeting_id == $m->meeting_id) {
                                    $diff = strtotime($a->join_time) - strtotime($start_time);

                                    if ($diff > 0) {
                                        $dt_join = DateTime::createFromFormat("Y-m-d H:i:s", $start_time);
                                        $dt_leave = DateTime::createFromFormat("Y-m-d H:i:s", $a->join_time);
                                        $t1 = $dt_join->format('H:i');
                                        $t2 = $dt_leave->format('H:i'); ?>
                                        <div class="progress-bar bar-red" role="progressbar" style="width: <?= ($diff / $totalDuration) * 100; ?>%; " aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="<?= $t1 ?>-<?= $t2 ?>"></div>
                                    <?php
                                    }
                                    $diff = strtotime($a->leave_time) - strtotime($a->join_time);
                                    if ($diff > 0) {
                                        $dt_join = DateTime::createFromFormat("Y-m-d H:i:s", $a->join_time);
                                        $dt_leave = DateTime::createFromFormat("Y-m-d H:i:s", $a->leave_time);
                                        $t1 = $dt_join->format('H:i');
                                        $t2 = $dt_leave->format('H:i'); ?>
                                        <div class=" progress-bar bar-green" role="progressbar" style="width: <?= ($diff / $totalDuration) * 100; ?>%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="<?= $t1 ?>-<?= $t2 ?>"></div>
                                        <?php
                                    }
                                    if ($i == $count) {
                                        $diff = strtotime($end_time) - strtotime($a->leave_time);
                                        if ($diff > 0) {
                                            $dt_join = DateTime::createFromFormat("Y-m-d H:i:s", $a->leave_time);
                                            $dt_leave = DateTime::createFromFormat("Y-m-d H:i:s", $end_time);
                                            $t1 = $dt_join->format('H:i');
                                            $t2 = $dt_leave->format('H:i'); ?>
                                            <div class="progress-bar bar-red" role="progressbar" style="width: <?= ($diff / $totalDuration) * 100; ?>%; " aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="<?= $t1 ?>-<?= $t2 ?>"></div>
                            <?php
                                        }
                                    }

                                    $start_time = $a->leave_time;

                                    $i++;
                                }
                            } ?>
                        </div>
                    </td>
                </tr><?php
                    } ?>

        <?php } ?>


    </table>
</div>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!-- <tr>
                <td style="width: 25%;">Meeting 1</td>
                <td style="width: 75%;">
                    <div class="progress">
                        <div class="progress-bar bar-green" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bar-red" role="progressbar" style="width: 30%; " aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bar-green" role="progressbar" style="width: 55%; " aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>
            </tr> -->


<?= $this->endSection(); ?>