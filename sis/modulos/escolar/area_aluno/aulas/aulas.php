<?
$salamateria = mysql_fetch_object(mysql_query("SELECT * FROM escolar_sala_materia_professor WHERE vkt_id='$vkt_id' AND id='".$_GET[salamateria_id]."'"));

$materia = mysql_fetch_object(mysql_query("SELECT * FROM escolar_materias WHERE id='$salamateria->materia_id' "));


$professor = mysql_fetch_object(mysql_query("SELECT p.* FROM escolar_professor as ep,cliente_fornecedor as p WHERE ep.cliente_fornecedor_id = p.id AND  ep.id='$salamateria->professor_id' "));
//print_r($professor);

?>
<script>
$('.ops').live('click',function(){
	aula_id=$(this).attr('id');
	
	location = '?tela_id=288&aula_id='+aula_id;
});
</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
	<div id='navegacao'><a href="?tela_id=231" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=231" class='s2'>
    Escolar 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Aulas
</a>
</div>
<div id="barra_info">
<strong>Mat&eacute;ria: 
</strong>
<?
echo "$materia->nome";

?>
<strong>Professor :</strong>
<?=$professor->nome_fantasia?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="60">Data</td>
           <td width="250">Aula</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php
    		$sql_aula = mysql_query("SELECT * FROM  escolar_aula WHERE sala_materia_professor_id ='".$_GET[salamateria_id]."' AND vkt_id='$vkt_id' ORDER BY data DESC");
											
					while($r=mysql_fetch_object($sql_aula)){
		$total++;
		if($total%2){$sel='class="al ops"';}else{$sel='class="ops"';}

	?> 
            <tr <?=$sel?> id="<?=$r->id?>">
               <td width="60"><?=dataUsaToBr($r->data)?></td>
               <td width="250" id="descricao"><?=$r->descricao?></td>
               <td></td>
            </tr>
   <?
					}
   ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230">&nbsp;</td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
  <div style="float:right; margin:0px 20px 0 0"></div>
</div>
