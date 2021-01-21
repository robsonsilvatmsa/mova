function analiseSup() {
    document.getElementById("Avaliacao").style.display = '';
    document.getElementById("Eficacia").style.display = 'none';
    document.getElementById("rdbResultadomel").required = false;
    document.getElementById("rdbResultadomel1").required = false;
    document.getElementById("rdbResultadogrupo").required = false;
    document.getElementById("rdbResultadogrupo1").required = false;
    document.getElementById("rdbAbrang").required = false;
    document.getElementById("rdbAbrang1").required = false;
    document.getElementById("rdbInovacao").required = false;
    document.getElementById("rdbInovacao1").required = false;
    document.getElementById("txtAvaliacao").setAttribute("required", true);
    document.getElementById("txtAvaliacao1").setAttribute("required", true);
    document.getElementById("txtAvaliacao2").setAttribute("required", true);
}

function obrigatorioSup() {
    document.getElementById("txtsuper").setAttribute("required", true);
}

function eficacia() {
    document.getElementById("Eficacia").style.display = '';
    document.getElementById("Avaliacao").style.display = 'none';
    document.getElementById("rdbResultadomel").setAttribute("required", true);
    document.getElementById("rdbResultadomel1").setAttribute("required", true);
    document.getElementById("rdbResultadogrupo").setAttribute("required", true);
    document.getElementById("rdbResultadogrupo1").setAttribute("required", true);
    document.getElementById("rdbAbrang").setAttribute("required", true);
    document.getElementById("rdbAbrang1").setAttribute("required", true);
    document.getElementById("rdbInovacao").setAttribute("required", true);
    document.getElementById("rdbInovacao1").setAttribute("required", true);
    document.getElementById("txtAvaliacao").required = false;
    document.getElementById("txtAvaliacao1").required = false;
    document.getElementById("txtAvaliacao2").required = false;
}