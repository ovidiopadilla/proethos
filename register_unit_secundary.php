<?
 /**
  * Register Unit
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Ajax
 */
$ref = 'register_'.$r.'_sec';
$link = 'register_unit_secundary_ajax.php?dd1='.$protocolo.'&dd2=listar&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
?>
<div id="<?=$ref;?>">
</div>
</fieldset>

<script>
	var $tela01 = $.ajax('<?=$link;?>')
		.done(function(data) { $("#<?=$ref;?>").html(data); })
		.always(function(data) { $("#<?=$ref;?>").html(data); });	 
</script>
