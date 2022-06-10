<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>

<!-- information summary container -->
<div class="d-flex justify-content-around summaryboard" style="background: #<?= $class[0]->COLOR; ?>">
    <div class="p-2">
        <h1 class="f32"><?= $class[0]->TITLE_CLASS; ?></h1>
        <p class="f20"><?= $class[0]->ROOM; ?> <?= $class[0]->DETAIL_CLASS; ?></p>
        <button>+ Add Meeting</button>
    </div>
    <div class="p-2 d-flex justify-content-between">
        <div class="p-2 center">
            <h2 class="f64"><?= $avg_atd[0]->averageAtd * 100; ?>%</h2>
            <p class="f20">Average Attendance</p>
        </div>
        <div class="p-2 center">
            <h2 class="f64"><?= $total_ptc[0]->PARTICIPANTS; ?></h2>
            <p class="f20">Students</p>
        </div>
    </div>
</div>

<div class="maincontent">
    <div class="row">
        <div class="col-12 col-lg-6">
            <h1 class="f24">Overall Attendance</h1>
            <div class="line m-y-5"></div>
            <div id="donutchart" class="donut"></div>
        </div>
        <div class="col-12 col-lg-6">
            <h1 class="f24">Top 5</h1>
            <div class="line"></div>
            <div class="row py-3">
                <div class="col-12 col-md-6">
                    <table class="table">
                        <tr style="background: rgba(100, 203, 178, 0.7);">
                            <th scope="col">In Time</th>
                            <th scope="col">Meeting(s)</th>
                        </tr>
                        <?php foreach ($InTime_atd as $u) { ?>
                            <tr style="background: #F0F1F4;">
                                <td><?= $u->ptc_name; ?></td>
                                <td align="center"><?= $u->total_present; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <table class="table">
                        <tr style="background: #E15252;">
                            <th scope="col">Absent</th>
                            <th scope="col">Meeting(s)</th>
                        </tr>
                        <?php foreach ($absent_atd as $u) { ?>
                            <tr style="background: #F0F1F4;">
                                <td><?= $u->ptc_name; ?></td>
                                <td align="center"><?= $u->total_absent; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <table class="table">
                        <tr style="background: #E9974B;">
                            <th scope="col">Late</th>
                            <th scope="col">Minute(s)</th>
                        </tr>
                        <?php foreach ($late_atd as $u) { ?>
                            <tr style="background: #F0F1F4;">
                                <td><?= $u->ptc_name; ?></td>
                                <td align="center"><?= (int) $u->late; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <table class="table">
                        <tr style="background: #5A76D7;">
                            <th scope="col">Join&Leave</th>
                            <th scope="col">Time(s)</th>
                        </tr>
                        <?php foreach ($join_leave as $u) { ?>
                            <tr style="background: #F0F1F4;">
                                <td><?= $u->ptc_name; ?></td>
                                <td align="center"><?= (int) $u->join_times; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="tableAtd">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h3>Attendance Data Table</h3>

                    <ul class="list-unstyled">
                        <li>Legend Icons :
                            <ul>
                                <li>
                                    <i class="bi bi-person-check-fill col-green"></i> : In Time
                                </li>
                                <li>
                                    <i class="bi bi-person-x-fill col-red"></i> : Absent
                                </li>
                                <li>
                                    <i class="bi bi-person-dash-fill col-orange"></i> : Late
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <form class="form-inline" method="POST" action="<?= site_url('attendance') ?>">
                        <label for="late" class="mb-2 mr-sm-2 text-wight-bold">Lateness Tolerances <small> (minutes)</small>
                        </label>
                        <input type="number" class="form-control mb-2 mr-sm-2" id="late" name="lt" value="<?= $late ?>">
                        <span class="mx-2"></span>
                        <label for="presenceTime" class="mb-2 mr-sm-2 text-wight-bold">Minimum Presence Time in a Meeting <small> (percentage)</small></label>
                        <input type="number" class="form-control mb-2 mr-sm-2" id="presenceTime" name="pm" value="<?= $percentMin * 100 ?>">
                        <button type="submit" class="btn btn-primary mb-2">Apply</button>
                    </form>

                    <div class="table-responsive">
                        <table id="example" class="table-attendance table table-bordered">
                            <thead id="calendar-head">

                                <tr align="center">
                                    <th>Participants Name</th>

                                    <?php foreach ($meetings as $m) { ?>
                                        <th><?= $m->meeting_id; ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody id="calendar-body">
                                <?php foreach ($participants as $p) { ?>
                                    <tr>
                                        <th><a href="<?= site_url(['attendance', 'detail', $p->ptc_id, $percentMin]); ?>"><?= $p->ptc_name; ?></a></th>
                                        <?php foreach ($meetings as $m) {
                                            $status = 0;
                                            foreach ($atdMeetings as $at) {
                                                if ($at->MEETING_ID == $m->meeting_id && $at->PTC_NAME == $p->ptc_name) {
                                                    $status = $at->status;
                                                }
                                            }

                                            if ($status == 0) { ?>
                                                <th><i class="bi bi-person-x-fill col-red"></i></th>
                                            <?php } elseif ($status == 1) { ?> <th><i class="bi bi-person-check-fill col-green"></i></th>

                                            <?php } else { ?>
                                                <th><i class="bi bi-person-dash-fill col-orange"></i></th>
                                        <?php }
                                        } ?>

                                    <tr> <?php } ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Participants Name</th>

                                    <?php foreach ($meetings as $m) { ?>
                                        <th><?= $m->meeting_id; ?></th>
                                    <?php } ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php foreach ($diagram as $u) { ?>['<?= $u->label; ?>', <?= $u->total; ?>],

            <?php } ?>
        ]);

        var options = {
            pieHole: 0.6,
            colors: ['#64CBB2', '#E9974B', '#E15252']
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>

<script>
    $(document).ready(function() {
        console.log("Hello!");

        $("#example").DataTable({
            scrollY: 200,
            scrollX: true,
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function() {
                        var column = this;
                        console.log(
                            "column : ",
                            column.header().innerText,
                            " cek columns : ",
                            column.header().innerText == "Employee Name"
                        );

                        if (column.header().innerText == "Employee Name") {
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                // .appendTo($("#filterDataTable"))
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    console.log("Value table : ", val);
                                    column.search(val ? "^" + val + "$" : "", true, false).draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append('<option value="' + d + '">' + d + "</option>");
                                });
                        }
                    });
            }
        });
    });
</script>


<?= $this->endSection(); ?>