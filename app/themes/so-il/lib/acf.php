<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_page-sections',
		'title' => 'Page Sections',
		'fields' => array (
			array (
				'key' => 'field_533f189398313',
				'label' => 'Sections',
				'name' => 'sections',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_533f18ac98314',
						'label' => 'Subtitle',
						'name' => 'subtitle',
						'type' => 'text',
						'required' => 1,
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_533f18c898315',
						'label' => 'Text',
						'name' => 'text',
						'type' => 'wysiwyg',
						'column_width' => '',
						'default_value' => '',
						'toolbar' => 'full',
						'media_upload' => 'no',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Add Section',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'page_template',
					'operator' => '!=',
					'value' => 'page-contact.php',
					'order_no' => 1,
					'group_no' => 0,
				),
				array (
					'param' => 'page_template',
					'operator' => '!=',
					'value' => 'page-simple.php',
					'order_no' => 2,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => -20,
	));
	register_field_group(array (
		'id' => 'acf_attached-media',
		'title' => 'Attached Media',
		'fields' => array (
			array (
				'key' => 'field_53bf336a59caa',
				'label' => 'Archive Thumbnail',
				'name' => 'archive_thumbnail_id',
				'type' => 'number',
				'instructions' => 'Thumbnail to use on archive (for projects only). Defaults to first image.',
				'default_value' => 0,
				'placeholder' => '',
				'prepend' => 'Unique ID:',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_53268ffb74314',
				'label' => 'Images & Videos',
				'name' => 'images',
				'type' => 'repeater',
				'instructions' => 'Images will be displayed in the order below in full-screen mode.<br>
	The first image will be used as the thumbnail for the project in the Archive.<br>
	Add footnotes to the text above by wrapping text in brackets and appending the unique IDs of the images footnoted (e.g. 1, 4 & 5): [example text to be footnoted 1 4 5]',
				'sub_fields' => array (
					array (
						'key' => 'field_535ec2b077a75',
						'label' => 'Media Type',
						'name' => 'media_type',
						'type' => 'radio',
						'required' => 1,
						'column_width' => '',
						'choices' => array (
							'image' => 'Image',
							'video' => 'Video',
						),
						'other_choice' => 0,
						'save_other_choice' => 0,
						'default_value' => 'image',
						'layout' => 'horizontal',
					),
					array (
						'key' => 'field_5326900974315',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_535ec2b077a75',
									'operator' => '==',
									'value' => 'image',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => 20,
						'save_format' => 'object',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					array (
						'key' => 'field_536092d8e3cfa',
						'label' => 'Display Full Bleed',
						'name' => 'full_bleed',
						'type' => 'true_false',
						'column_width' => '',
						'message' => 'Display this media to fit the browser window?',
						'default_value' => 1,
					),
					array (
						'key' => 'field_535ec32177a76',
						'label' => 'Vimeo ID',
						'name' => 'vimeo_id',
						'type' => 'text',
						'instructions' => 'e.g. the ID for a video at https://vimeo.com/93188598 would be 93188598',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_535ec2b077a75',
									'operator' => '==',
									'value' => 'video',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => 'https://vimeo.com/',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => 10,
					),
					array (
						'key' => 'field_53b4b4e90cf6f',
						'label' => 'Sound',
						'name' => 'play_sound',
						'type' => 'true_false',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_535ec2b077a75',
									'operator' => '==',
									'value' => 'video',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => '',
						'message' => 'Play sound?',
						'default_value' => 0,
					),
					array (
						'key' => 'field_5326901274316',
						'label' => 'Caption',
						'name' => 'caption',
						'type' => 'text',
						'column_width' => 40,
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5339fd3a3afad',
						'label' => 'Caption Color',
						'name' => 'caption_color',
						'type' => 'radio',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_536092d8e3cfa',
									'operator' => '==',
									'value' => '1',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => 10,
						'choices' => array (
							'black' => 'Black',
							'white' => 'White',
						),
						'other_choice' => 0,
						'save_other_choice' => 0,
						'default_value' => 'black',
						'layout' => 'vertical',
					),
					array (
						'key' => 'field_53bf5c62db336',
						'label' => 'Caption',
						'name' => 'hide_popup_caption',
						'type' => 'true_false',
						'column_width' => '',
						'message' => 'Hide caption in large image sequence?',
						'default_value' => 0,
					),
					array (
						'key' => 'field_532690ef74317',
						'label' => 'Unique ID',
						'name' => 'unique_id',
						'type' => 'number',
						'instructions' => 'A unique number to footnote this image from the text',
						'column_width' => 30,
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => '',
						'max' => '',
						'step' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Add Media',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'project',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_lecture-details',
		'title' => 'Lecture Details',
		'fields' => array (
			array (
				'key' => 'field_532687a93d85e',
				'label' => 'Venue',
				'name' => 'venue',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5326883a3d85f',
				'label' => 'Location',
				'name' => 'location',
				'type' => 'text',
				'instructions' => 'e.g. San Francisco, CA',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_532688583d860',
				'label' => 'Lecture Name',
				'name' => 'name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5326888c3d861',
				'label' => 'Date',
				'name' => 'date',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'lecture',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_portfolio-pdf',
		'title' => 'Portfolio PDF',
		'fields' => array (
			array (
				'key' => 'field_53d2a700ea1b7',
				'label' => 'PDF',
				'name' => 'portfolio_pdf',
				'type' => 'file',
				'save_format' => 'url',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-contact.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_project-data',
		'title' => 'Project Data',
		'fields' => array (
			array (
				'key' => 'field_53bf281879b8c',
				'label' => 'Client',
				'name' => 'client',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53bf287c79b8d',
				'label' => 'Location',
				'name' => 'location',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53c00e522c6bd',
				'label' => 'Program',
				'name' => 'program',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53bf288379b8e',
				'label' => 'Area (meters)',
				'name' => 'area_meters',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53bf289779b8f',
				'label' => 'Area (feet)',
				'name' => 'area_feet',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53bf28b079b91',
				'label' => 'Status',
				'name' => 'status',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53bf28ba79b92',
				'label' => 'Team',
				'name' => 'team',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_53bf28ba79b92sd',
				'label' => 'Deck',
				'name' => 'deck',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_53bf28c379b93',
				'label' => 'Collaborators',
				'name' => 'collaborators',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_53bf28f579b94',
				'label' => 'Press',
				'name' => 'press',
				'type' => 'relationship',
				'return_format' => 'object',
				'post_type' => array (
					0 => 'writeup',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'post_title',
				),
				'max' => '',
			),
			array (
				'key' => 'field_53bf293a79b95',
				'label' => 'Miscellaneous',
				'name' => 'miscellaneous',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_53bf295479b96',
						'label' => 'Title',
						'name' => 'misc_title',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_53bf296279b97',
						'label' => 'Text',
						'name' => 'misc_text',
						'type' => 'textarea',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'formatting' => 'br',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Add Row',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'project',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
  /*
			array (
				'key' => 'field_53268de7bd287',
				'label' => 'Feature',
				'name' => 'is_featured',
				'type' => 'true_false',
				'message' => 'Feature this project on the homepage?',
				'default_value' => 0,
			),
  */
	register_field_group(array (
		'id' => 'acf_project-details',
		'title' => 'Project Details',
		'fields' => array (
			array (
				'key' => 'field_53a0936d0dd20',
				'label' => 'Date',
				'name' => 'date',
				'type' => 'date_picker',
				'instructions' => 'Required for sorting this project in Archive. Only year will be displayed.',
				'required' => 1,
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
			array (
				'key' => 'field_53268de7bd2878',
				'label' => 'First Line Large',
				'name' => 'is_first_large',
				'type' => 'true_false',
				'message' => 'Make the first sentence in the project large type?',
				'default_value' => 1,
			),
			array (
				'key' => 'field_539b3ed031eb4',
				'label' => 'Feature Display Style',
				'name' => 'feature_display_style',
				'type' => 'select',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53268de7bd287',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'excerpt' => 'Large Image',
					'excerpt_video' => 'Large Video',
					'expanded' => 'Expanded',
				),
				'default_value' => 'excerpt',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_53b85fd9586f9',
				'label' => 'Vimeo ID',
				'name' => 'featured_vimeo_id',
				'type' => 'text',
				'instructions' => 'e.g. the ID for a video at https://vimeo.com/93188598 would be 93188598',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_539b3ed031eb4',
							'operator' => '==',
							'value' => 'excerpt_video',
						),
						array (
							'field' => 'field_53268de7bd287',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'https://vimeo.com/',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => 10,
			),
			array (
				'key' => 'field_53b87d843eaf4',
				'label' => 'Sound',
				'name' => 'featured_play_sound',
				'type' => 'true_false',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53268de7bd287',
							'operator' => '==',
							'value' => '1',
						),
						array (
							'field' => 'field_539b3ed031eb4',
							'operator' => '==',
							'value' => 'excerpt_video',
						),
					),
					'allorany' => 'all',
				),
				'message' => 'Play sound?',
				'default_value' => 0,
			),
			array (
				'key' => 'field_53268e6ebd288',
				'label' => 'Featured Image',
				'name' => 'homepage_image',
				'type' => 'image',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53268de7bd287',
							'operator' => '==',
							'value' => '1',
						),
						array (
							'field' => 'field_539b3ed031eb4',
							'operator' => '==',
							'value' => 'excerpt',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53609371d0878',
				'label' => 'Display Full Bleed',
				'name' => 'full_bleed',
				'type' => 'true_false',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53268de7bd287',
							'operator' => '==',
							'value' => '1',
						),
						array (
							'field' => 'field_539b3ed031eb4',
							'operator' => '!=',
							'value' => 'expanded',
						),
					),
					'allorany' => 'all',
				),
				'message' => 'Display this media to fit the browser window?',
				'default_value' => 1,
			),
			array (
				'key' => 'field_5338f5374a8a7',
				'label' => 'Featured Text Color',
				'name' => 'featured_text_color',
				'type' => 'radio',
				'instructions' => 'Choose the color the text should appear as when viewing this project on the homepage.',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53268de7bd287',
							'operator' => '==',
							'value' => '1',
						),
						array (
							'field' => 'field_53609371d0878',
							'operator' => '==',
							'value' => '1',
						),
						array (
							'field' => 'field_539b3ed031eb4',
							'operator' => '!=',
							'value' => 'expanded',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'black' => 'Black',
					'white' => 'White',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'black',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_53bf5cd132213',
				'label' => 'Caption',
				'name' => 'hide_caption',
				'type' => 'true_false',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53268de7bd287',
							'operator' => '==',
							'value' => '1',
						),
						array (
							'field' => 'field_539b3ed031eb4',
							'operator' => '!=',
							'value' => 'expanded',
						),
					),
					'allorany' => 'all',
				),
				'message' => 'Hide caption in large image sequence?',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'project',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_project-pdf',
		'title' => 'Project PDF',
		'fields' => array (
			array (
				'key' => 'field_53a9c98801dde',
				'label' => 'PDF',
				'name' => 'pdf',
				'type' => 'file',
				'save_format' => 'url',
				'library' => 'uploadedTo',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'project',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_publication-details',
		'title' => 'Publication Details',
		'fields' => array (
			array (
				'key' => 'field_5326844c01419',
				'label' => 'Publisher',
				'name' => 'publisher',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_532684780141a',
				'label' => 'Date',
				'name' => 'date',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'publication',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_related-projects',
		'title' => 'Related Projects',
		'fields' => array (
			array (
				'key' => 'field_53691d97ca774',
				'label' => 'Related Projects & Writings',
				'name' => 'related_projects',
				'type' => 'relationship',
				'return_format' => 'object',
				'post_type' => array (
					0 => 'project',
					1 => 'writing',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'post_title',
				),
				'max' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'project',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_related-writings',
		'title' => 'Related Writings',
		'fields' => array (
			array (
				'key' => 'field_53691e1ad5268',
				'label' => 'Related Writings & Projects',
				'name' => 'related_writings',
				'type' => 'relationship',
				'return_format' => 'object',
				'post_type' => array (
					0 => 'project',
					1 => 'writing',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
					1 => 'post_type',
				),
				'result_elements' => array (
					0 => 'post_type',
					1 => 'post_title',
				),
				'max' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'writing',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_writeup-details',
		'title' => 'Writeup Details',
		'fields' => array (
			array (
				'key' => 'field_53268d757a39f',
				'label' => 'Publication',
				'name' => 'publication',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53268d7f7a3a0',
				'label' => 'Date',
				'name' => 'date',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
			array (
				'key' => 'field_533efcfed7fb9',
				'label' => 'Link Type',
				'name' => 'link_type',
				'type' => 'radio',
				'choices' => array (
					'none' => 'None',
					'url' => 'URL',
					'pdf' => 'PDF',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'none',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_533efca9d7fb7',
				'label' => 'URL',
				'name' => 'url',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_533efcfed7fb9',
							'operator' => '==',
							'value' => 'url',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_533efcd2d7fb8',
				'label' => 'PDF',
				'name' => 'pdf',
				'type' => 'file',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_533efcfed7fb9',
							'operator' => '==',
							'value' => 'pdf',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'writeup',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_writing-details',
		'title' => 'Writing Details',
		'fields' => array (
			array (
				'key' => 'field_532684e3dfa4e',
				'label' => 'Publication',
				'name' => 'publication',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_532684eadfa4f',
				'label' => 'Date',
				'name' => 'date',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
			array (
				'key' => 'field_5361e3114a446',
				'label' => 'Feature',
				'name' => 'is_featured',
				'type' => 'true_false',
				'message' => 'Feature this project on the homepage?',
				'default_value' => 0,
			),
			array (
				'key' => 'field_5361e2fb4a445',
				'label' => 'Featured Boost',
				'name' => 'featured_position',
				'type' => 'number',
				'instructions' => 'Boosts the position of this project on homepage (higher numbers are promoted higher on the page)',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5361e3114a446',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'writing',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'format',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_loader',
		'title' => 'Loader',
		'fields' => array (
			array (
				'key' => 'field_53ea8ad579697',
				'label' => 'Show Loader',
				'name' => 'show_loader',
				'type' => 'true_false',
				'message' => 'Show loader when first entering site?',
				'default_value' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_lecture-notes',
		'title' => 'Lecture Notes',
		'fields' => array (
			array (
				'key' => 'field_5400d5e0cfa0f',
				'label' => 'Additional Notes',
				'name' => 'extra_notes',
				'type' => 'wysiwyg',
				'instructions' => 'All formatting other than links will be stripped from this content when it is displayed.',
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'lecture',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
