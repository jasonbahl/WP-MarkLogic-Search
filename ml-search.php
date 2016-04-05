<?php
/**
 * Plugin Name: MarkLogic Search
 * Plugin URI: http://www.marklogic.com
 * Description: Bring the power for MarkLogic to WordPress for search and content federation.
 * Version: 1.0
 * Text Domain: marklogic
 * Author: Christopher Davis
 * Author URI: https://www.pmg.com/blog/author/chris-davis/
 * License: GPL-2.0+
 *
 * Copyright 2015 PMG <https://www.pmg.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category    WordPress
 * @license     http://opensource.org/licenses/GPL-2.0 GPL-2.0+
 */

namespace MarkLogic\WpSearch;

!defined('ABSPATH') && exit;

define('ML_WPSEARCH_VER', '1.0.0');

\ML_Loader::register(__NAMESPACE__, __DIR__.'/inc');
\ML_Loader::register('MarkLogic\\MLPHP', __DIR__.'/vendor/mlphp/api/MarkLogic/MLPHP');
\ML_Loader::register('Psr\\Log', __DIR__.'/vendor/psr-log/Psr/Log');
require __DIR__.'/inc/functions.php';

add_action('plugins_loaded', 'ml_wpsearch_load');
