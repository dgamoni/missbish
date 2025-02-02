<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('acf_field_hotspots') ) :


class acf_field_hotspots extends acf_field {


	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct( $settings ) {

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/

		$this->name = 'hotspots';


		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/

		$this->label = __('Hotspots', 'acf-hotspots');


		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/

		$this->category = 'content';


		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/

		$this->defaults = array(
			'hs_content' 		=> false,
			'hs_sub_image' 	=> false,
			'hs_link' 				=> false,
			'hs_prerendered' => true
		);


		/*
		*		The image field that the hotspots use
		*/

		$this->image = acf_get_field_type('image');


		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('hotspots', 'error');
		*/

		$this->l10n = array(
			'error'	=> __('Error!', 'acf-hotspots'),
		);


		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/

		$this->settings = $settings;


		// do not delete!
    parent::__construct();

	}


	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field_settings( $field ) {


		/**
		 *
		 *	Allows for user to decide whether they will allow the custom field's
		 *	hotspot to support a description for a given hotspot.
		 *
		 */

		acf_render_field_setting( $field, array(
			'label'					=> __('Description','acf-hotspots'),
			'instructions'	=> __('Enable if you would like the description field to use tinymce.','acf-hotspots'),
			'type'					=> 'true_false',
			'ui'						=> 1,
			'name'					=> 'hs_description'
		));


		/**
		 *
		 *	Allows for user to decide whether they will allow the custom field's
		 *	hotspot to support a link for a given hotspot.
		 *
		 */

		acf_render_field_setting( $field, array(
			'label'					=> __('Link','acf-hotspots'),
			'instructions'	=> __('Allow for user to add a link and link text to a given spot.','acf-hotspots'),
			'type'					=> 'true_false',
			'ui'						=> 1,
			'name'					=> 'hs_link'
		));


		/**
		 *
		 *	Allows for user to decide whether they will allow the custom field's
		 *	hotspot to support a link for a given hotspot.
		 *
		 */

		acf_render_field_setting( $field, array(
			'label'					=> __('Pre-rendered','acf-hotspots'),
			'instructions'	=> __('Prerenders the html so you don\'t have to do the markup.','acf-hotspots'),
			'type'					=> 'true_false',
			'ui'						=> 1,
			'name'					=> 'hs_prerendered'
		));

	}



	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field( $field ) {

		/**
		 *	Render the image field
		 */

		echo '<div class="acf-field acf-field-image acf-hotspot__upload">';

			$this->image->render_field([
		    'name' => $field['name'] . '[image]',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'mime_types'	=> '',
				'value' => (empty($field['value']['image']) ? '' : $field['value']['image'])
			]);

		echo '</div>';


		/**
		 *	Render the hotspot image
		 */

		echo '
			<div class="acf-hotspot__container">
				<img class="acf-hotspot__image">
			</div>
		';


		/**
		 *	Render the hotspot information area
		 */

		echo '<div id="acf-hotspot__information--' . $field['key'] . '" class="acf-hotspot__information">';

			if(empty($field['value']['points']))
				$field['value']['points'] = [[]];
			else
				array_unshift($field['value']['points'], []);

			foreach ($field['value']['points'] as $point_index => $point) {
				$first = empty($point_index);
				$name_attribute = ($first ? '' : '') . 'name';
				$point_num = $first ? '!!N!!' : $point_index-1;
				echo '
					<div class="acf-hotspot__' . ($first ? 'clone-base' : 'point-fields') . '">
						<strong class="acf-hotspot__label">
							<span class="acf-hotspot__toggle toggle-indicator" aria-hidden="true"></span>
						</strong>
						<div>
							<input type="hidden" ' . $name_attribute . '="' . $field['name'] . '[points][' . $point_num . '][x]" ' . (empty($point['x']) ? '' : 'value="' . $point['x'] . '"') . ' class="acf-hotspot__input acf-hotspot__input--x" />
							<input type="hidden" ' . $name_attribute . '="' . $field['name'] . '[points][' . $point_num . '][y]" ' . (empty($point['y']) ? '' : 'value="' . $point['y'] . '"') . ' class="acf-hotspot__input acf-hotspot__input--y" />
							<div class="acf-input"><div class="acf-input-wrap">';
								
								// <div class="acf-hotspot__field">
								// 	<div class="acf-label"><label>Title</label></div>
								// 	<input type="text" ' . $name_attribute . '="' . $field['name'] . '[points][' . $point_num . '][title]" ' . (empty($point['title']) ? '' : 'value="' . $point['title'] . '"') . ' class="acf-hotspot__input acf-hotspot__input--title" />
								// </div>
								// <div class="acf-hotspot__field">
								// 	<div class="acf-label"><label>Description</label></div>
								// 	<textarea ' . $name_attribute . '="' . $field['name'] . '[points][' . $point_num . '][description]" class="acf-hotspot__input acf-hotspot__input--description">'
								// 		. (empty($point['description']) ? '' : $point['description']) .
								// 	'</textarea>
								// </div>
								// <div class="acf-hotspot__field">
								// 	<div class="acf-label"><label>Button Link</label></div>
								// 	<input type="text" ' . $name_attribute . '="' . $field['name'] . '[points][' . $point_num . '][link][url]" ' . (empty($point['link']['url']) ? '' : 'value="' . $point['link']['url'] . '"') . ' class="acf-hotspot__input acf-hotspot__input--link-url" />
								// </div>
								// <div class="acf-hotspot__field">
								// 	<div class="acf-label"><label>Button Text</label></div>
								// 	<input type="text" ' . $name_attribute . '="' . $field['name'] . '[points][' . $point_num . '][link][text]" ' . (empty($point['link']['text']) ? '' : 'value="' . $point['link']['text'] . '"') . ' class="acf-hotspot__input acf-hotspot__input--link-text" />
								// </div>

								// dgamoni
								echo '<div class="acf-hotspot__field">';
									echo '<div class="acf-label"><label>Product Link</label></div>';
									//echo '<select name="product_list_'.$point_num.'" id="product_list_'.$point_num.'">';
									echo '<select ' . $name_attribute . '="' . $field['name'] . '[points][' . $point_num . '][link][url]"  class="acf-hotspot__input acf-hotspot__input--link-url" >';
										echo '<option value="0">Select Product</option>';
											$args = array(
												'post_type'   => 'product',
												'post_status' => 'publish',
												'posts_per_page'         => -1,
											);
										$the_query = new WP_Query( $args );
											$selected = '';
											 while ( $the_query->have_posts() ) {
												$the_query->the_post();
												if($point['link']['url'] == $the_query->post->ID ) {
													$selected = 'selected';
												} else {
													$selected = '';	
												}
												echo '<option '.$selected.' value="'.$the_query->post->ID.'">'.$the_query->post->post_title.'</option>';
											}
										 
									 echo '</select>';
								echo '</div>';


								echo '
								<div class="acf-hotspot__field">
									<button class="acf-hotspot__delete button button">Remove</button>
								</div>
							</div></div>
						</div>
					</div>';





			}

		echo '</div>';


		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/

		if(isset($_GET['debug'])) {
			echo '<div style="clear: both;"><pre>';
				print_r( $field );
			echo '</pre></div>';
		}


	}


	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function input_admin_enqueue_scripts() {

		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];


