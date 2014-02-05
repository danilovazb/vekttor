
<?
include '../../../../_config.php';

echo utf8_encode("<option value='0'>Selecione uma Negociação</option>");

$negociacoes_restritas_q=mysql_query($t="
				SELECT n.* FROM negociacao_cliente as nc, negociacao as n
				WHERE
					n.id=nc.negociacao_id AND
					nc.cliente_id='{$_GET[cliente_id]}'
					 ");
				if(mysql_num_rows($negociacoes_restritas_q)>0){
				while($rn=mysql_fetch_object($negociacoes_restritas_q)){
					echo utf8_encode("<option value='$rn->id' comissao_porcentagem='$rn->comissao_porcentagem' ato_porcentagem='$rn->ato_porcentagem' ato_parcelas='$rn->ato_parcelas'ato_juros='$rn->ato_juros' anuais_porcentagem='$rn->anuais_porcentagem' anuais_parcelas='$rn->anuais_parcelas' anuais_juros='$rn->anuais_juros' semestrais_porcentagem='$rn->semestrais_porcentagem' semestrais_parcelas='$rn->semestrais_parcelas' semestrais_juros='$rn->semestrais_juros'  mensais_porcentagem='$rn->mensais_porcentagem'  mensais_parcelas='$rn->mensais_parcelas' mensais_juros='$rn->mensais_juros' chave_porcentagem='$rn->chave_porcentagem' chave_parcelas='$rn->chave_parcelas' chave_juros='$rn->chave_juros' banco_porcentagem='$rn->banco_porcentagem' banco_parcelas='$rn->banco_parcelas' banco_juros='$rn->banco_juros' >$rn->nome</option>");
				}
			}
			$qn = mysql_query("SELECT * FROM negociacao WHERE empreendimento_id= '{$_GET[empreendimento_id]}' AND restrito!='1' ");
				while($rn= mysql_fetch_object($qn)){
					echo utf8_encode("<option value='$rn->id' comissao_porcentagem='$rn->comissao_porcentagem' ato_porcentagem='$rn->ato_porcentagem' ato_parcelas='$rn->ato_parcelas'ato_juros='$rn->ato_juros' anuais_porcentagem='$rn->anuais_porcentagem' anuais_parcelas='$rn->anuais_parcelas' anuais_juros='$rn->anuais_juros' semestrais_porcentagem='$rn->semestrais_porcentagem' semestrais_parcelas='$rn->semestrais_parcelas' semestrais_juros='$rn->semestrais_juros'  mensais_porcentagem='$rn->mensais_porcentagem'  mensais_parcelas='$rn->mensais_parcelas' mensais_juros='$rn->mensais_juros' chave_porcentagem='$rn->chave_porcentagem' chave_parcelas='$rn->chave_parcelas' chave_juros='$rn->chave_juros' banco_porcentagem='$rn->banco_porcentagem' banco_parcelas='$rn->banco_parcelas' banco_juros='$rn->banco_juros' >$rn->nome</option>");
				}