<?php


namespace Source\controllers;

use Source\models\Melhoria;
use Source\models\Project;
use Source\models\Group;
use Source\models\UserGroup;
use Source\models\User;
use League\Csv\Writer;
use League\Csv\Reader;
use DateTimeZone;


require_once(DBAPI);


class ResgateMelhoria
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
            "Nome",
            "Matricula",
            "Grupo",
            "Valor Integrante",
            "Valor Grupo"
        ]);

        $melhoria = find_query("select sum(Melhoria.ValorMelhoria) as valor, usuarios.nome, Grupo.name_group, usuarios.matricula ,Grupo.id as idgrupo
from Melhoria, Grupo, usuariogrupo,usuarios 
where usuariogrupo.idgrupo = Grupo.id and usuariogrupo.idusuario = usuarios.id 
and Melhoria.IdGrupo = Grupo.id and Melhoria.status = 5 and Melhoria.resgatado < 1 or usuariogrupo.idgrupo = Grupo.id and usuariogrupo.idusuario = usuarios.id 
and Melhoria.IdGrupo = Grupo.id and Melhoria.status = 5 and Melhoria.resgatado is null
group by usuarios.nome, Grupo.name_group, usuarios.matricula ,Grupo.id");


        foreach ($melhoria as $mel) {
            $valor = 0;
            $idgrupo = $mel['idgrupo'];
            $projeto = find_query("select sum(Project.ValorProjeto) as valor, usuarios.nome, Grupo.name_group, usuarios.matricula 
from Project, Grupo, usuariogrupo,usuarios 
where usuariogrupo.idgrupo = Grupo.id and Project.idGrupo = grupo.id and usuariogrupo.idusuario = usuarios.id and Grupo.id = $idgrupo and Project.Status = 5 and Project.resgatado < 1
or usuariogrupo.idgrupo = Grupo.id and Project.idGrupo = grupo.id and usuariogrupo.idusuario = usuarios.id and Grupo.id = $idgrupo and Project.Status = 5 and Project.resgatado is null
group by usuarios.nome, Grupo.name_group, usuarios.matricula");

            $count = find_query("select count(id) as integrantes from usuariogrupo where idgrupo = $idgrupo");

            foreach ($count as $item) {
                $result = $item['integrantes'];
            }

            if ($result < 3) {
                $result = 3;
            }

            foreach ($projeto as $proj) {
                $valor = $proj['valor'] + $mel['valor'];
            }
            if ($valor == 0) {
                $valor = $mel['valor'];
            }
            $valor1 = number_format($valor, 2, ",", ".");
            $valor = number_format($valor / $result, 2, ",", ".");

            $csv->insertOne([

                $mel["nome"],
                $mel["matricula"],
                $mel["name_group"],
                'R$ ' . $valor,
                'R$ ' . $valor1
            ]);

        }

        $csv->output($data . "-resgate.csv");
    }

    public function confirmarresgate()
    {


        $melhorias = new Melhoria();
        $projects = new Project();

        $mel = $melhorias->find("status = 5 and resgatado < 1 or status = 5 and resgatado is null")->fetch(true);
        $project = $projects->find("Status = 5 and resgatado < 1 or Status = 5 and resgatado is null")->fetch(true);


        foreach ($mel as $value) {
            $melhoria = (new Melhoria())->findById($value->id);
            $melhoria->resgatado = 1;
            $melhoria->data_resgate = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y-m-d");
            $melhoria->save();
        }
        foreach ($project as $item) {
            $projeto = (new Project())->findById($item->id);
            $projeto->resgatado = 1;
            $projeto->data_resgate = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y-m-d");
            $projeto->save();
        }

        header("location: index.php");


    }

    public function melhoria($idgrupo)
    {
        $melhoria = new Melhoria();

        $melhorias = $melhoria->find("IdGrupo = $idgrupo and status = 5 and resgatado < 1 or IdGrupo = $idgrupo and status = 5 and resgatado is null  ")->fetch(true);
        $valor = 0;

        if (!empty($melhorias)) {
            foreach ($melhorias as $mel) {
                $valor += $mel->ValorMelhoria;
            }
        } else
            $valor = 0.00;

        return $valor;

    }

    public function projeto($idgrupo)
    {
        $project = new Project();
        $projetos = $project->find("idGrupo = $idgrupo and Status = 5 and resgatado < 1 or idGrupo = $idgrupo and Status = 5 and resgatado is null ")->fetch(true);
        $valor = 0;
        if (!empty($projetos)) {
            foreach ($projetos as $projeto) {
                $valor += $projeto->ValorProjeto;
            }
        } else {
            $valor = 0.00;
        }
        return $valor;
    }
    public function melhoriaResgatado($idgrupo)
    {
        $melhoria = new Melhoria();

        $melhorias = $melhoria->find("IdGrupo = $idgrupo and status = 5 and resgatado = 1")->fetch(true);
        $valor = 0;

        if (!empty($melhorias)) {
            foreach ($melhorias as $mel) {
                $valor += $mel->ValorMelhoria;
            }
        } else
            $valor = 0.00;

        return $valor;
    }

    public function projetoResgatado($idgrupo)
    {
        $project = new Project();
        $projetos = $project->find("idGrupo = $idgrupo and Status = 5 and resgatado = 1")->fetch(true);
        $valor = 0;
        if (!empty($projetos)) {
            foreach ($projetos as $projeto) {
                $valor += $projeto->ValorProjeto;
            }
        } else {
            $valor = 0.00;
        }
        return $valor;

    }
}