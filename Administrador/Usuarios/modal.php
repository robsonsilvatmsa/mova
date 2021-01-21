<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <title>Example</title>
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
        <style>
            /*Regra para a animacao*/
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            /*Mudando o tamanho do icone de resposta*/
            div.glyphicon {
                color:#6B8E23;
                font-size: 38px;
            }
            /*Classe que mostra a animacao 'spin'*/
            .loader {
              border: 16px solid #f3f3f3;
              border-radius: 50%;
              border-top: 16px solid #3498db;
              width: 30px;
              height: 30px;
              -webkit-animation: spin 2s linear infinite;
              animation: spin 2s linear infinite;
            }
        </style>
        <script>
            $(function () {
                //Comportamento do botao de disparo
                $('#btn-getResponse').click(function () {
                    getResponse();
                });
            });

            /**
             * Dispara o modal e espera a resposta do script 'testing.resp.php'
             * @returns {void}
             */
            function getResponse() {
                //Preenche e mostra o modal
                $('#loadingModal_content').html('Atualizando registros ...');
                $('#loadingModal').modal('show');
                //Envia a requisicao e espera a resposta
                $.post("importausuarios.php")
                    .done(function () {
                        //Se nao houver falha na resposta, preenche o modal
                        $('#loader').removeClass('loader');
                        $('#loader').addClass('glyphicon glyphicon-ok');
                        $('#loadingModal_label').html('Sucesso!');
                        $('#loadingModal_content').html('<br>Tarefa executada com sucesso!');
                        resetModal();
                    })
                    .fail(function () {
                        //Se houver falha na resposta, mostra o alert
                        $('#loader').removeClass('loader');
                        $('#loader').addClass('glyphicon glyphicon-remove');
                        $('#loadingModal_label').html('Falha!');
                        $('#loadingModal_content').html('<br>Falha na execução da tarefa!');
                        resetModal();
                    });
            }
            function resetModal(){
                //Aguarda 2 segundos ata restaurar e fechar o modal
                setTimeout(function() {
                    $('#loader').removeClass();
                    $('#loader').addClass('loader');
                    $('#loadingModal_label').html('<span class="glyphicon glyphicon-refresh"></span>Aguarde...');
                    $('#loadingModal').modal('hide');
                }, 1000);
            }
        </script>
    </head>
    <body>

		<!-- loadingModal-->
        <div class="modal fade" data-backdrop="static" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal_label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loadingModal_label">
                            <span class="glyphicon glyphicon-refresh"></span>
                            Aguarde...
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class='alert' role='alert'>
                            <center>
                                <div class="loader" id="loader"></div><br>
                                <h4><b id="loadingModal_content"></b></h4>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- loadingModal-->
		

</body>
</html>
