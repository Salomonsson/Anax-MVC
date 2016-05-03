<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

require __DIR__.'/config_with_app.php'; 


// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function() use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});


$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});


$di->set('UserController', function() use ($di) {
    $controller = new \Anax\Users\UserController();
    $controller->setDI($di);
    return $controller;
});




$app = new \Anax\Kernel\CAnax($di);
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->setVariable('title', "pokemon");
 


$app->router->add('', function() use ($app) {
    $meFun = new \Mos\Me\CMe();
    $regards = $meFun->hello();


    //$regards = 'test från denna sida. ';
    $app->views->add('welcome/hello_world', [
        'content' => $regards
    ]);
});
 
 



$app->router->add('redovisning', function() use ($app) {
 
    $meFun = new \Mos\Me\CMe();



    $app->theme->setTitle("Redovisning");
 
    
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    #$byline  = $app->fileContent->get('byline.md');
 
 	#$content = 'content test';
 	$byline = 'byline test --??';
 	
    $app->views->add('me/redovisning', [
        'content' => $content,
        'byline' => $meFun->hello(),
    ]);
 
});

$app->router->add('book', function() use ($app) {

    $app->theme->setTitle("comment to Anax Guestbook - p");
    $app->views->add('comment/index');

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);

    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => null,
        'output'    => null,
    ]);


});
 


// Get all users
$app->router->add('users', function () use ($app) {

        $app->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'list',
        ]); 
 });


// Test form route
$app->router->add('users/id/', function () use ($app) {

        $app->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'id',
        ]); 
 });


$app->router->handle();
$app->theme->render();