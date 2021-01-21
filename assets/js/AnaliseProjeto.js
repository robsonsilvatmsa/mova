function analiseSup() {
    document.getElementById("Avaliacao").style.display = '';
    document.getElementById("rdbsup").setAttribute("required", "true");
    document.getElementById("txtsuper").setAttribute("required", "true");
}

function analisaEng() {
    document.getElementById("AvaliacaoEng").style.display = '';
    document.getElementById("rdbengind").setAttribute("required", "true");
    document.getElementById("txtEng").setAttribute("required", true);
}

function analisaSesmt() {
    document.getElementById("AvaliacaoSesmt").style.display = '';
    document.getElementById("rdbsesmt").setAttribute("required", "true");
    document.getElementById("txtSesmt").setAttribute("required", true);
}

function ocultaranaliseSup() {
    document.getElementById("Avaliacao").style.display = 'none';
    document.getElementById("rdbsup").required = false;
    document.getElementById("txtsuper").required = false;
}

function ocultaranalisaEng() {
    document.getElementById("AvaliacaoEng").style.display = 'none';
    document.getElementById("rdbengind").required = false;
    document.getElementById("txtEng").required = false;
}

function ocultaranalisaSesmt() {
    document.getElementById("AvaliacaoSesmt").style.display = 'none';
    document.getElementById("rdbsesmt").required = false;
    document.getElementById("txtSesmt").required = false;
}

function analisaQualidade() {


    document.getElementById("AvaliacaoQualidade").style.display = '';
    document.getElementById("rdbquali").setAttribute("required", "true");
    document.getElementById("txtQuali").setAttribute("required", true);


}

function ocultarqual() {
    document.getElementById("AvaliacaoQualidade").style.display = 'none';
    document.getElementById("rdbquali").required = false;
    document.getElementById("txtQuali").required = false;
}

function obrigatorioSup() {
    document.getElementById("txtsuper").setAttribute("required", true);
}

function obrigatorioEng() {
    document.getElementById("txtEng").setAttribute("required", true);
}

function obrigatorioSesmt() {
    document.getElementById("txtSesmt").setAttribute("required", true);
}

function obrigatorioQualidade() {
    document.getElementById("txtQuali").setAttribute("required", true);
}