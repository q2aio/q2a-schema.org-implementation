<?php

/*
	Plugin Name: Q2A schema.org implementation
	Plugin URI: https://github.com/PublicityPort/q2a-schema.org-implementation
	Plugin Description: Simply implements schema.org specifications for the Question and Answer site.
	Plugin Version: 1.0.2
	Plugin Date: 2014-09-09
	Plugin Author: Publicity Port
	Plugin Author URI: https://publicityport.com
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.7.5
	Plugin Minimum PHP Version: 5
	Plugin Update Check URI: https://raw.githubusercontent.com/PublicityPort/q2a-schema.org-implementation/master/qa-plugin.php
*/

/*
	Based on PublicityPort Login plugin
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

qa_register_plugin_layer('qa-layer-changer.php', 'Schema.org implementation');

qa_register_plugin_module('module', 'qa-schema-impl-admin.php', 'qa_schema_impl_admin', 'Q2A Schema.org impl Configuration');

/*
	Omit PHP closing tag to help avoid accidental output
*/
