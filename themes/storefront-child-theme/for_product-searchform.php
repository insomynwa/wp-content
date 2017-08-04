<?php

$form = '<form id="searchform" class="col-md-6" role="search" method="get" action="' . esc_url( home_url( '/'  ) ) . '">
	<div class="input-group">
        <span class="input-group-btn">
          <select name="" class="form-control">
            <option value="0">Kategori</option>
            <option value="1">A</option>
            <option value="2">B</option>
            <option value="3">C</option>
          </select>
        </span>
		<label class="screen-reader-text" for="s">' . __( 'Search for:', 'woocommerce' ) . '</label>
		<input type="text" class="form-control" aria-label="..." name="s" value="' . get_search_query() . '"placeholder="' . __( 'My Super Search form', 'woocommerce' ) . '" />
		<span class="input-group-btn">
          <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
        </span>
		<input type="hidden" name="post_type" value="product" />
	</div> <!-- /input-group -->
</form>';
echo $form;
		
          
            
            
          