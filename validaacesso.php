<?php

/*
 * 
  Validando Usuario para acesso ao sistema de integração
 *   
 */
include './conexao/conexao.php';
$nome = filter_input(0, 'nome', FILTER_DEFAULT);
$senha = filter_input(0, 'senha', FILTER_DEFAULT);
$dominio = "seusitewordpress.com.br";
if ($nome != "" and $senha != "") {
    $conexao = DBConnect();
	
    $query = "SELECT nome,senha,dominio FROM usuario WHERE nome='$nome' AND senha='$senha'";
    $resultado = mysqli_query($conexao, $query);
    if (!$resultado) {
        echo "<div class='alert alert-danger'>Usuario ou Senha inválido<br/> O sistema só pode ser acessado atravéz do<br/>"
        . "dominio <strong>seusiteworpress.com.br</strong><br/>" . mysqli_error($conexao) . "<br/>$resultado</div>";
        DBClose($conexao);
    } else {
        $dado = mysqli_fetch_assoc($resultado);
		//o sistema só pode ser utilizado se o dominio estiver registrado na base de dados
        if ($dado['nome'] == $nome && $dado['senha'] == $senha && $dado['dominio']==$dominio) {
            echo "<div class='alert alert-success'>Você está conectado! Domínio Autorizado : {$dado['dominio']}</div>";
            ?>
            <style>#formValidacao,h1{display: none}</style>
            <div class="col-12">
                <form action="" method="post" id="buscaProduto">
                    <label>Selecione o que voce deseja fazer</label>
                    <select class="form-control" id="opcao" name="opcao">
                        <option value="selecione">Selecione uma Ação</option>
						<!-- Tem uma limitação de 600 produtos na requisição a 
						base da gazim, pode ser algum timeout no servidor-->
                        <option value="cadprod">Importar Produtos (Todos Limite até 600)</option>
                        <option value="upprod">Atualizar Preco e Estoque (Todos Limite até 600)</option>
						<!-- Atualizar ou importar produtos especificos, porém de 1 a 1-->
                        <option value="cadprodcodigo">Importar Produtos (Por Codigo)</option>
                        <option value="upprodcodigo">Atualizar Preco e Estoque (Por Codigo)</option>
                    </select>
                    <label>Digite o Codigo</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo do Produto">
                    <button style="margin-top:10px"class="btn btn-danger" class="form-group form-control" onclick="buscaProduto()">Buscar</button>
                </form>
            </div>
            <div class="col-12" id="retorno"></div>
            <?php

            DBClose($conexao);
        } else {
            if ($dado['nome'] == $nome && $dado['senha'] ){
                echo "<div class='alert alert-danger'><strong> "
                . "O usuário {$dado['nome']} está registrado no dominio {$dado['dominio']}</strong><br/>" 
                . "O sistema só pode ser acessado atravéz do dominio <strong>seusitewordpress.com.br</strong></div>";
            }else{
            echo "<div class='alert alert-danger'><strong>Usuario ou Senha inválido</strong><br/> O sistema só pode ser acessado atravéz do<br/>"
            . "dominio <strong>seusitewordpress.com.br</strong></div>";
            }
        }
    }
} else {
    echo "<div class='alert alert-danger'><strong>Usuario ou Senha inválido</strong><br/> "
    . "O sistema só pode ser acessado atravéz do<br/>"
    . "dominio <strong>seusitewordpress.com.br</strong></div>";
}



