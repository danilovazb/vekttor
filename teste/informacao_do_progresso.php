<pre><?
$info = uploadprogress_get_info($_GET['id_progresso']);

var_dump($info);
?></pre>
<script>
top.atializainformacoes('<?=$info['bytes_uploaded']?>', '<?=$info['bytes_total']?>', '<?=$info['est_sec']?>');
</script>