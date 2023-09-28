<?php
/**
 * Plugin Name:     my-plugin
 * Description:     必須プラグイン
 * Plugin URI:      https://osgsm.io/
 * Author:          osgsm
 * Author URI:      https://osgsm.io/
 * Text Domain:     my-plugin
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         my-plugin
 */

/**
 * Load includes.
 */
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/admin.php';
require_once __DIR__ . '/includes/post-type-and-taxonomy.php';
require_once __DIR__ . '/includes/emoji.php';

/**
 * Registers blocks and block patterns.
 */
require_once __DIR__ . '/blocks/index.php';
