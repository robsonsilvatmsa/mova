window.onload = function () {
    $.ajax({
        type: "POST",
        url: "carregarinformacoes.php?id=" + $("#codPA").val(),
        success: function (data) {
            console.log(data);
            $("#aqui").html(data);
        }
    });
};