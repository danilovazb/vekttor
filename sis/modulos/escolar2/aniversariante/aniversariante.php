<?php
$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
//include ("_ctrl.php");

//$mes_corrente = "AND MONTH(ea.data_nascimento) = '".date('m')."'";
$mes_corrente = date('m');
$ano_corrente = date('Y');

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
			$("tr:odd").addClass('al');
});

$(".remove_imagem").live("click", function(){
	aluno_id= $(this).attr('aluno_id');
	window.open('?tela_id=215&deleta_imagem='+aluno_id,'carregador');
	
	$("#img_curso").hide(200);
	
});
</script>

<div id="conteudo">
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
        <form class='form_busca' action="" method="get">
             <a></a>
            <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
            <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
            <input type="text" value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
        </form>
        
         <div id="some">&laquo;</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="../../../../../inscricao_online/sis/modulos/administrativo/alunos_inscritos/?tela_id=221" class="navegacao_ativo"><span></span>Aniversariantes</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        <!--<a href="modulos/escolar/alunos_inscritos/form.php" target="carregador" class="mais"></a>-->	
  <form  method="get">
      <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
      <select name="mes_aniversario" id="mes_aniversario">
        <option> M&ecirc;s </option>
        <option value="01" <?php if ($_GET["mes_aniversario"] == '01') echo 'selected="selected"'; ?> > Janeiro </option>
        <option value="02" <?php if ($_GET["mes_aniversario"] == '02') echo 'selected="selected"'; ?>> Fevereiro </option>
        <option value="03" <?php if ($_GET["mes_aniversario"] == '03') echo 'selected="selected"'; ?>> Mar&ccedil;o </option>
        <option value="04" <?php if ($_GET["mes_aniversario"] == '04') echo 'selected="selected"'; ?>> Abril </option>
        <option value="05" <?php if ($_GET["mes_aniversario"] == '05') echo 'selected="selected"'; ?>> Maio </option>
        <option value="06" <?php if ($_GET["mes_aniversario"] == '06') echo 'selected="selected"'; ?>> Junho </option>
        <option value="07" <?php if ($_GET["mes_aniversario"] == '07') echo 'selected="selected"'; ?>> Julho </option>
        <option value="08" <?php if ($_GET["mes_aniversario"] == '08') echo 'selected="selected"'; ?>> Agosto </option>
        <option value="09" <?php if ($_GET["mes_aniversario"] == '09') echo 'selected="selected"'; ?>> Setembro </option>
        <option value="10" <?php if ($_GET["mes_aniversario"] == '10') echo 'selected="selected"'; ?>> Outubro </option>
        <option value="11" <?php if ($_GET["mes_aniversario"] == '11') echo 'selected="selected"'; ?>> Novembro </option>
        <option value="12" <?php if ($_GET["mes_aniversario"] == '12') echo 'selected="selected"'; ?>> Dezembro </option>
      </select>
 
  <!--<label>De: 
  <input name="data_ini" id="data_ini" style="width:80px; height:12px;" mascara='__/__/____' type="text" value="<?=$_GET['data_ini']?>" calendario='1' sonumero='1' />
  </label> 
  <label>At&eacute;: 
  <input name="data_fim" id="data_fim" type="text" style="width:80px; height:12px;" mascara='__/__/____' sonumero='1' calendario='1' value="<?=$_GET['data_fim']?>" />
  </label> -->

  <input type="submit" value="Filtrar" />

	<?php
    if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
        echo "Per&iacute;odo: ".$_GET['data_ini']." &agrave; ".$_GET['data_fim'];
    }else{
        echo "Per&iacute;odo: ". date('d')."/".date('m');
    }
    ?> 
    
    <button type="button" onclick="window.open('modulos/tela_impressao.php?url=<? //$url?>')" class="botao_imprimir" style="float:right; position:absolute; margin-top:2px; margin-left:5px;" >
	<img src="../fontes/img/imprimir.png" />
	</button>
  </form>
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <div id="dados">
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="240"><?php echo linkOrdem( "Nome", "nome", 1 ); ?></td>
                <td width="80"><?php echo linkOrdem( "Nascimento", "data_nascimento", 0); ?></td>
                <td width="80"><?php echo linkOrdem( "Telefone", "Telefone", 0); ?></td>
                <td width="50">Idade</td>
                 <td width="100">Turma</td>
                <td></td>
            </tr>
        </thead>
    </table>
    
    
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
    
    
		<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
            <?php
				
				$filtro = " AND month(aluno.data_nascimento) = '".$mes_corrente."' ORDER BY aluno.data_nascimento";
				
				if( !empty($_GET['mes_aniversario']) ){
					$filtro = " AND month(aluno.data_nascimento) = '".trim($_GET['mes_aniversario'])."' ORDER BY aluno.data_nascimento";
				}
				
				 $registros= mysql_result(mysql_query($t="SELECT COUNT(*) FROM escolar2_alunos AS aluno WHERE aluno.vkt_id = '$vkt_id' $filtro "),0,0);
				 
				 $sql = mysql_query($t2="
				 SELECT * FROM  escolar2_alunos AS aluno
				 
				 JOIN escolar2_matriculas AS matricula
				 	ON matricula.aluno_id = aluno.id
				 
				 WHERE 
				 	aluno.vkt_id = '$vkt_id' 
				 
				 AND
				 	matricula.status != 'cancelada' 
				 	
				 $filtro LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
				          
            
            while($r=mysql_fetch_object($sql)){
				$nascimento = explode("-",$r->data_nascimento);
				$idade = ($ano_corrente - $nascimento[0]);
                $turma = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_turmas WHERE id = '$r->turma_id' "));
				
				
            ?>
            
                <tr <?php echo $cl; ?>>
                    <td width="240"><?php echo get_nome($r->nome,40);?></td>
                    <td width="80"><?php echo dataUsaToBr($r->data_nascimento)?></td>
                    <td width="80"><?php  if(!empty($r->telefone1)){ echo $r->telefone1;}else{echo $r->telefone2;} ?></td>
                    <td width="50"><?php echo $idade;?></td>
                    <td width="100"><?php echo $turma->nome?></td>
                    <td></td>
                </tr>
            <?php
              }
            ?>	
            </tbody>
        </table>
        
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
               <td width="100%">&nbsp;</td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id='rodape'>
	<?=$registros?> Registros 
    <?
	
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	if(!isset($_GET['estoque_minimo'])){
		$estoque_minimo='false';
	}else{
		$estoque_minimo=$_GET['estoque_minimo'];
	}
	
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina.  <?=ceil($registros/$limitador)?> Total P&aacute;ginas
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('data_ini'=>$_GET['data_ini'],'data_fim'=>$_GET['data_fim']))?>
    </div>