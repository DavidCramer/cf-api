<?php
/**
 * Caldera Forms API.
 *
 * @package   Caldera_Forms_Api
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 David Cramer
 */
namespace calderawp\cf_api;

/**
 * @package Caldera_Forms_Api
 * @author  David Cramer
 */
class routes  {

	/**
	 * Register the routes for the objects of the controller.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		register_rest_route( 'cf', '/forms', array(
			array(
				'methods'         => \WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_forms' ),
				//'permission_callback' => array( $this, 'get_form_permissions_check' ),
				'args'            => array(
					'context'          => array(
						'default'      => 'view',
					)
				),
			)
		) );

		register_rest_route( 'cf', '/forms/(?<id>[^/]+)', array(
			array(
				'methods'         => \WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_form' ),
				//'permission_callback' => array( $this, 'get_form_permissions_check' ),
				'args'            => array(
					'context'          => array(
						'default'      => 'view',
					)
				),
			)
		) );

		register_rest_route( 'cf', '/forms/(?<id>[^/]+)/fields', array(
			array(
				'methods'         => \WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_fields' ),
				//'permission_callback' => array( $this, 'get_form_permissions_check' ),
				'args'            => array(
					'context'          => array(
						'default'      => 'view',
					)
				),
			)
		) );
		register_rest_route( 'cf', '/forms/(?<id>[^/]+)/fields/(?<field>[^/]+)', array(
			array(
				'methods'         => \WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_field' ),
				//'permission_callback' => array( $this, 'get_form_permissions_check' ),
				'args'            => array(
					'context'          => array(
						'default'      => 'view',
					)
				),
			)
		) );


	}


	/**
	 * Get all forms
	 *
	 * @return \WP_REST_Response
	 */
	public function get_forms( ) {
		
		return new \WP_REST_Response( \Caldera_Forms::get_forms(), 200 );

	}

	/**
	 * Get one form
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_form( $request ) {

		$form_id = $request;
		if ( $request instanceof \WP_REST_Request ) {
			$form_id = $request->get_param( 'id' );
		}

		$form = \Caldera_Forms::get_form( $form_id );

		if( null === $form ){
			return new \WP_Error( 'invalid_form_id', __('Invalid Form ID', 'caldera-forms') );
		}

		return new \WP_REST_Response( $form, 200 );

	}

	/**
	 * Get HTML all fields in one form
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_fields( $request ) {
		$form = $this->get_form( $request );
		if( is_wp_error( $form ) ){
			return $form;
		}

		$fields = array();
		foreach( $form->data['fields'] as $field_id => $field ){
			$fields[ $field_id ] = \Caldera_Forms::render_field( $field, $form->data );
		}
		
		return new \WP_REST_Response( $fields, 200 );

	}

	/**
	 * Get HTML one fields in one form
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_field( $request ) {

		$form = $this->get_form( $request );
		if( is_wp_error( $form ) ){
			return $form;
		}
		if( !isset( $form->data[ 'fields' ][ $request->get_param( 'field' ) ] ) ){
			return new \WP_Error( 'invalid_form_field', __('Invalid Form ID', 'caldera-forms') );			
		}
		$field = \Caldera_Forms::render_field( $form->data[ 'fields' ][ $request->get_param( 'field' ) ], $form->data );

		return new \WP_REST_Response( $field, 200 );


	}


}
