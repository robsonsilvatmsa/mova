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
                if (data.adicionado === true) {
                    alert(data.NOME + "  " + "Já Está em um grupo")
                    $('#matriculaintegrante1').val("");
                    $('#matriculaintegrante1').focus();
                } else {


                    if ($('#idmember2').val() === data.ID || $('#idmember3').val() === data.ID ||
                        $('#idmember4').val() === data.ID || $('#idmember5').val() === data.ID ||
                        $('#idmember6').val() === data.ID) {

                        alert(data.NOME + "  " + "Já adicionado")
                        $('#matriculaintegrante1').val("");
                        $('#matriculaintegrante1').focus();

                    } else {
                        $('#membername1').val(data.NOME);
                        $('#ccintegrante1').val(data.CC);
                        $('#idmember1').val(data.ID);
                        $('#matriculaintegrante2').focus();
                    }
                }

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
                if (data.adicionado === true) {
                    alert(data.NOME + "  " + "Já Está em um grupo")
                    $('#matriculaintegrante2').val("");
                    $('#matriculaintegrante2').focus();
                } else {
                    if ($('#idmember1').val() === data.ID || $('#idmember3').val() === data.ID ||
                        $('#idmember4').val() === data.ID || $('#idmember5').val() === data.ID ||
                        $('#idmember6').val() === data.ID) {
                    } else {
                        $('#membername2').val(data.NOME);
                        $('#ccintegrante2').val(data.CC);
                        $('#idmember2').val(data.ID);
                        $('#matriculaintegrante3').focus();
                    }

                }

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

function lostfocus2() {
    $(document).ready(function () {
        var smatricula = $("#matriculaintegrante3").val();
        $.ajax({
            type: "POST",
            url: 'carregardadosusuarios.php?matricula=' + smatricula,
            dataType: 'json',
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                console.log(data);
                if (data.adicionado === true) {
                    alert(data.NOME + "  " + "Já Está em um grupo")
                    $('#matriculaintegrante3').val("");
                    $('#matriculaintegrante3').focus();
                } else {
                    if ($('#idmember2').val() === data.ID || $('#idmember1').val() === data.ID ||
                        $('#idmember4').val() === data.ID || $('#idmember5').val() === data.ID ||
                        $('#idmember6').val() === data.ID) {
                    } else {
                        $('#membername3').val(data.NOME);
                        $('#ccintegrante3').val(data.CC);
                        $('#idmember3').val(data.ID);
                        $('#matriculaintegrante4').focus();
                    }
                }
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

function lostfocus3() {
    $(document).ready(function () {
        var smatricula = $("#matriculaintegrante4").val();
        $.ajax({
            type: "POST",
            url: 'carregardadosusuarios.php?matricula=' + smatricula,
            dataType: 'json',
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                console.log(data);
                if (data.adicionado === true) {
                    alert(data.NOME + "  " + "Já Está em um grupo")
                    $('#matriculaintegrante4').val("");
                    $('#matriculaintegrante4').focus();
                } else {
                    if ($('#idmember2').val() === data.ID || $('#idmember3').val() === data.ID ||
                        $('#idmember1').val() === data.ID || $('#idmember5').val() === data.ID ||
                        $('#idmember6').val() === data.ID) {

                        $('#matriculaintegrante4').val("");
                        $('#matriculaintegrante4').focus();
                        
                    } else {
                        $('#membername4').val(data.NOME);
                        $('#ccintegrante4').val(data.CC);
                        $('#idmember4').val(data.ID);
                        $('#matriculaintegrante5').focus();
                    }
                }
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

function lostfocus4() {
    $(document).ready(function () {
        var smatricula = $("#matriculaintegrante5").val();
        $.ajax({
            type: "POST",
            url: 'carregardadosusuarios.php?matricula=' + smatricula,
            dataType: 'json',
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                console.log(data);
                if (data.adicionado === true) {
                    alert(data.NOME + "  " + "Já Está em um grupo")
                    $('#matriculaintegrante5').val("");
                    $('#matriculaintegrante5').focus();
                } else {
                    if ($('#idmember2').val() === data.ID || $('#idmember3').val() === data.ID ||
                        $('#idmember4').val() === data.ID || $('#idmember1').val() === data.ID ||
                        $('#idmember6').val() === data.ID) {

                        $('#matriculaintegrante5').val("");
                        $('#matriculaintegrante5').focus();

                    } else {
                        $('#membername5').val(data.NOME);
                        $('#ccintegrante5').val(data.CC);
                        $('#idmember5').val(data.ID);
                        $('#matriculaintegrante6').focus();
                    }
                }
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

function lostfocus5() {
    $(document).ready(function () {
        var smatricula = $("#matriculaintegrante6").val();
        $.ajax({
            type: "POST",
            url: 'carregardadosusuarios.php?matricula=' + smatricula,
            dataType: 'json',
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                console.log(data);
                if (data.adicionado === true) {
                    alert(data.NOME + "  " + "Já Está em um grupo")
                    $('#matriculaintegrante6').val("");
                    $('#matriculaintegrante6').focus();
                } else {
                    if ($('#idmember2').val() === data.ID || $('#idmember3').val() === data.ID ||
                        $('#idmember4').val() === data.ID || $('#idmember5').val() === data.ID ||
                        $('#idmember1').val() === data.ID) {
                        $('#matriculaintegrante6').val("");
                        $('#matriculaintegrante6').focus();
                    } else {


                        $('#membername6').val(data.NOME);
                        $('#ccintegrante6').val(data.CC);
                        $('#idmember6').val(data.ID);
                    }
                }
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
