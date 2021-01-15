<?php

/*
  Integração Lojas Gazim

  application/x-httpd-php gazim.php ( PHP script, UTF-8 Unicode text, with very long lines, with CRLF line terminators )

  O Curl irá fazer uma requisição
  e irá receber o JSON com as informações.

 */
$opcao = filter_input(0, 'opcao', FILTER_DEFAULT);
$codigo = filter_input(0, 'codigo', FILTER_DEFAULT);
if ($opcao == "selecione") {
    echo "<div class='col-12 alert alert-danger'> <strong>É necessário selecionar uma ação</strong></div>";
} else {
    
    if ($opcao == "cadprod") {
        $url = "http://macgyver.gazinatacado.com.br/v1/parceiroonline/produtos/descricao";
    } if($opcao =="upprod") {
        $url = "http://macgyver.gazinatacado.com.br/v1/parceiroonline/produtos/precosaldo";
    }if($opcao =="cadprodcodigo"){
        $url = "http://macgyver.gazinatacado.com.br/v1/parceiroonline/produtos/descricao?idproduto=$codigo";
    }if($opcao == "upprodcodigo"){
        $url = "http://macgyver.gazinatacado.com.br/v1/parceiroonline/produtos/precosaldo?idproduto=$codigo";
    }
    $curl = curl_init("$url");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Authorization: token_gazim",
        "Content-Type: application/json"
    ]);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $resposta = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($resposta != 200) {
        echo "<div class='col-12 alert alert-danger'> <strong>Código pode estar incorreto ou não existe no
	site da Gazin Atacado</strong><br/>{$resposta} - Caso o erro perssista contate o administrador do sistema</div>";
    } else {
        // Faremos o PHP interpretar e reconhecer o JSON que
        //recebemos da API.
        $encoded = json_decode($json);
        //var_dump($encoded);
        // Receberá todos os dados do XML
        // var_dump($encoded);
        if ($opcao == "cadprod" || $opcao == "cadprodcodigo") {
            //var_dump($encoded);
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<listaProduto>';
            $quantProd = count($encoded);
            $cont = 0;
            while ($cont < $quantProd) {
                // A raiz do meu documento XML
                $xml .= '<produto attr-id="' . $encoded[$cont]->dados[0]->idproduto . '">';
                $xml .= '<idproduto>' . $encoded[$cont]->dados[0]->idproduto . '</idproduto>';
                $xml .= '<idgradex>' . $encoded[$cont]->dados[0]->idgradex . '</idgradex>';
                $xml .= '<idgradey>' . $encoded[$cont]->dados[0]->gradex . '</idgradey>';
                $xml .= '<gradey>' . $encoded[$cont]->dados[0]->gradey . '</gradey>';
                $xml .= '<idmarca>' . $encoded[$cont]->dados[0]->idmarca . '</idmarca>';
                $xml .= '<categoria>' . $encoded[$cont]->dados[0]->categoria . '</categoria>';
                $xml .= '<marca>' . $encoded[$cont]->dados[0]->marca . '</marca>';
                $xml .= '<descricao>' . $encoded[$cont]->dados[0]->descricao . '</descricao>';
                $xml .= '<peso>' . $encoded[$cont]->dados[0]->peso . '</peso>';
                $xml .= '<altura>' . $encoded[$cont]->dados[0]->altura . '</altura>';
                $xml .= '<largura>' . $encoded[$cont]->dados[0]->idmarca . '</largura>';
                $xml .= '<comprimento>' . $encoded[$cont]->dados[0]->comprimento . '</comprimento>';
                $xml .= '<idcodigonbm>' . $encoded[$cont]->dados[0]->idcodigonbm . '</idcodigonbm>';
                $xml .= '<origem>' . $encoded[$cont]->dados[0]->origem . '</origem>';
                $xml .= '<ppb>' . $encoded[$cont]->dados[0]->ppb . '</ppb>';
                $xml .= '<ean>' . $encoded[$cont]->dados[0]->ean . '</ean>';
                $xml .= '<quantidadevolume>' . $encoded[$cont]->dados[0]->quantidadevolume . '</quantidadevolume>';
                $xml .= '<descricaoprimaria><![CDATA[' . $encoded[$cont]->dados[0]->descricao_primaria . ']]></descricaoprimaria>';
                $xml .= '<descricaotecnica><![CDATA[' . $encoded[$cont]->dados[0]->descricao_tecnica . ']]></descricaotecnica>';
                $xml .= '<fotos>' . $encoded[$cont]->dados[0]->fotos . '</fotos>';
                $xml .= '</produto>';

                $cont = $cont + 1;
            }
            $xml .= '</listaProduto>';
            // Escreve o arquivo
            $fp = fopen('./XML/produtosGazin.xml', 'w+');
            fwrite($fp, $xml);
            fclose($fp);
			//Importação será feita no painel wordpress com wp-import
            echo "<div class='col-12 alert alert-success'> <strong>XML GERADO COM SUCESSO</strong><br/>Arquivo XML
	    (<a target='_blank' href='https://lojasgerry.com.br/import-gazin/XML/produtosGazin.xml'>produtosGazin.xml</a>) está pronto para ser importado"
            . " "
            . "<br/><a href='https://seusitewordpress/wp-admin/admin.php?page=pmxi-admin-manage'>Ir para área de importação</a>"
            . "</div>";
        } elseif($opcao == "upprod" || $opcao =="upprodcodigo") {
            $quantProd = count($encoded);
            if($quantProd != 0){
            //Criando XML para atualização do preços e estoque
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<listaPreco>';
            $cont = 0;
            while ($cont < $quantProd) {
                $xml .= '<atributo attr-id="' . $encoded[$cont]->descricao[0]->idproduto . '">';
                        $xml .= '<idproduto>' . $encoded[$cont]->descricao[0]->idproduto . '</idproduto>';
                        $xml .= '<preco>' . $encoded[$cont]->descricao[0]->precosistema . '</preco>';
                        $xml .= '<estoque>' . $encoded[$cont]->descricao[0]->saldo_liquido . '</estoque>';
                $xml .= '</atributo>';
                $cont = $cont + 1;
            }
            $xml .= '</listaPreco>';
            // Escreve o arquivo dentro da pasta xml.
            $fp = fopen('./XML/PrecosGazin.xml', 'w+');
            fwrite($fp, $xml);
            fclose($fp);
            echo "<div class='col-12 alert alert-success'> <strong>XML GERADO COM SUCESSO</strong><br/>"
            . "Arquivo XML (<a href='https://seusitewordpress.com.br/import-gazin/XML/PrecosGazin.xml' target='_blank'>AtualizarPrecosGazin.xml</a>)
	    está pronto para ser importado"
            . " "
            . "<br/><a href='https://seusitewordpress.com.br/wp-admin/admin.php?page=pmxi-admin-manage'>Ir para área de importação</a>"
            . "</div>";
            }else{
                echo "<div class='col-12 alert alert-danger'> <strong>Não é possivel Recuperar Preço e 
		Quantidade deste produto</strong><br/>Talvez voce não tenha permissões da Gazin para visualizar esses dados</div>";
            }
             
        }
    }
}

    
