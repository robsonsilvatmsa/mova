/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function lostfocus() {
    $(document).ready(function () {
        var smatricula = $("#matriculaintegrante1").val();
        $.ajax({
            type: "POST",
            url: 'carregardadosusuarios.php?matricula=' + smatricula,
            dataType: 'json',
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                console.log(data);
                $('#membername1').val(data.NOME);
                $('#ccintegrante1').val(data.CC);
                $('#idmember1').val(data.ID);
                $('#matriculaintegrante2').focus();
            },
            complete: function (data) {
                $("#loader").hide();
            },
            error: function () {
                alert("Matricula não localizada!");
            }
        });
    });
}

function lostfocus1() {
    $(document).ready(function () {
        var smatricula = $("#matriculaintegrante2").val();
        $.ajax({
            type: "POST",
            url: 'carregardadosusuarios.php?matricula=' + smatricula,
            dataType: 'json',
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                console.log(data);
                $('#membername2').val(data.NOME);
                $('#ccintegrante2').val(data.CC);
                $('#idmember2').val(data.ID);
            },
            complete: function (data) {
                $("#loader").hide();
            },
            error: function () {
                alert("Matricula não localizada!");
            }
        });
    });
}
