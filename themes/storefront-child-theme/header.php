<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'storefront_before_site' ); ?>

    <div class="container after-navbar bg-warning">
      <div class="row">
        <div class="col-xs-0 col-sm-0 col-md-3"></div>
        <form class="col-md-6" role="search" method="get" action="<?php echo get_permalink( wc_get_page_id( 'shop' ) );//esc_url( home_url( '/' ) ); //echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
          <div class="input-group">
            <span class="input-group-btn">
              <select name="product_cat" class="form-control">
                <option value="">Semua Kategori</option>
              <?php
              //$parentid = get_queried_object_id();
              $args = array( 'hide_empty' => 0, 'parent' =>0);
              $terms = get_terms('product_cat', $args);//var_dump($parentid);
              if ( $terms ) {
                foreach ( $terms as $term ) {
                  echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
                }
              }
              ?>
              </select>
            </span>
            <input type="text" class="form-control" aria-label="..." name="s">
            <input type="hidden" name="post_type" value="product" />
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
          </div> <!-- /input-group -->
        </form>
      </div>
    </div>
