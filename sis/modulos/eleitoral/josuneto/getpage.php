<style>
#content{
	width:600px;
	font-family:Arial, Helvetica, sans-serif;
}
a{
	color: #25324D;
	font-size: 13px;
	text-decoration:none;
	text-transform: uppercase;
	text-align:justify;
}
.fp-post{
	overflow:hidden;
	margin-top:10px;
}
.fp-post, .fp-thumbnail:after{
	clear:both;
}
.attachment-large{
	border: solid 1px #000000;
	padding: 6px;
	float:left;
	margin-right:20px;
}
#header{
	margin-bottom:50px;
}
</style>
</head>

<body >
<div id="content">
<div id="header">
	<img src="http://vkt.srv.br/~nv/sis/modulos/eleitoral/josuneto/header.jpg" width="600"/>
</div>

<?
$gt = file("http://www.josueneto.com.br/novosite/category/noticias/");

for($i=350;$i<429;$i++){
	
	
	$x =  str_replace('width="1024"','width="448"',$gt[$i] );
	$x =  str_replace('height="502"','height="240"',$x );
	
	if(substr_count($x,"www.simplesharebuttons.com")){
		$tamanho_linha = strlen($x);
		$pos = strpos($x,"<span class=\"meta_date\">");
		$x = substr($x,$pos,($tamanho_linha-$pos));		
		
	}
	echo  utf8_decode( $x);
	
}

?>
</div>
</div>

