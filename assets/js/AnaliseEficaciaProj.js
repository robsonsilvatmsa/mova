function analiseSup() {
    document.getElementById("Avaliacao").style.display = '';
    document.getElementById("Eficacia").style.display = 'none';
    document.getElementById("rdbproblema").required = false;
    document.getElementById("rdbproblema1").required = false;
    document.getElementById("rdbmetodo").required = false;
    document.getElementById("rdbmetodo1").required = false;
    document.getElementById("rdbcausa").required = false;
    document.getElementById("rdbcausa1").required = false;
    document.getElementById("rdpprojeto").required = false;
    document.getElementById("rdpprojeto1").required = false;
    document.getElementById("rdbresultado").required = false;
    document.getElementById("rdbresultado1").required = false;
    document.getElementById("rdbabrproj").required = false;
    document.getElementById("rdbabrproj1").required = false;
    document.getElementById("rdbabrsolucao").required = false;
    document.getElementById("rdbabrsolucao1").required = false;
    document.getElementById("txtAvaliacao").setAttribute("required", true);
    document.getElementById("txtAvaliacao1").setAttribute("required", true);
    document.getElementById("txtAvaliacao2").setAttribute("required", true);
    document.getElementById("txtsuper").setAttribute("required", true);
}

function obrigatorioSup() {
    document.getElementById("txtsuper").setAttribute("required", true);
}

function eficacia() {
    document.getElementById("Eficacia").style.display = '';
    document.getElementById("Avaliacao").style.display = 'none';
    document.getElementById("rdbproblema").setAttribute("required", true);
    document.getElementById("rdbproblema1").setAttribute("required", true);
    document.getElementById("rdbmetodo").setAttribute("required", true);
    document.getElementById("rdbmetodo1").setAttribute("required", true);
    document.getElementById("rdbcausa").setAttribute("required", true);
    document.getElementById("rdbcausa1").setAttribute("required", true);
    document.getElementById("rdpprojeto").setAttribute("required", true);
    document.getElementById("rdpprojeto1").setAttribute("required", true);
    document.getElementById("rdbresultado").setAttribute("required", true);
    document.getElementById("rdbresultado1").setAttribute("required", true);
    document.getElementById("rdbabrproj").setAttribute("required", true);
    document.getElementById("rdbabrproj1").setAttribute("required", true);
    document.getElementById("rdbabrsolucao").setAttribute("required", true);
    document.getElementById("rdbabrsolucao1").setAttribute("required", true);
    document.getElementById("txtAvaliacao").required = false;
    document.getElementById("txtAvaliacao1").required = false;
    document.getElementById("txtAvaliacao2").required = false;
}