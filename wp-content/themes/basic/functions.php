<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'inc/init.php',              // Initial theme setup and constants
  'inc/acf-front-page.php',    // Theme wrapper class
  'inc/ACF/testimonials.php',  // ACF des témoignages
  'inc/custom-header.php',     // ConditionalTagCheck class
  'inc/assets.php',            // Scripts and stylesheets
  'inc/template-tags.php',     // Custom template tags
  'inc/customizer.php',        // customizer
  'inc/custom-login.php',      // custom-login
  'inc/dashboard-widgets.php', // cdashboard-widgets
  'inc/extras.php',            // Custom functions
  'libs/what-the-file.php',    // Show which template is used
  'libs/tool.class.php',       // Some tools to make development easier than ever
  'libs/simple-photoswipe/simple-photoswipe.php',
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }
  require_once $filepath;
}

unset($file, $filepath);