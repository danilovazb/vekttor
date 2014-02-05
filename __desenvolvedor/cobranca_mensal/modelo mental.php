<?
/*

acrescentar na configuraзгo o smpt email e senha para na hora de enviar enviar com esse smpt etc configurado envar via smtp


1 verifica todos os clientes que tem cobranca mensal, com clientes ativos
2 pega a configuracao basica do cliente (dias antes para enviar)
3 verifica a data de vencimento - o dias a enviar e cria o financeiro_movimento (criar com origem_id ligado ao cobranca_mensa_cliente),  caso ja tenha um vencimento com a mesma data, nгo cria novamente


4 apуs criar todos gera outr script que seleciona todos os financeiro_movimento criados como conta a receber boelto ligado a um cobranca mensal em seu origem_id,
4.1 Envia um email de acordo com a configuracao apra o email configurado no sistema, se tiver uma virgula da o split e enviar 2 ou quantas virgulas tiver
4.2 envia um sms de acordo com a configuracao (se tem configuracao)

cobran




5 Outra rodada de pesquisa de contas a receber vencidas a x dias e envia o email e sms de cobranca




*/


?>