<?php


namespace Source\controllers;

use DateTimeZone;
use League\Csv\Reader;
use League\Csv\Writer;


require_once(DBAPI);


class ExportarUsuarioArea
{
    /**
     * 0=>Aguardando Adm
     * 1=>Em Analise
     * 2=>Aprovado
     * 3=>Finalizado
     * 4=>Rejeitado
     * 5=>Eficaz
     */
    public function exportar()
    {

        $data = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "d-m-Y H:i:s");

        $csv = Writer::createFromString('');
        $csv->setDelimiter(';');
        $csv->setOutputBOM(Reader::BOM_UTF8);
        $csv->insertOne([
            "Área",

            "Percentual Por Área",

        ]);

        $melhoria = find_query("	
select
((count(gr.idgrupo)*100) / (
   select
      count(id) 
   from
      usuarios 
   where
      usuarios.cc = usu.cc 
      and usuarios.situacaosenior <> '7-Demitido')) as 'Total',
      usu.cc_descricao 
   from
      usuariogrupo as gr,
      usuarios as usu 
   where
      usu.id = gr.idusuario 
      and usu.situacaosenior <> '7-Demitido' 
   group by
      usu.cc_descricao,
      usu.cc
   order by Total desc


");


        foreach ($melhoria as $mel) {

            $valor = $mel["Total"];
            $csv->insertOne([

                $mel["cc_descricao"],
                $valor . " %",

            ]);

        }

        $csv->output($data . "-enganjamentoarea.csv");
    }

}