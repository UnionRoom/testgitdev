<?php

// Base functions
require_once(get_template_directory() . '/functions/base.php');

// Admin area functions
require_once(get_template_directory() . '/functions/base-admin-area.php');

// UR Functions
require_once(get_template_directory() . '/functions/ur/layouts.php');
require_once(get_template_directory() . '/functions/ur/schema.php');

/* Don't edit the files above */

// Post types, associated taxonomies, and column creation/alteration
locate_template('functions/custom-post-types.php', TRUE);

// Shortcodes
locate_template('functions/custom-shortcodes.php', TRUE);

// Custom front end functions
locate_template('functions/custom-front-end.php', TRUE);

// Custom admin area functions
locate_template('functions/custom-admin-area.php', TRUE);