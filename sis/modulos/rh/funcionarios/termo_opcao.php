<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");

function mes($mes){
	
	switch($mes){
		case '01': $mes="Janeiro";break;
		case '02': $mes="Fevereiro";break;
		case '03': $mes="Mar�o";break;
		case '04': $mes="Abril";break;
		case '05': $mes="Maio";break;
		case '06': $mes="Junho";break;
		case '07': $mes="Julho";break;
		case '08': $mes="Agosto";break;
		case '09': $mes="Setembro";break;
		case '10': $mes="Outubro";break;
		case '11': $mes="Novembro";break;
		case '12': $mes="Dezembro";break;
		
		
	}
	
	echo $mes;
}

$id = $_GET['id'];
	
$empregado = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id=$id"));
	
$empresa     = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$empregado->empresa_id"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2" />
<title>Termo de Op�ao</title>
<style>
	*{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	#pagina{
		margin-left:auto;
		margin-right:auto;
		width:800px;
	}
	#cabecalho{
		text-align:center;
	}
	#quebra{
		white-space:normal;
		
	}
	#declaracao{
		line-height:35px;
	}
	#quadrado{
		width:130px;
		height:110px;
		border:solid 1px #000000;
		margin-top:100px;
		float:left;
		margin-left:100px;
	}
	#assinatura{
		font-size:10px;
		width:265px;
		height:200px;
		
		margin-top:50px;
		float:right;
		margin-right:100px;
		text-align:center;
	}
	.linha_assinatura{
		width:100%;
		height:2px;
		border-bottom:solid 1px #000000;
		
	}
	#rodape{
		margin-top:30px;
	}
</style>
</head>

<body>

<div id="pagina">
	<div id="cabecalho">
		<div style="font-size:16px;">FUNDO DE GARANTIA DO TEMPO DE SERVI�O</div>
        
        <div id="quebra"></div>
		
        <div style="font-size:9px;">Lei N.o 5.107 DE 13 de SETEMBRO DE 1966</div>
        
        <div id="quebra"></div>
		
         <div style="font-size:9px;">REGULAMENTADA DEC. 59.820 DE 20 DE DEZEMBRO DE 1966</div>
         
         <div id="quebra"></div>
         
         <div style="margin-top:20px;text-decoration:underline;"><br />
         DECLARA�AO DE OP�AO</div>
	</div>
    
    <div id="conteudo">
		<div id="declaracao">
      	  <br />
      	  Eu,
<?=$empregado->nome?>
        
       	  <div id="quebra"></div>
		
       	portador da Carteira Profissional n&deg; <?=$empregado->carteira_profissional_numero?> S�rie <?=$empregado->carteira_profissional_serie.' / '.$empregado->carteira_profissional_estado_emissor?>
        
        	<div id="quebra"></div>
		
         	empresa <?=$empresa->razao_social?>
         
          
         	<div id="quebra"></div>
         
         	situada <?=$empresa->endereco?>, <?=$empresa->cidade?>, <?=$empresa->estado?>  
         
         	<div id="quebra"></div>
		</div>         
         declaro, para todos os fins, que, nesta data, exer�o a op�ao pelo regime do REGULAMENTO DO FUNDO DE
GARANTIA DO TEMPO DE SERVI�O, aprovado pelo decreto n.o 59.820, de 20 de dezembro de 1966.<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div style="clear:both"></div>
         
         
         <div id="quadrado">
         <div style="font-size:6px;width:130px;height:50px;line-height:10px;text-align:center;margin-top:-20px;">IMPRESSAO DACTILOSC�PICA QUANDO SE TRATAR DE ANALFABETO</div>
         </div>
         
         <div id="assinatura">
         
         <?
		 $dt = explode('-',$empregado->data_admissao );
//         $empregado->data_admissao;
		 ?>
         	<?=$empresa->cidade?>, 
			<?=$dt[2]?> de 
			<?=mes($dt[1])?> de 
			<?=$dt[0]?>	<div id="quebra"></div>
         	(LOCAL E DATA)
            
            <div class="linha_assinatura" style="margin-top:30px;"></div>
            <div id="quebra"></div>
         	<div style="font-size:10px;">(Assinatura)</div>
            
            <div id="quebra"></div>
            <div style="text-align:left;margin-top:15px;">TESTEMUNHA</div>
            
            <div class="linha_assinatura" style="margin-top:15px;text-align:left;"></div>
            <div class="linha_assinatura" style="margin-top:20px;text-align:left;"></div>
            
            <div class="linha_assinatura" style="margin-top:30px;"></div>
            <div id="quebra"></div>
         	<div style="font-size:7px;">(ASSINATURA RESPONSAVEL LEGAL PELO MENOR. QUANDO COUBER)</div>
         </div>      	
       
	</div>
    
    <div style="clear:both"></div>
    
    <div id="rodape">
    	<div id="data">
        	<div style="float:left;width:150px;">Data &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?
//            date('d')."/".date('m')."/".date('Y')
//			$dt = explode('-',$empregado->data_admissao );
			echo dataUsaToBr($empregado->data_admissao);
			?></div>
        	
             <div style="float:right;width:300px;margin-right:100px;">
        			 <div class="linha_assinatura" style="margin-top:10px;"></div>
            		<div id="quebra"></div>
         			<div style="font-size:7px;text-align:center;">(ASSINATURA DO EMPREGADOR)</div>
        	</div>
            
        </div>
        
        <div style="clear:both;"></div>
        
       <div id="instrucoes" style="margin-top:30px;"><div id="quebra"></div>
       </div>
       
        
    </div>
    
</div>
</body>
</html>