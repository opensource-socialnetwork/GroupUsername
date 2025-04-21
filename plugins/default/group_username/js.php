<?php
 $args = array(
			'name' => 'group_username',										   
  );
 if(isset($params['group']->group_username)){
	 	$aegs['name'] = "gu";
		$args['value'] = ossn_site_url("g/{$params['group']->group_username}");
		$args['readonly'] = 'readonly';
 }
 $field = ossn_plugin_view('input/text', $args);

?>
<script>
	var contents  = "<div><label>"+Ossn.Print('groupusername')+'</label><?php echo $field;?></div>';
	$(contents).insertAfter('.module-contents form fieldset select[name="membership"]');
</script>