<?php

/**
 * @group forms
 */
class Tests_Forms extends CF_API_Unit_Test_Case {


	public function setUp() {
		parent::setUp();

		global $wp_rewrite, $wp_query;
		$GLOBALS['wp_rewrite']->init();
		flush_rewrite_rules( false );

		
	}

}

