/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function AbrirOrcamento(div) {
    var display = document.getElementById(div).style.display;
    if (display === "none") {
        document.getElementById(div).style.display = 'block';
        document.getElementById("button").value ="Cancelar Orçamento";
    }else{
        document.getElementById(div).style.display = 'none';
        document.getElementById("button").value ="Abrir Orçamento";
        }
    }

$(function (){
   $("#pesquisa").keyup(function(){
      var pesquisa = $(this).val();
      if(pesquisa !== ''){
          var dados = {
              palavra : pesquisa
          }
          $.post('lancarProduto.php',dados, function (retorna){
              $(".resultado").html(retorna);
          });
      }
   });
});