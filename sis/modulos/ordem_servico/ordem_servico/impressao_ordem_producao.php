<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
$id = $_GET['id'];
$os=mysql_fetch_object(mysql_query($t="SELECT *,os.id as os_id, cf.id as cli_id FROM os,
								cliente_fornecedor cf
								WHERE cf.id=os.cliente_id
								AND os.id=".$_GET['id']." AND os.vkt_id=$vkt_id"));
$vendedor=mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$os->vendedor_id'"));

$servicos = mysql_query($t="SELECT * FROM os_item os_i,
								servico s
							WHERE 
								os_i.servico_id = s.id AND
								os_i.os_id='$os->os_id'");
if($vkt_id==1){
	$logo="../../../../fontes/img/vekttor.png";
}else{
	$logo="../../../modulos/vekttor/clientes/img/".$vkt_id.".png";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
	
	#pagina{
		width:280mm;		
	}
	#cabecalho{
		width:100%;
		padding:20px;
		height:50px;
	}
	#logo,#nome_impressao,#numero_pedido{
		float:left;		
	}
	#nome_impressao,#numero_pedido{
		line-height:70px;
	}
	#nome_impressao{
		width:65%;		
		text-align:center;
		font-family:Arial, Helvetica, sans-serif;
		font-size:22px;
		float:left;
		
	}
	#produtos{
		width:100%;
	}
	#produtos > table{
		width:100%;
		border-collapse:collapse;
		border-top:2px solid #000;
		border-left:2px solid #000;
	}
	#produtos > table tr td{
		text-align:center;
		border-bottom:2px solid #000;
		border-right:2px solid #000;
	}
	#dados_os,#layout{
		margin-top:30px;
		width:500px;
		height:450px;
		float:left;
		
	}
	
	#impressao,#recorte{
		width:300px;
		float:left;
	}
	
	.titulo{
		width:270px;
		padding:2px;
		border-radius:10px;
		color:white;
		text-align:center;
		background-color:#000;
	}
	
	.conteudo_dados_os{
		margin-top:3%;
		
	}
	
	.opcao_impressao{
		min-width:80px;
		float:left;
		margin-left:10px;
		margin-bottom:2px;		
	}
	
	.checkbox{
		float:left;
		border:solid 2px #000000;
		width:15px;
		height:15px;
		border-radius:4px;
	}
	#impresso,#producao{
		width:195px;
	
		float:left;
	}
	
	#impressao,#impresso{
		height:100px;
	}
	#titulo_impresso, #titulo_producao{
		text-align:left;
		font-size:22px;
		font-weight:bold;
	}
	
	#impressao, #impresso{
		margin-top:5%;
	}
	
	#observacoes{
		width:100%;
	}
	
	#boxassinaturas{
		width:100%;
		margin-top:100px;
		padding-left:40px;
	}
	.assinatura{
		text-align:center;		
		
		float:left;
	}
	#layout{
		width:500px;
		border: solid 1px #000000;
		float:right;
		border-radius:10px;
		padding:28px;
	}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Ordem de Produção</title>
</head>