		// register & include JS
		wp_register_script( 'acf-input-hotspots', "{$url}assets/js/acf-hotspots-render.js", array('jquery-ui-accordion','acf-input'), $version, true );
		wp_enqueue_script('acf-input-hotspots');


		// register & include CSS
		wp_register_style( 'acf-input-hotspots', "{$url}assets/css/acf-hotspots-render.css", array('acf-input'), $version );
		wp_enqueue_style('acf-input-hotspots');

	}


	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/


	function format_value( $value, $post_id, $field ) {

		// bail early if no value
		if( empty($value) ) return $value;

		// TODO: filter the field and create a prerendered value
		// but only if prerendered is checked in the field settings
		// $this->settings

		// return
		return $value;

	}


	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/

	function validate_value( $valid, $value, $field, $input ){

		// TODO: Add validation on the hotspots to make sure their values are correct


		// Advanced usage
		// if( $value < $field['custom_minimum_setting'] )
		// {
		// 	$valid = __('The value is too little!','acf-hotspots'),
		// }


		// return
		return $valid;

	}


	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_head() {



	}

	*/


	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/

   	/*

   	function input_form_data( $args ) {



   	}

   	*/


	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_footer() {



	}

	*/


	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function field_group_admin_enqueue_scripts() {

	}

	*/


	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function field_group_admin_head() {

	}

	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	/*

	function load_value( $value, $post_id, $field ) {

		return $value;

	}

	*/


	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	/*

	function update_value( $value, $post_id, $field ) {

		return $value;

	}

	*/


	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/

	/*

	function delete_value( $post_id, $key ) {



	}

	*/


	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	/*

	function load_field( $field ) {

		return $field;

	}

	*/


	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	/*

	function update_field( $field ) {

		return $field;

	}

	*/


	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/

	/*

	function delete_field( $field ) {



	}

	*/


}


// initialize
new acf_field_hotspots( $this->settings );


// class_exists check
endif;

?>
