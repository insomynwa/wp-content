<?php require_once plugin_dir_path( __DIR__ ) . 'dbsnet-woocp-class-template-utility.php'; ?>
<div class="wrap">
	<h2><?php echo $paramData['page_title'] ?></h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<?php echo DBSnet_Woocp_Template_Utility::generateHTML($paramData['view_path'], $paramData['view_data']); ?>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>