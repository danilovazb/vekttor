<?
$qualtelata ="modulos/administrativo/usuario/"; 
?><link href="../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<a href="" class='s1'>
  	Sistema NV
</a>
<a href="" class='s1'>
    Administrativo 
</a>
<a href="" class='s1'>
    Administrativo 
</a>
<a href="" class='s1'>
    Administrativo 
</a>
<a href="" class='s2'>
    Administrativo 
</a>
<a href="" class="navegacao_ativo">
<span></span>    Usu&aacute;rios 

</a>
</div>
<div id="barra_info">
    <a href="<?=$qualtelata?>usuario_form.php" target="carregador" class="mais"></a>
	Teste
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="80"><a href="#" class='tda'>Usuário <span class="sdown"></span></a></td>
          	<td width="80"><a href="#" class='tda'>Login <span class="sup"></span></a></td>
          	<td width="140"><a>Tipo de Usuário</a></td>
          	<td width="140"><a>Ultimo Acesso</a></td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr onclick="window.open('<?=$qualtelata?>usuario_form.php','carregador')">
            <td width="80">Mário Novo</td>
          	<td width="80">mario</td>
          	<td width="140">Desenvolvedor</td>
          	<td width="140">24/03/2011 às 15:19</td>
            <td></td>
        </tr>
    	<tr class="al">
            <td width="80">Mário Novo</td>
          	<td width="80">mario</td>
          	<td width="140">Desenvolvedor</td>
          	<td width="140">24/03/2011 às 15:19</td>
            <td></td>
        </tr>
    	<tr>
            <td width="80">Mário Novo</td>
          	<td width="80">mario</td>
          	<td width="140">Desenvolvedor</td>
          	<td width="140">24/03/2011 às 15:19</td>
            <td></td>
        </tr>
    	<tr class="al">
            <td width="80">Mário Novo</td>
          	<td width="80">mario</td>
          	<td width="140">Desenvolvedor</td>
          	<td width="140">24/03/2011 às 15:19</td>
            <td></td>
        </tr>
    	<tr>
            <td width="80">Mário Novo</td>
          	<td width="80">mario</td>
          	<td width="140">Desenvolvedor</td>
          	<td width="140">24/03/2011 às 15:19</td>
            <td></td>
        </tr>
    	<tr class="al">
            <td width="80">Mário Novo</td>
          	<td width="80">mario</td>
          	<td width="140">Desenvolvedor</td>
          	<td width="140">24/03/2011 às 15:19</td>
            <td></td>
        </tr>
    	<tr>
            <td width="80">Mário Novo</td>
          	<td width="80">mario</td>
          	<td width="140">Desenvolvedor</td>
          	<td width="140">24/03/2011 às 15:19</td>
            <td></td>
        </tr>
    	<tr class="al">
            <td width="80">Mário Novo</td>
          	<td width="80">mario</td>
          	<td width="140">Desenvolvedor</td>
          	<td width="140">24/03/2011 às 15:19</td>
            <td></td>
        </tr>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="80"><a>Total</a></td>
            <td width="80">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	356 Registros <select name="select" id="select" style="margin-left:10px">
    <option>15</option>
    <option>30</option>
    <option>50</option>
    <option>100</option>
  </select>
  Por P&aacute;gina 
<div style="float:right; margin:0px 20px 0 0">
	<a href=" " class='bt_left'></a>
	<input name="textfield" class="nPaginacao" type="text" id="textfield" size="2" value="1" />
	<a href=" " class='bt_rigth'></a>
</div>
</div>
