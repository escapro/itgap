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
|	https://codeigniter.com/user_guide/general/routing.html
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
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

// Redirect to 404 page
$redirect_404 = array(
    'home',
    'post',
    'category/tag/(:any)',
    'category',
    'admin',
    'auth'
);
foreach ($redirect_404 as $url) {
    $route[$url] = function () {
        show_404();
    };
}

// Основные роуты
$route['user'] = 'user/index';
// $route['admin'] = 'admin/index';
$route['contacts'] = 'page/contacts';
$route['rights'] = 'page/rights';

$route['post/new'] = 'post/new';
$route['post/fetch'] = 'post/fetch';
$route['post/(:any)/preview'] = 'post/preview/$1';

$route['tag/fetch'] = 'category/tag_fetch';

$route['category/fetch'] = 'category/category_fetch';
$route['category/(:any)'] = 'category/category/$1';

// $route['books/(:any)'] = 'category/index/$1';

$route['search/fetch'] = 'search/fetch';

$route['writing/(:any)/delete'] = 'writing/delete/$1';
$route['writing/(:any)/edit'] = 'writing/edit/$1';

$route['top'] = 'home/top';

$route['oauth/(:any)/(:any)'] = 'oauth/$1/$2';

$route['goto/(:any)'] = 'url/redirect/$1';

$route['(:any)/(:any)'] = function ($firts, $second) {

    switch ($firts) {
        case 'user':
            return 'user/'.$second;
            break;
        case 'tag':
            return 'category/tag/'.$second;
            break;
        case 'writing':
            return 'writing/'.$second;
            break;
        case 'upload':
            return 'upload/'.$second;
            break;
        case 'sitemap':
            return 'sitemap/'.$second;
            break;
        case 'post':
        case 'books':
            return 'post/show/'.$firts.'/'.$second;
            break;
        default:
        show_404();
        return;
    }
};