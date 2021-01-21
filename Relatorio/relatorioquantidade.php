<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();


//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">


    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Relatório quantidade de melhoria por área</h2>
        </header>
        <div class="panel-body">
            <div class="form-group">


                <div class="input-daterange input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                    <input id="to" type="date" class="form-control" name="start" onchange="grafico()"/>
                    <span class="input-group-addon">to</span>
                    <input id="end" type="date" class="form-control" name="end" onchange="grafico()"/>

                </div>
            </div>
            <div class="table-striped">


                <table class="table table-bordered table-striped mb-md">
                    <thead>
                    <tr>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="panel-body">

                                <!-- Morris: Bar -->

                                <div class="chart chart-lg" id="graf"></div>

                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Relatório quantidade de projeto por área</h2>
        </header>
        <div class="panel-body">
            <div class="form-group">


                <div class="input-daterange input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                    <input id="to1" type="date" class="form-control" name="start" onchange="grafico1()"/>
                    <span class="input-group-addon">to</span>
                    <input id="end1" type="date" class="form-control" name="end" onchange="grafico1()"/>

                </div>
            </div>
            <div class="table-striped">


                <table class="table table-bordered table-striped mb-md">
                    <thead>
                    <tr>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="panel-body">

                                <!-- Morris: Bar -->

                                <div class="chart chart-lg" id="graf1"></div>

                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <a href="index.php" class="btn btn-success ">Voltar</a>
        </div>
    </section>
</section>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    function grafico() {

        var to = "";
        var end = "";
        if ($('#to').val()) {
            to = $('#to').val();
        } else {
            to = "";
        }
        if ($('#end').val()) {
            end = $('#end').val();
        } else {
            end = "";
        }

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {

            var i = 0;
            $.ajax({
                type: "POST",
                url: 'relatorioquantidademelhoria.php?to=' + to + "&end=" + end,
                dataType: 'json',
                success: function (data) {


                    console.log(data);

                    dados = [['Area', 'Quantidade', {role: 'annotation'}]];

                    $.each(data, function () {
                        if (parseFloat(data["total"]) > i) {
                            dados.push([data["nome" + i], parseFloat(data["Valor" + i]), data["rotulo" + i]]);
                            i++
                        }

                    });


                    console.log(dados);
                    var dat = google.visualization.arrayToDataTable(dados);
                    var options = {
                        title: 'Medições por meses',

                        vAxis: {gridlines: {count: 10}, minValue: 0},
                        seriesType: 'bars',
                        colors: ['#0092FD', 'red'],
                        legend: {position: 'bottom'},
                        series: {
                            1: {
                                type: 'line'
                            }
                        },

                    };
                    var chart = new google.visualization.ComboChart(document.getElementById('graf'));
                    chart.draw(dat, options);
                },
                error: function () {
                    //console.log(info + "&idproc=" + idprocesso);
                    //alert("Não Foi Possível Abrir o Indicador");
                }
            });
        }
    }

    function grafico1() {

        var to = "";
        var end = "";
        if ($('#to1').val()) {
            to = $('#to1').val();
        } else {
            to = "";
        }
        if ($('#end1').val()) {
            end = $('#end1').val();
        } else {
            end = "";
        }

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualization1);

        function drawVisualization1() {

            var i = 0;
            $.ajax({
                type: "POST",
                url: 'relatorioquantidadeprojeto.php?to=' + to + "&end=" + end,
                dataType: 'json',
                success: function (data) {


                    console.log(data);

                    dados = [['Area', 'Quantidade', {role: 'annotation'}]];

                    $.each(data, function () {
                        if (parseFloat(data["total"]) > i) {
                            dados.push([data["nome" + i], parseFloat(data["Valor" + i]), data["rotulo" + i]]);
                            i++
                        }

                    });


                    console.log(dados);
                    var dat = google.visualization.arrayToDataTable(dados);
                    var options = {
                        title: 'Medições por meses',

                        vAxis: {gridlines: {count: 10}, minValue: 0},
                        seriesType: 'bars',
                        colors: ['#0092FD', 'red'],
                        legend: {position: 'bottom'},
                        series: {
                            1: {
                                type: 'line'
                            }
                        },

                    };
                    var chart = new google.visualization.ComboChart(document.getElementById('graf1'));
                    chart.draw(dat, options);
                },
                error: function () {
                    //console.log(info + "&idproc=" + idprocesso);
                    //alert("Não Foi Possível Abrir o Indicador");
                }
            });
        }
    }


</script>
<?php include(FOOTER_TEMPLATE); ?>

