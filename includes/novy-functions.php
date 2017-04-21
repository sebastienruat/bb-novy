<?php

//Gestion des catégories à l'aide d'un fichier json. Le fichier .json doit être codé en UTF-8 de préférence sans BOM.
function novy_row_templates_categories() {

	$path_for_dat = NOVY_DIR . 'data';

	if ($handle = opendir($path_for_dat)) {

		$json = file_get_contents($path_for_dat . '/' .'categories.json');
		$parsed_json = json_decode($json);
		
		if ( is_null ( $parsed_json ) ) {
			$novy_categories = array();
		}
		else {
			$novy_categories = $parsed_json->{'categories'};
		}
	}
	else {
		$novy_categories = array();
	}

	closedir($handle);

	return $novy_categories;
}

function novy_templates_exclude()
{
	$data = novy_get_template_selector_data();
	$novy_categories = novy_row_templates_categories();

	foreach ( $data['categorized']  as $key => $cat ) {
		foreach ( $novy_categories as $novy_category ) {
			if ( $novy_category == $cat['name'] ) {
				unset( $data['categorized'][$key] );
			}
		}
	}
	return $data;
}
add_filter( 'fl_builder_row_templates_data', 'novy_templates_exclude', 50 );

function fl_templates_load() {

	$path_for_dat = NOVY_DIR . 'data';

	/**
	 * Return if the builder isn't installed or if the current
	 * version doesn't support registering templates.
	 */
	if ( ! class_exists( 'FLBuilder' ) || ! method_exists( 'FLBuilder', 'register_templates' ) ) {
		return;
	}

	/**
	 * Register the path to your templates.dat file.
	 */

	if ($handle = opendir($path_for_dat)) {

		while (false !== ($entry = readdir($handle))) {

			if ($entry != "." && $entry != "..") {

				$ext = pathinfo($entry, PATHINFO_EXTENSION);

				if ($ext == 'dat') {
					FLBuilder::register_templates( $path_for_dat . '/' . $entry);
				}
			}
		}

		closedir($handle);
	}
}

add_action( 'after_setup_theme', 'fl_templates_load' );

function novy_get_templates()
{

	$templates = FLBuilderModel::get_templates('row');
	//var_dump($templates);
	return $templates;
}

function novy_get_template_selector_data( $type = 'row' )
{
	$categorized     = array();
	$templates       = array();

	// Build the templates array.
	foreach( novy_get_templates() as $key => $template ) {

		if ( strstr( $template->image, '://' ) ) {
			$image = $template->image;
		}
		else {
			$blank_image = NOVY_DIR . 'assets/images/templates/blank.jpg';
			if ( file_exists( $blank_image ) ) {
				$image = NOVY_URL . 'assets/images/templates/blank.jpg';
			}
		}

		$templates[] = array(
			'id' 		=> $key,
			'name'  	=> $template->name,
			'image' 	=> $image,
			'category'	=> isset( $template->category ) ? $template->category : $template->categories,
			'type'      => 'core'
			);
	}

	//var_dump($templates);

	$novy_categories = novy_row_templates_categories();

	// Build the categorized templates array.
	foreach( $templates as $template ) {

		if ( is_array( $template['category'] ) ) {

			foreach ( $template['category'] as $cat_key => $cat_label ) {
				foreach ( $novy_categories as $novy_category ) {
					if ( $novy_category == $cat_label ) {
						if ( ! isset( $categorized[ $cat_key ] ) ) {
							$categorized[ $cat_key ] = array(
								'name'		=> $cat_label,
								'templates'	=> array()
								);
						}
						$categorized[ $cat_key ]['templates'][] = $template;
					}
				}
			}
		}
	}

	// Return both the templates and categorized templates array.
	return array(
		'templates'  	=> $templates,
		'categorized' 	=> $categorized
		);
}

/**
 * Row templates panel
 */
function novy_templates_ui_panel()
{
	if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {

		$novy_row_templates = novy_get_template_selector_data();

		$render_panel = FLBuilderModel::current_user_has_editing_capability();

		if ( $render_panel ) {
			include NOVY_DIR . 'includes/novy-ui-panel-for-templates.php';
		}

	}

}

add_action( 'wp_footer', 'novy_templates_ui_panel' );

function novy_templates_ui_bar_button( $buttons )
{

	$simple_ui = ! FLBuilderModel::current_user_has_editing_capability();
	$content_button = array();

	if ( isset( $buttons['add-content'] ) ) {
		$content_button = $buttons['add-content'];
		unset( $buttons['add-content'] );
	}

	$buttons['novy-add-template'] = array(
		'label' => __( 'Novy Templates', 'bb-novy' ),
		'class' => 'novy-add-template-button',
		'show'	=> ! $simple_ui
		);

	if ( count( $content_button ) ) {
		$buttons['add-content'] = $content_button;
	}

	return $buttons;
}

add_filter( 'fl_builder_ui_bar_buttons', 'novy_templates_ui_bar_button' );

/*function novy_templates_panel_control()
{
	if ( FLBuilderModel::is_builder_active() ) {

		$label = 'Saved Row Templates for Novy';

    ?>

        <div id="fl-builder-blocks-templates" class="fl-builder-blocks-section pp-builder-blocks-template">
    		<span class="fl-builder-blocks-section-title">
    			<?php echo $label; ?> <i class="fa fa-chevron-right"></i>
    		</span>
        </div>

    <?php
	}
}
add_action( 'fl_builder_ui_panel_after_rows', 'novy_templates_panel_control' );*/