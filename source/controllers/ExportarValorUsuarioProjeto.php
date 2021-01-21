<?php


namespace Source\controllers;

use DateTimeZone;
use League\Csv\Reader;
use League\Csv\Writer;


require_once(DBAPI);


class ExportarValorUsuarioProjeto
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
      WHERE usuariogrupo.idgrupo = Project.idGrupo)) >= 3 then 
      (SUM(Project.ValorProjeto) / (SELECT COUNT(ID)
      FROM usuariogrupo WHERE usuariogrupo.idgrupo = Project.idGrupo
      ))
      else (SUM(Project.ValorProjeto)/3)
      END AS Valor,
      usuarios.nome,
      Project.idGrupo
    FROM Project,
         usuarios,
         usuariogrupo,
         Grupo
    WHERE Project.idGrupo = usuariogrupo.idgrupo
    AND usuarios.id = usuariogrupo.idusuario
    AND Grupo.id = Project.idGrupo
    AND Grupo.id = usuariogrupo.idgrupo
    AND Project.data_resgate  between '$to' and  '$end'
    GROUP BY usuarios.nome,
             Project.idGrupo
    order by Valor desc


");


        foreach ($melhoria as $mel) {

            $valor = number_format($mel["Valor"], 2, ",", ".");
            $csv->insertOne([

                $mel["nome"],
                'R$ ' . $valor,

            ]);

        }

        $csv->output($data . "-valorusuarioprojeto.csv");
    }

}