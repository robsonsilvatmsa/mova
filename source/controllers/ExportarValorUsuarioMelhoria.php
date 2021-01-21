<?php


namespace Source\controllers;

use DateTimeZone;
use League\Csv\Reader;
use League\Csv\Writer;


require_once(DBAPI);


class ExportarValorUsuarioMelhoria
{
    /**
     * 0=>Aguardando Adm
     * 1=>Em Analise
     * 2=>Aprovado
     * 3=>Finalizado
     * 4=>Rejeitado
     * 5=>Eficaz
     */
    public function exportar($to, $end)
    {

        $data = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "d-m-Y H:i:s");

        $csv = Writer::createFromString('');
        $csv->setDelimiter(';');
        $csv->setOutputBOM(Reader::BOM_UTF8);
        $csv->insertOne([
            "Nome",

            "Valor Integrante",

        ]);

        $melhoria = find_query("	
	SELECT
case 
when ((SELECT
    COUNT(ID)
  FROM usuariogrupo
  WHERE usuariogrupo.idgrupo = Melhoria.idGrupo)) >= 3 then 
  (SUM(Melhoria.ValorMelhoria) / (SELECT COUNT(ID)
  FROM usuariogrupo WHERE usuariogrupo.idgrupo = Melhoria.idGrupo
  ))
  else (SUM(Melhoria.ValorMelhoria)/3)
  END AS Valor,
  usuarios.nome,
  Melhoria.idGrupo
FROM Melhoria,
     usuarios,
     usuariogrupo,
     Grupo
WHERE Melhoria.idGrupo = usuariogrupo.idgrupo
AND usuarios.id = usuariogrupo.idusuario
AND Grupo.id = Melhoria.idGrupo
AND Grupo.id = usuariogrupo.idgrupo
AND Melhoria.data_resgate  between '$to' and  '$end'
GROUP BY usuarios.nome,
         Melhoria.idGrupo

");


        foreach ($melhoria as $mel) {

            $valor = number_format($mel["Valor"], 2, ",", ".");
            $csv->insertOne([

                $mel["nome"],
                'R$ ' . $valor,

            ]);

        }

        $csv->output($data . "-valorusuariomelhoria.csv");
    }

}