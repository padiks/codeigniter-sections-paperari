<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
| Each rule below tells CodeIgniter how to interpret incoming URLs and
| which controller/method should handle them.
|
| Example:
|   http://example.com/books/view/mynoghra
|   → Calls Books controller → view('mynoghra')
*/

/* ---------------------------------------------------------
| Static Page Routes (no header/footer)
| ---------------------------------------------------------
| These routes allow you to serve plain PHP files directly
| from the /application/views/ directory without the default
| header/footer template.
|
| The "Page" controller handles these routes. It simply includes
| the target PHP file directly.
|
| Examples:
|   /page/lorem-ipsum         → views/lorem-ipsum/index.php
|   /page/lorem-ipsum/test    → views/lorem-ipsum/test.php
|
| Works on both Windows (Laragon) and Debian environments without
| hardcoding a base path like "tools/codeigniter".
*/
$route['page/(:any)/(:any)'] = 'page/view/$1/$2';
$route['page/(:any)']        = 'page/view/$1';

/**
 * Auth
 * Login
 */
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

/**
 * Default controller — homepage / main table of contents
 * If no URI is provided, load the 'Books' controller automatically.
 */
$route['default_controller'] = 'books';

/**
 * Route for site-wide search functionality
 * URL example: /search → handled by Search controller
 */
$route['search'] = 'search';

/**
 * Route for sitemap page
 * URL example: /sitemap → handled by Sitemap controller
 */
$route['sitemap'] = 'sitemap';

// Custom routes for bookmark
$route['bookmark'] = 'bookmark';
$route['bookmark/save'] = 'bookmark/save';

/**
 * Catch-all route for nested book structure
 * Matches any URL with two or more segments.
 *
 * Examples:
 *   /mynoghra/volume1/chapter1
 *   → Books controller → view('mynoghra', 'volume1/chapter1')
 *
 * (:any)  = first segment (book name)
 * (.+)    = everything after the first slash (volume/chapter path)
 */
$route['(:any)/(.+)'] = 'books/view/$1/$2';

/**
 * Route for single-book access
 * Matches URLs with only one segment.
 *
 * Example:
 *   /mynoghra
 *   → Books controller → view('mynoghra')
 */
$route['(:any)'] = 'books/view/$1';

/**
 * Custom 404 handler
 * If no route matches, load Errors controller → page_missing()
 */
$route['404_override'] = 'Errors/page_missing';

/**
 * Allow dashes in controller/method names?
 * FALSE = dashes not automatically translated to underscores.
 */
$route['translate_uri_dashes'] = FALSE;
