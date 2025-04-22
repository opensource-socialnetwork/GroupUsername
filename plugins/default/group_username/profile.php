<?php
if(!isset($params['group']->group_username)){
	return;	
}
?>
<script>
	 var urlfield = "<div class='margin-top-10 ossn-form'><label><?php echo ossn_print('groupusername:url');?></label><input readonly type='text' value='<?php echo ossn_site_url("g/{$params['group']->group_username}");?>' /></div>";
	 $('.widget-description .widget-contents').append(urlfield);
</script>