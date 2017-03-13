<?

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/rb.php';

require __DIR__ . '/app/core/JWT.php';
require __DIR__ . '/app/core/controller.php';

$router = new AltoRouter();

R::setup( 'mysql:host=localhost;dbname=api',
        'root', '' );

require __DIR__ . '/app/routes.php';

$match = $router->match();

if( $match && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}

?>