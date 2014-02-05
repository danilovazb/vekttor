<? ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<!--<link href="../../fontes/css/sis.css" rel="stylesheet" type="text/css" />-->
<title>Impressao</title>

<style>
body{ font-family:Arial, Helvetica, sans-serif; font-size:16px;color:#000;}
table{ font-size:13px;border-top:solid 1px black;border-left:solid 1px black;}
table thead tr td{  border-right:solid 1px black;border-bottom:solid 1px black;}
table tbody tr td{ color:#000;border-right:solid 1px black;border-bottom:solid 1px black;}
thead{ text-align:center; font-weight:bold;}
#info_filtro{ font-family:Tahoma, Geneva, sans-serif; font-size:12px;}
.relatorio thead tr { background:#E2E2E2;}
a{ text-decoration:none; color:#000}
table tbody tr:hover{ background:none;}
.wp{display:none;}
</style>

<script src="../../fontes/js/jquery.min.js"></script>
</head>
<body>
<!--<h3 style="margin-left:20px;">Relatório</h3>-->
<div style="clear:both;"></div>
<div style="margin-left:20px; width:800px;" class="relatorio">
<div id="dados">
<!--<table  cellspacing="0" >
	<thead>
    	<tr>
        	<td>Data Vcto.</td>
            <td>Data Pago.</td>
            <td>Cliente</td>
            <td>Centro de Custo</td>
            <td>Plano de conta</td>
            <td>Valor</td>
        </tr>
    </thead>
	<tbody style="font-size:14px;">
    	<tr>
        	<td>23/11/1989</td>
            <td>23/11/2013</td>
            <td width="180"><div style="overflow:hidden; width:180px; float:left;">Ricardo M Lima</div></td>
            <td width="180"><div style="overflow:hidden;width:180px; float:left;">Ricardo</div></td>
            <td width="180"><div style="overflow:hidden;width:180px; float:left;">Ricardo</div></td>
            <td>152.239,50</td>
        </tr>
    </tbody>
</table>-->

</div>
</div>
<script>
conteudo = window.opener.document.getElementById('dados');
total = window.opener.document.getElementById('total');

//rodape = window.opener.document.getElementById('rodape_plano_contas').innerHTML;

numero  = conteudo.getElementsByTagName('table').length;

css = window.opener.document.getElementsByTagName('link')[0].cloneNode();
css = document.createElement('link');
css.setAttribute('type','text/css');
css.setAttribute('href','../../fontes/css/sis.css');
document.getElementsByTagName('head')[0].appendChild(css);
	/*if( $.trim(total) != "" ){
		conteudo += total;
	}*/
document.getElementById('dados').innerHTML=conteudo.innerHTML;
document.getElementById('dados').innerHTML+=total.innerHTML;
</script>
</body>
</html>