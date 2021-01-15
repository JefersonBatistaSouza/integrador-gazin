<!DOCTYPE html>
<!--
Integração Gazim atacado
Jeferson Batista Souza
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Integração Gazim</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    </head>
    <script>
	//Requisição ajax ao buscaProduto.php
        function buscaProduto() {
            jQuery(document).ready(function () {
                jQuery('#buscaProduto').submit(function () {
                    var dados = jQuery(this).serialize();
                    jQuery.ajax({
                        type: "POST",
                        url: "buscaProduto.php",
                        data: dados,
                        beforeSend : function (){
                            jQuery("#retorno").html("<h3 style='text-align: center'>Aguarde... Gerando Arquivo XML</h3>"); 
                        },
                        success: function (data)
                        {
                            jQuery("#retorno").html(data);
                        }
                    });

                    return false;
                });
            });
        }
		//Requisição ajax ao validaAcesso.php
        function Acessar() {
            jQuery(document).ready(function () {
                jQuery('#validaAcesso').submit(function () {
                    var dados = jQuery(this).serialize();
                    jQuery.ajax({
                        type: "POST",
                        url: "validaacesso.php",
                        data: dados,
                        beforeSend : function (){
                            jQuery("#retornoValidAcesso").html("<h3 style='text-align: center'>Aguarde...</h3>"); 
                        },
                        success: function (data)
                        {
                            jQuery("#retornoValidAcesso").html(data);
                        }
                    });

                    return false;
                });
            });
        }
    </script>
    <body style="background: #002752">
        <!-- Formulário para acesso ao Sistema -->
        <div class="row" style="width: 50%; margin: 0 auto; top: 15px; background: #d1ecf1; padding: 15px">
            <div class="col-12" style="text-align: center">
                <p >Sistema de Integração ao Banco de Dados da Gazin Atacado<br/> Desenvolvido por Jeferson Batista Souza
                    <br/> Ariquemes-RO | E-mail  :  comandaariquemes@gmail.com</p>
                <h1><strong>LOGIN</strong></h1>
            </div>
        </div>
        <div class="row" style="width: 50%; margin: 0 auto; top: 15px; background: #d1ecf1; padding: 15px" id="formValidacao">
            <div class="col-12" style="background-color: #fbfcfc; padding: 20px">
                <form action="" method="post" id="validaAcesso">
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome de Usuário"/>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha de Acesso" style="margin-top: 10px"/>
                    <button class="btn btn-danger" class="form-group form-control" onclick="Acessar()" style="margin-top: 10px">Acessar</button>
                </form>
            </div>
        </div>
        <div class="col-12" id="retornoValidAcesso" style="width: 50%; margin: 0 auto; top: 15px; background: #d1ecf1; padding: 15px"></div>
        <!-- Formulário para geração do xml -->
        <div class="row" style="width: 50%; margin: 0 auto; top: 15px; background: #d1ecf1; padding: 15px" id="mostraFormulario"></div>
    </body>
</html>