<body>
<div id="pagina" class="LandscapeDiv">
	<div id="cabecalho">
    
    	<div id="logo">
        	<img src="<?=$logo?>"/>
        </div>
        
        <div id="nome_impressao">
        	ORDEM DE SERVIÇO - IMPRESSÃO DIGITAL	
        </div>
        
        <div id="numero_pedido">
        	N&ordm; do Pedido: <?=$os->numero_sequencial_empresa?>	
        </div>
        
    	    
    </div>
    
    <div style="clear:both"></div>
    
    <div id="produtos">
    	<table>
        	<tr>
            	<td>Mídia com Gramatura</td>
                <td>Medida</td>
                <td>Quantidade</td>
                <td>Nome do Arquivo</td>                
            </tr>
            <?php
				while($servico = mysql_fetch_object($servicos)){
			
					$s = mysql_fetch_object(mysql_query($t="SELECT * FROM servico WHERE id='$servico->servico_id'"));
					
			?>
            <tr>
            	<td><?=$servico->nome?></td>
                <td><?=$servico->und?></td>
                <td><?=$servico->qtd_servico?></td>
                <td style="font-family:Verdana;font-size:12px;"><?=$servico->obs_item_producao?></td>                
            </tr>
            <?
				}
			?>
        </table>
    </div>
    <div id="dados_os">
    	CLIENTE: <?=$os->razao_social?>
        
        <div style="clear:both"></div>
        
        DATA DE SOLICITAÇÃO: <?=DataUsaToBr($os->data_cadastro)?>
        
        <div style="clear:both"></div>
        
        DATA DE ENTREGA: <?=DataUsaToBr($os->data_entrega)?>
        
        <div style="clear:both"></div>
            
        SOLICITADO POR: <?=$vendedor->nome?>
        
        <div style="clear:both"></div>
        
        <div id="impressao">
        	
            <div class="titulo">
            	Impressão
            </div>
            <div class="conteudo_dados_os">
            	
                <div class="opcao_impressao">
                	<div class="checkbox" id="adesivo"></div>Adesivo
                </div>
                
                <div class="opcao_impressao">
                	<div class="checkbox" id="gloss"></div>Gloss
            	</div>
                
                <div class="opcao_impressao">
                	<div class="checkbox" id="Backligth"></div>Backligth
            	</div>
                
                <div style="clear:both"></div>
                
                <div class="opcao_impressao">
                	<div class="checkbox" id="Lona"></div>Lona
                </div>
                
                <div class="opcao_impressao">
                	<div class="checkbox" id="Tecido"></div>Tecido
            	</div>
                
                <div class="opcao_impressao">
                	<div class="checkbox" id="Perfurado"></div>Perfurado
            	</div>
                
                <div style="clear:both"></div>
                
                <div class="opcao_impressao">
                	<div class="checkbox" id="PVC"></div>PVC/ PSAI
            	</div>
                
                <div class="opcao_impressao">
                	<div class="checkbox" id="Estrutura"></div>Estrutura metálica
            	</div>
            </div>
            
                    
        </div>
        
      <div id="impresso">
          <div id="titulo_impresso">
              IMPRESSO	
          </div>
          
           <div class="opcao_impressao">
           	 Data: ____/____/____
           </div>
          
           <div class="opcao_impressao">
           	 HORÁRIO: ____ hs
           </div>           
      
      </div>
      
      <div style="clear:both"></div>
      
      <div id="recorte">
          <div class="titulo">
              Recorte	
          </div>
          <div class="conteudo_dados_os">
           	<div class="opcao_impressao">
             	<div class="checkbox" id="adesivo"></div>SIM
           	</div>
          
           	<div class="opcao_impressao">
            	<div class="checkbox" id="adesivo"></div>NÃO
           	</div>           
      	</div>
      </div>
      
       <div id="producao">
          <div id="titulo_producao">
              PRODUÇÃO	
          </div>
          
           <div class="opcao_impressao">
           	 Data: ____/____/____
           </div>
          
           <div class="opcao_impressao">
           	 HORÁRIO: ____ hs
           </div>           
      
      </div>
      
      <div style="clear:both"></div>
      
      <div class="opcao_impressao">
      	Observações: 
        <div style="clear:both"></div>
        Adesivo Para Placa.
      </div>
      
      <div style="clear:both"></div>
      
      <div id="boxassinaturas">
      
      	<div class="assinatura">
      		<div class="linha" style="border-bottom:solid 1px #000000;width:170px;"></div>
      		
            <div style="clear:both"></div>
            
            Ass. Vendedor
        </div>
        
        <div class="assinatura" style="margin-left:50px;">
      		<div class="linha" style="border-bottom:solid 1px #000000;width:150px;"></div>
      		
            <div style="clear:both"></div>
            
            Ass. Designer
        </div>
        
      </div>
            
    </div>
    
    <div id="layout">
    	<img src="../../../upload/ordem_servico/arquivos_modelos/<?=$os->os_id.".".$os->extensao_img?>" style="width:500px;"/>
    </div>
	
</div>
</body>
</html>