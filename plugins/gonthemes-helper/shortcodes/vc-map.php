<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mapping shortcodes
 */
function gon_map_vc_shortcodes() {
    $order_by_values = array(
        '',
        esc_html__( 'Date', 'gonthemes-helper' ) => 'date',
        esc_html__( 'ID', 'gonthemes-helper' ) => 'ID',
        esc_html__( 'Author', 'gonthemes-helper' ) => 'author',
        esc_html__( 'Title', 'gonthemes-helper' ) => 'title',
        esc_html__( 'Modified', 'gonthemes-helper' ) => 'modified',
        esc_html__( 'Random', 'gonthemes-helper' ) => 'rand',
        esc_html__( 'Comment count', 'gonthemes-helper' ) => 'comment_count',
        esc_html__( 'Menu order', 'gonthemes-helper' ) => 'menu_order',
    );

    $order_way_values = array(
        '',
        esc_html__( 'Descending', 'gonthemes-helper' ) => 'DESC',
        esc_html__( 'Ascending', 'gonthemes-helper' ) => 'ASC',
    );
	$meta_key_values = array(
        '',
        esc_html__( 'Top rated products', 'gonthemes-helper' ) => '_wc_average_rating',
        esc_html__( 'Best Selling products', 'gonthemes-helper' ) => 'total_sales',
		esc_html__( 'Featured products', 'gonthemes-helper' ) => '_featured',
    );

	$args = array(
		'type' => 'post',
        'child_of' => 0,
        'parent' => '',
        'orderby' => 'id',
        'order' => 'ASC',
        'hide_empty' => false,
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'number' => '',
        'taxonomy' => 'product_cat',
        'pad_counts' => false,
	);
	$product_categories_dropdown = array(esc_html__( 'All Category', 'gonthemes-helper' ) => 'all-category');
	$categories = get_categories( $args );
	if (isset($categories)) {
		foreach ($categories as $key => $cat) {
			$product_categories_dropdown[$cat->name] = $cat->slug;
			$childrens = get_term_children($cat->term_id, $cat->taxonomy);
			if ($childrens){
				foreach ($childrens as $key => $children) {
					$child = get_term_by( 'id', $children, $cat->taxonomy);
					$product_categories_dropdown[$child->name] = '--'.$child->slug;
				}
			}
		}
	}
	
	$args2 = array(
		'type' => 'post',
        'child_of' => 0,
        'parent' => '',
        'orderby' => 'id',
        'order' => 'ASC',
	 );
	$post_category_dropdown = array();
	$post_category_dropdown['All'] = 'all';
	$categories2 = get_categories( $args2 );
	if (isset($categories2)) {
		foreach ($categories2 as $key2 => $cat2) {
			$post_category_dropdown[$cat2 -> cat_ID] = $cat2 -> cat_name;
			$childrens2 = get_term_children($cat2->term_id, $cat2->taxonomy);
			if ($childrens2){
				foreach ($childrens2 as $key2 => $children2) {
					$child2 = get_term_by( 'id', $children2, $cat2->taxonomy);
					$post_category_dropdown[$child2->term_id] = '--'.$child2->name;

				}
			}
		}
	}
	
	// Mapping shortcode Icon Box
	vc_map(
		array(
			'name'                    => esc_html__( 'Icon Box', 'gonthemes-helper' ),
			'base'                    => 'gon-icon-box',
			'category'                => esc_html__( 'GonThemes Helper', 'gonthemes-helper' ),
			'description'             => esc_html__( 'Display icon box with image or icon.', 'gonthemes-helper' ),
			'controls'                => 'full',
			'show_settings_on_create' => true,
			'params'                  => array(

				array(
					'type'        => 'radioimage',
					'heading'     => esc_html__( 'Layout', 'gonthemes-helper' ),
					'class'       => 'icon-box-layout',
					'param_name'  => 'layout',
					'admin_label' => true,
					'options'     => array(
						'top'  => GON_URL . 'images/image-top.jpg',
						'top2' => GON_URL . 'images/icon-top.jpg',
						'left' => GON_URL . 'images/icon-left.jpg'
					),
					'description' => esc_html__( 'Choose the layout you want to display.', 'gonthemes-helper' ),
				),
				// Title
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'gonthemes-helper' ),
					'param_name'  => 'title',
					'admin_label' => true,
					'value'       => esc_html__( 'This is an icon box.', 'gonthemes-helper' ),
					'description' => esc_html__( 'Provide the title for this icon box.', 'gonthemes-helper' ),
				),
				//Use custom or default title?
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Use custom or default title?', 'gonthemes-helper' ),
					'param_name'  => 'title_custom',
					'value'       => array(
						__( 'Default', 'gonthemes-helper' ) => '',
						__( 'Custom', 'gonthemes-helper' )  => 'custom',
					),
					'description' => esc_html__( 'If you select default you will use default title which customized in typography.', 'gonthemes-helper' )
				),
				//Heading
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Heading element', 'gonthemes-helper' ),
					'param_name'  => 'heading_tag',
					'value'       => array(
						'h3' => 'h3',
						'h2' => 'h2',
						'h4' => 'h4',
						'h5' => 'h5',
						'h6' => 'h6',
					),
					'description' => esc_html__( 'Choose heading type of the title.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'title_custom',
						'value'   => 'custom',
					),
				),
				//Title color
				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title color ', 'gonthemes-helper' ),
					'param_name'  => 'title_color',
					'value'       => esc_html__( '', 'gonthemes-helper' ),
					'description' => esc_html__( 'Select the title color.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'title_custom',
						'value'   => 'custom',
					),
				),
				//Title size
				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title size ', 'gonthemes-helper' ),
					'param_name'  => 'title_size',
					'min'         => 0,
					'value'       => '',
					'suffix'      => 'px',
					'description' => esc_html__( 'Select the title size.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'title_custom',
						'value'   => 'custom',
					),
				),

				//Title weight
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title weight ', 'gonthemes-helper' ),
					'param_name'  => 'title_weight',
					'value'       => array(
						__( 'Choose the title font weight', 'gonthemes-helper' ) => '',
						__( 'Lighter', 'gonthemes-helper' )                      => '300',
						__( 'Normal', 'gonthemes-helper' )                       => '400',
						__( 'Medium', 'gonthemes-helper' )                      => '500',
						__( 'SemiBold', 'gonthemes-helper' )                       => '600',
						__( 'Bold', 'gonthemes-helper' )                         => '700',
					),
					'description' => esc_html__( 'Select the title weight.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'title_custom',
						'value'   => 'custom',
					),
				),
				//Title style
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title style ', 'gonthemes-helper' ),
					'param_name'  => 'title_style',
					'value'       => array(
						__( 'Choose the title font style', 'gonthemes-helper' ) => '',
						__( 'Italic', 'gonthemes-helper' )                      => 'italic',
						__( 'Oblique', 'gonthemes-helper' )                     => 'oblique',
						__( 'Initial', 'gonthemes-helper' )                     => 'initial',
						__( 'Inherit', 'gonthemes-helper' )                     => 'inherit',
					),
					'description' => esc_html__( 'Select the title style.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'title_custom',
						'value'   => 'custom',
					),
				),
				// Description
				array(
					'type'        => 'textarea',
					'admin_label' => true,
					'heading'     => esc_html__( 'Description', 'gonthemes-helper' ),
					'param_name'  => 'description',
					'value'       => esc_html__( '', 'gonthemes-helper' ),
					'description' => esc_html__( 'Provide the description for this icon box.', 'gonthemes-helper' )
				),
				//Use custom or default description ?
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Use custom or default description?', 'gonthemes-helper' ),
					'param_name'  => 'description_custom',
					'value'       => array(
						__( 'Default', 'gonthemes-helper' ) => '',
						__( 'Custom', 'gonthemes-helper' )  => 'custom',
					),
					'description' => esc_html__( 'If you select default you will use default description which customized in typography.', 'gonthemes-helper' )
				),
				//Description color
				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Description color ', 'gonthemes-helper' ),
					'param_name'  => 'description_color',
					'value'       => esc_html__( '', 'gonthemes-helper' ),
					'description' => esc_html__( 'Select the description color.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'description_custom',
						'value'   => 'custom',
					),
				),
				//Description size
				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Description size ', 'gonthemes-helper' ),
					'param_name'  => 'description_size',
					'min'         => 0,
					'value'       => '',
					'suffix'      => 'px',
					'description' => esc_html__( 'Select the description size.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'description_custom',
						'value'   => 'custom',
					),
				),
				//Description weight
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Description weight ', 'gonthemes-helper' ),
					'param_name'  => 'description_weight',
					'value'       => array(
						__( 'Choose the description font weight', 'gonthemes-helper' ) => '',
						__( 'Lighter', 'gonthemes-helper' )                      => '300',
						__( 'Normal', 'gonthemes-helper' )                       => '400',
						__( 'Medium', 'gonthemes-helper' )                      => '500',
						__( 'SemiBold', 'gonthemes-helper' )                       => '600',
						__( 'Bold', 'gonthemes-helper' )                         => '700',
					),
					'description' => esc_html__( 'Select the description weight.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'description_custom',
						'value'   => 'custom',
					),
				),
				//Description style
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Description style ', 'gonthemes-helper' ),
					'param_name'  => 'description_style',
					'value'       => array(
						__( 'Choose the description font style', 'gonthemes-helper' ) => '',
						__( 'Italic', 'gonthemes-helper' )                            => 'italic',
						__( 'Oblique', 'gonthemes-helper' )                           => 'oblique',
						__( 'Initial', 'gonthemes-helper' )                           => 'initial',
						__( 'Inherit', 'gonthemes-helper' )                           => 'inherit',
					),
					'description' => esc_html__( 'Select the description style.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'description_custom',
						'value'   => 'custom',
					),
				),
				// Icon type
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon type', 'gonthemes-helper' ),
					'value'       => array(
						__( 'Choose icon type', 'gonthemes-helper' ) => '',
						__( 'Single Image', 'gonthemes-helper' )     => 'image',
						__( 'Font Awesome', 'gonthemes-helper' )     => 'fontawesome',
						__( 'Openiconic', 'gonthemes-helper' )       => 'openiconic',
						__( 'Typicons', 'gonthemes-helper' )         => 'typicons',
						__( 'Entypo', 'gonthemes-helper' )           => 'entypo',
						__( 'Linecons', 'gonthemes-helper' )         => 'linecons',
						__( 'Simple Line Icons', 'gonthemes-helper' ) => 'simplelineicons',
					),
					'admin_label' => true,
					'param_name'  => 'icon_type',
					'description' => esc_html__( 'Select icon type.', 'gonthemes-helper' ),
				),
				// Icon type: Image - Image picker
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Choose image', 'gonthemes-helper' ),
					'param_name'  => 'icon_image',
					'admin_label' => true,
					'value'       => '',
					'description' => esc_html__( 'Upload the custom image icon.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
				),
				//Image size
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Image size', 'gonthemes-helper' ),
					'param_name'  => 'image_size',
					'admin_label' => true,
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
				),
				// Icon type: Fontawesome - Icon picker
				array(
					'type'        => 'iconpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon', 'gonthemes-helper' ),
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fa fa-heart',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'fontawesome',
					),
					'description' => esc_html__( 'FontAwesome library.', 'gonthemes-helper' ),
				),
				// Icon type: Openiconic - Icon picker
				array(
					'type'        => 'iconpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon', 'gonthemes-helper' ),
					'param_name'  => 'icon_openiconic',
					'value'       => '',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
						'type'         => 'openiconic',
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'openiconic',
					),
					'description' => esc_html__( 'Openiconic library.', 'gonthemes-helper' ),
				),
				// Icon type: Typicons - Icon picker
				array(
					'type'        => 'iconpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon', 'gonthemes-helper' ),
					'param_name'  => 'icon_typicons',
					'value'       => '',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
						'type'         => 'typicons',
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'typicons',
					),
					'description' => esc_html__( 'Typicons library.', 'gonthemes-helper' ),
				),
				// Icon type: Entypo - Icon picker
				array(
					'type'        => 'iconpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon', 'gonthemes-helper' ),
					'param_name'  => 'icon_entypo',
					'value'       => '',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
						'type'         => 'entypo',
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'entypo',
					),
					'description' => esc_html__( 'Entypo library.', 'gonthemes-helper' ),
				),
				// Icon type: Lincons - Icon picker
				array(
					'type'        => 'iconpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon', 'gonthemes-helper' ),
					'param_name'  => 'icon_linecons',
					'value'       => '',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
						'type'         => 'linecons',
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'linecons',
					),
					'description' => esc_html__( 'Linecons library.', 'gonthemes-helper' ),
				),
				// Icon type: Simple Line Icons - Icon picker
				array(
					'type'        => 'iconpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon', 'gonthemes-helper' ),
					'param_name'  => 'icon_simplelineicons',
					'value'       => '',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
						'type'         => 'simplelineicons',
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'simplelineicons',
					),
					'description' => esc_html__( 'Simple Line Icons library.', 'gonthemes-helper' ),
				),

				//Icon link
				array(
					'type'        => 'vc_link',
					'heading'     => __( 'Icon link', 'gonthemes-helper' ),
					'param_name'  => 'icon_link',
					'admin_label' => true,
					'description' => __( 'Enter the link for icon.', 'gonthemes-helper' ),
				),

				//Icon size
				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon size', 'gonthemes-helper' ),
					'param_name'  => 'icon_size',
					'value'       => 40,
					'min'         => 16,
					'max'         => 100,
					'suffix'      => 'px',
					'description' => esc_html__( 'Select the icon size.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => array( 'fontawesome', 'openiconic', 'typicons', 'entypo', 'linecons', 'simplelineicons' ),
					),
				),
				//Icon color
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Icon color', 'gonthemes-helper' ),
					'param_name'  => 'icon_color',
					'value'       => '#89BA49',
					'description' => esc_html__( 'Select the icon color.', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => array( 'fontawesome', 'openiconic', 'typicons', 'entypo', 'linecons', 'simplelineicons' ),
					),
				),
				//Display the button?
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Display the button?', 'gonthemes-helper' ),
					'param_name'  => 'button_display',
					'value'       => array( esc_html__( '', 'gonthemes-helper' ) => 'yes' ),
					'description' => esc_html__( 'Tick it to display the button.', 'gonthemes-helper' ),
				),
				//Button link
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button link', 'gonthemes-helper' ),
					'param_name'  => 'button_link',
					'value'       => esc_html__( '', 'gonthemes-helper' ),
					'description' => esc_html__( 'Write the button link', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'button_display',
						'value'   => 'yes',
					),
				),
				//Button value
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Button value', 'gonthemes-helper' ),
					'param_name'  => 'button_value',
					'value'       => esc_html__( '', 'gonthemes-helper' ),
					'description' => esc_html__( 'Write the button value', 'gonthemes-helper' ),
					'dependency'  => array(
						'element' => 'button_display',
						'value'   => 'yes',
					),
				),
				//Background color
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Background color', 'gonthemes-helper' ),
					'param_name'  => 'background_color',
					'value'       => '',
					'description' => esc_html__( 'Select the background color.', 'gonthemes-helper' ),
				),
				//Text Alignment
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text alignment', 'gonthemes-helper' ),
					'param_name'  => 'alignment',
					'value'       => array(
						__( 'Choose the text alignment', 'gonthemes-helper' ) => '',
						__( 'Text at left', 'gonthemes-helper' )              => 'left',
						__( 'Text at center', 'gonthemes-helper' )            => 'center',
						__( 'Text at right', 'gonthemes-helper' )             => 'right',
					),
				),
				// Animation
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Animation', 'gonthemes-helper' ),
					'param_name'  => 'css_animation',
					'value'       => array(
						__( 'No', 'gonthemes-helper' )                 => '',
						__( 'Top to bottom', 'gonthemes-helper' )      => 'top-to-bottom',
						__( 'Bottom to top', 'gonthemes-helper' )      => 'bottom-to-top',
						__( 'Left to right', 'gonthemes-helper' )      => 'left-to-right',
						__( 'Right to left', 'gonthemes-helper' )      => 'right-to-left',
						__( 'Appear from center', 'gonthemes-helper' ) => 'appear'
					),
					'description' => esc_html__( 'Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'gonthemes-helper' )
				),
				// Extra class
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Extra class', 'gonthemes-helper' ),
					'param_name'  => 'el_class',
					'value'       => '',
					'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'gonthemes-helper' ),
				),
			)
		)
	);
	
	// Mapping shortcode Counter Box
	vc_map( array(
		'name'        => esc_html__( 'Counter Box', 'gonthemes-helper' ),
		'base'        => 'gon-counter-box',
		'class'       => '',
		'category'    => esc_html__( 'GonThemes Helper', 'gonthemes-helper' ),
		'description' => esc_html__( 'Display counter box.', 'gonthemes-helper' ),
		'params'      => array(

			//Circle box color
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Circle color', 'gonthemes-helper' ),
				'param_name'  => 'b_color',
				'value'       => esc_html__( '', 'gonthemes-helper' ),
				'description' => esc_html__( 'Select the circle box background color', 'gonthemes-helper' )
			),
			// Count to number
			array(
				'type'        => 'number',
				'admin_label' => true,
				'value'       => 10,
				'min'         => 0,
				'heading'     => esc_html__( 'Number', 'gonthemes-helper' ),
				'param_name'  => 'number',
				'description' => esc_html__( 'Enter number in box to count.', 'gonthemes-helper' ),
			),
			//Number color
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Number color', 'gonthemes-helper' ),
				'param_name'  => 'number_color',
				'value'       => esc_html__( '', 'gonthemes-helper' ),
				'description' => esc_html__( 'Select the number color', 'gonthemes-helper' )
			),
			// Text
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Text', 'gonthemes-helper' ),
				'admin_label' => true,
				'param_name'  => 'text',
				'value'       => '',
				'description' => esc_html__( 'Short text in counter box.', 'gonthemes-helper' ),
			),
			//Text color
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Text color', 'gonthemes-helper' ),
				'param_name'  => 'text_color',
				'value'       => esc_html__( '', 'gonthemes-helper' ),
				'description' => esc_html__( 'Select the text color', 'gonthemes-helper' )
			),
			// Extra class
			array(
				'type'        => 'textfield',
				'admin_label' => true,
				'heading'     => esc_html__( 'Extra class', 'gonthemes-helper' ),
				'param_name'  => 'el_class',
				'value'       => '',
				'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'gonthemes-helper' ),
			),
		)
	) );
	
	// Mapping shortcode Google Map
	vc_map(
		array(
			'name'                    => esc_html__( 'Google Map', 'gonthemes-helper' ),
			'base'                    => 'gon-google-map',
			'category'                => esc_html__( 'GonThemes Helper', 'gonthemes-helper' ),
			'description'             => esc_html__( 'Display Google map.', 'gonthemes-helper' ),
			'controls'                => 'full',
			'show_settings_on_create' => true,
			'params'                  => array(
				// Map center
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Map center', 'gonthemes-helper' ),
					'param_name'  => 'map_center',
					'admin_label' => true,
					'value'       => '',
					'description' => esc_html__( 'The name of a place, town, city, or even a country. Can be an exact address too.', 'gonthemes-helper' ),

				),
				// Map height
				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Height', 'gonthemes-helper' ),
					'param_name'  => 'height',
					'min'         => 0,
					'value'       => 480,
					'suffix'      => 'px',
					'description' => esc_html__( 'Height of the map.', 'gonthemes-helper' ),
				),
				// Zoom options
				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Zoom level', 'gonthemes-helper' ),
					'param_name'  => 'zoom',
					'min'         => 0,
					'max'         => 21,
					'value'       => 12,
					'description' => esc_html__( 'A value from 0 (the world) to 21 (street level).', 'gonthemes-helper' ),
				),
				// Show marker
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Marker', 'gonthemes-helper' ),
					'param_name'  => 'marker_at_center',
					'value'       => array( esc_html__( '', 'gonthemes-helper' ) => 'true' ),
					'description' => esc_html__( 'Show marker at map center.', 'gonthemes-helper' ),
				),
				// Get marker
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Choose marker icon', 'gonthemes-helper' ),
					'param_name'  => 'marker_icon',
					'admin_label' => true,
					'value'       => '',
					'description' => esc_html__( 'Replaces the default map marker with your own image.', 'gonthemes-helper' ),
					'dependency'  => array( 'element' => 'marker_at_center', 'value' => array( 'true' ) )
				),
				// Other options
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Scroll to zoom', 'gonthemes-helper' ),
					'param_name'  => 'scroll_zoom',
					'value'       => array( esc_html__( '', 'gonthemes-helper' ) => 'true' ),
					'description' => esc_html__( 'Allow scrolling over the map to zoom in or out.', 'gonthemes-helper' ),
				),
				// Other options
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Draggable', 'gonthemes-helper' ),
					'param_name'  => 'draggable',
					'value'       => array( esc_html__( '', 'gonthemes-helper' ) => 'true' ),
					'description' => esc_html__( 'Allow dragging the map to move it around.', 'gonthemes-helper' ),
				),
				// Google API
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Google map API', 'gonthemes-helper' ),
					'param_name'  => 'map_api',
					'admin_label' => true,
					'value'       => 'AIzaSyBEswjEJ9Ivw2YWIx_ztXyKi3ZiO1p6mws',
					'description' => esc_html__( 'Enter API google map of you or create new API: https://developers.google.com/maps/documentation/javascript/get-api-key', 'gonthemes-helper' ),

				),
				// Animation
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Animation', 'gonthemes-helper' ),
					'param_name'  => 'animation',
					'value'       => array(
						__( 'No', 'gonthemes-helper' )                 => '',
						__( 'Top to bottom', 'gonthemes-helper' )      => 'top-to-bottom',
						__( 'Bottom to top', 'gonthemes-helper' )      => 'bottom-to-top',
						__( 'Left to right', 'gonthemes-helper' )      => 'left-to-right',
						__( 'Right to left', 'gonthemes-helper' )      => 'right-to-left',
						__( 'Appear from center', 'gonthemes-helper' ) => 'appear'
					),
					'description' => esc_html__( 'Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'gonthemes-helper' )
				),
				// Extra class
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Extra class', 'gonthemes-helper' ),
					'param_name'  => 'el_class',
					'value'       => '',
					'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'gonthemes-helper' ),
				),

			)
		)
	);
	
	vc_map( 
		array(
			'name'              => esc_html__( 'Carousel Product Category', 'gonthemes-helper' ),
			'base'              => 'wt-product-category',
			'category'         	=> esc_html__( 'GonThemes Helper', 'gonthemes-helper' ),
			'description'       => esc_html__( 'Display Product Category Multi Row.', 'gonthemes-helper' ),
			'controls'          => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Per page', 'gonthemes-helper' ),
					'value' => 6,
					'save_always' => true,
					'param_name' => 'per_page',
					'description' => esc_html__( 'How much items per page to show', 'gonthemes-helper' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Columns', 'gonthemes-helper' ),
					'value' => 4,
					'save_always' => true,
					'param_name' => 'columns',
					'description' => esc_html__( 'How much columns grid', 'gonthemes-helper' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Rows', 'gonthemes-helper' ),
					'value' => 1,
					'save_always' => true,
					'param_name' => 'rows',
					'description' => esc_html__( 'How much rows grid', 'gonthemes-helper' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'gonthemes-helper' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'gonthemes-helper' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Meta key', 'gonthemes-helper' ),
					'param_name' => 'meta_key',
					'value' => $meta_key_values,
					'save_always' => true,
					'description' => esc_html__( 'Chose type product category list', 'gonthemes-helper' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Category', 'gonthemes-helper' ),
					'value' => $product_categories_dropdown,
					'param_name' => 'category',
					'save_always' => true,
					'description' => esc_html__( 'Product category list', 'gonthemes-helper' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Desktop', 'gonthemes-helper' ),
					'value' => 4,
					'save_always' => true,
					'param_name' => 'items_desktop',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Desktop Small', 'gonthemes-helper' ),
					'value' => 3,
					'save_always' => true,
					'param_name' => 'items_desktop_small',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Tablet', 'gonthemes-helper' ),
					'value' => 3,
					'save_always' => true,
					'param_name' => 'items_tablet',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Tablet Small', 'gonthemes-helper' ),
					'value' => 2,
					'save_always' => true,
					'param_name' => 'items_tablet_small',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Mobile', 'gonthemes-helper' ),
					'value' => 1,
					'save_always' => true,
					'param_name' => 'items_mobile',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'AutoPlay', 'gonthemes-helper' ),
					'param_name'  => 'auto_play',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'False', 'gonthemes-helper' )  => 'false',
						esc_html__( 'True', 'gonthemes-helper' ) 	=> 'true',
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Mouse Drag', 'gonthemes-helper' ),
					'param_name'  => 'mouse_drag',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'False', 'gonthemes-helper' )  => 'false',
						esc_html__( 'True', 'gonthemes-helper' ) 	=> 'true',
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Navigation', 'gonthemes-helper' ),
					'param_name'  => 'navigation',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'True', 'gonthemes-helper' ) 	=> 'true',
						esc_html__( 'False', 'gonthemes-helper' )  => 'false',
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Pagination', 'gonthemes-helper' ),
					'param_name'  => 'pagination',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'False', 'gonthemes-helper' )  => 'false',
						esc_html__( 'True', 'gonthemes-helper' ) 	=> 'true',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Left OffSet', 'gonthemes-helper' ),
					'value' => '-15',
					'save_always' => true,
					'param_name' => 'left_offset',
				),
				// Extra class
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Extra class', 'gonthemes-helper' ),
					'param_name'  => 'el_class',
					'value'       => '',
					'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'gonthemes-helper' ),
				),
			),
		) 
	);
	
	vc_map( 
		array(
			'name'              => esc_html__( 'List Product', 'gonthemes-helper' ),
			'base'              => 'list-product-woo',
			'category'         	=> esc_html__( 'GonThemes Helper', 'gonthemes-helper' ),
			'description'       => esc_html__( 'Display Product List.', 'gonthemes-helper' ),
			'controls'          => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title', 'gonthemes-helper' ),
					'param_name'  => 'title',
					'value'       => '',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Per page', 'gonthemes-helper' ),
					'value' => 3,
					'save_always' => true,
					'param_name' => 'per_page',
					'description' => esc_html__( 'How much items per page to show', 'gonthemes-helper' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'gonthemes-helper' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'gonthemes-helper' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Meta key', 'gonthemes-helper' ),
					'param_name' => 'meta_key',
					'value' => $meta_key_values,
					'save_always' => true,
					'description' => esc_html__( 'Chose type product category list', 'gonthemes-helper' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Category', 'gonthemes-helper' ),
					'value' => $product_categories_dropdown,
					'param_name' => 'category',
					'save_always' => true,
					'description' => esc_html__( 'Product category list', 'gonthemes-helper' ),
				),
				// Extra class
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Extra class', 'gonthemes-helper' ),
					'param_name'  => 'el_class',
					'value'       => '',
					'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'gonthemes-helper' ),
				),
			),
		) 
	);
	
	vc_map( 
		array(
			'name'              => esc_html__( 'Carousel Post Category', 'gonthemes-helper' ),
			'base'              => 'wt-post-category',
			'category'         	=> esc_html__( 'GonThemes Helper', 'gonthemes-helper' ),
			'description'       => esc_html__( 'Display Post Category.', 'gonthemes-helper' ),
			'controls'          => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Per page', 'gonthemes-helper' ),
					'value' => 6,
					'save_always' => true,
					'param_name' => 'per_page',
					'description' => esc_html__( 'How much items per page to show', 'gonthemes-helper' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Columns', 'gonthemes-helper' ),
					'value' => 4,
					'save_always' => true,
					'param_name' => 'columns',
					'description' => esc_html__( 'How much columns grid', 'gonthemes-helper' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'gonthemes-helper' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'gonthemes-helper' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'gonthemes-helper' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Category', 'gonthemes-helper' ),
					'value' => $post_category_dropdown,
					'param_name' => 'category',
					'save_always' => true,
					'description' => esc_html__( 'Product category list', 'gonthemes-helper' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Desktop', 'gonthemes-helper' ),
					'value' => 4,
					'save_always' => true,
					'param_name' => 'items_desktop',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Desktop Small', 'gonthemes-helper' ),
					'value' => 3,
					'save_always' => true,
					'param_name' => 'items_desktop_small',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Tablet', 'gonthemes-helper' ),
					'value' => 3,
					'save_always' => true,
					'param_name' => 'items_tablet',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Tablet Small', 'gonthemes-helper' ),
					'value' => 2,
					'save_always' => true,
					'param_name' => 'items_tablet_small',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Responsive Items Mobile', 'gonthemes-helper' ),
					'value' => 1,
					'save_always' => true,
					'param_name' => 'items_mobile',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'AutoPlay', 'gonthemes-helper' ),
					'param_name'  => 'auto_play',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'False', 'gonthemes-helper' )  => 'false',
						esc_html__( 'True', 'gonthemes-helper' ) 	=> 'true',
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Mouse Drag', 'gonthemes-helper' ),
					'param_name'  => 'mouse_drag',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'False', 'gonthemes-helper' )  => 'false',
						esc_html__( 'True', 'gonthemes-helper' ) 	=> 'true',
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Navigation', 'gonthemes-helper' ),
					'param_name'  => 'navigation',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'True', 'gonthemes-helper' ) 	=> 'true',
						esc_html__( 'False', 'gonthemes-helper' )  => 'false',
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Pagination', 'gonthemes-helper' ),
					'param_name'  => 'pagination',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'False', 'gonthemes-helper' )  => 'false',
						esc_html__( 'True', 'gonthemes-helper' ) 	=> 'true',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Left OffSet', 'gonthemes-helper' ),
					'value' => '-15',
					'save_always' => true,
					'param_name' => 'left_offset',
				),
				// Extra class
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Extra class', 'gonthemes-helper' ),
					'param_name'  => 'el_class',
					'value'       => '',
					'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'gonthemes-helper' ),
				),
			),
		) 
	);
}

add_action( 'vc_before_init', 'gon_map_vc_shortcodes' );
