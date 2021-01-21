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

            <h2 class="panel-title">Relatório quantidade de projeto por grupo</h2>
        </header>
        <div class="panel-body">
            <div class="form-group">

                <form action="exportarusuarioarea.php" method="post">
                    <input type="submit" class="btn btn-success" value="Exportar"/>
                </form>
            </div>
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-lg">
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
            <a href="index.php" class="btn btn-success ">Voltar</a>
        </div>

    </section>

</section>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">


    window.onload = function () {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {

            var i = 0;
            $.ajax({
                type: "POST",
                url: 'relatorioenganjamento.php',
                dataType: 'json',
                success: function (data) {


                    console.log(data);

                    dados = [['Area', 'Quantidade', {role: 'annotation'}]];

                    $.each(data, function () {
                        if (parseFloat(data["total"]) > i) {
                            dados.push([data["nome" + i], parseFloat(data["Valor" + i]), data["rotulo" + i] + "%"]);
                            i++
                        }

                    });


                    console.log(dados);
                    var dat = google.visualization.arrayToDataTable(dados);
                    var options = {
                        title: 'Medições De Enganjamento Por Área',
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


</script>
<?php include(FOOTER_TEMPLATE); ?>

