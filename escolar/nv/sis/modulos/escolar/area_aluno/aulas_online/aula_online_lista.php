<?
$aluno_id= $_SESSION['aluno']->id;

?>
<script>
$('.ops').live('click',function(){
	aula_id=$(this).attr('id');
	location = '?tela_id=330&aula_id='+aula_id;
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
<span></span>Matérias
</a>
</div>
<div id="barra_info">
  
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="100">Data</td>
           <td>Aula</td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
    	<tr class="ops" id="1">
        	<td width="100" id="descricao">07/01/2013</td>
            <td>Aula 1 - Introdução</td>
        </tr>
        <tr class="al ops" id="2">
        	<td width="100" id="descricao">10/01/2013</td>
            <td>Aula 2 - Sintaxe5</td>
        </tr>
        <tr class="ops" id="3">
        	<td width="100"  id="descricao">12/01/2013</td>
            <td>Aula 3 - Variáveis</td>
        </tr>
        <tr class="al ops" id="8">
        	<td width="100" id="descricao">15/01/2013</td>
            <td>Aula 4 - Variáveis Globais</td>
        </tr>
        <tr class="ops" id="7">
        	<td width="100" id="descricao">18/01/2013</td>
            <td>Aula 5 - Operações Lógicas</td>
        </tr>
        <tr class="al ops" id="9">
        	<td width="100" id="descricao">21/01/2013</td>
            <td>Aula 6 - Banco de Dados</td>
        </tr>
        <tr class="ops" id="10">
        	<td width="100" id="descricao">24/01/2013</td>
            <td>Aula 7 - Banco de Dados 2</td>
        </tr>
        <tr class="al ops" id="11">
        	<td width="100" id="descricao">26/01/2013</td>
            <td>Aula 8 - Orientação a objeto</td>
        </tr>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="230">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<script>
$("#modulo_id").change(function(t){
	modulo_id=$(this).val();
	location='?tela_id=327&modulo_id='+modulo_id;
})
</script>
<div id='rodape'>
  <div style="float:right; margin:0px 20px 0 0"></div>
</div>
