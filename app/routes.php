<?

$router->map( 'GET', '/organizations.get.all', function() {
    require __DIR__ . '/controllers/orgsctrl.php';
    $o = new OrgController();
    $o->index();
});

$router->map( 'GET', '/organizations.get.type/[i:id]', function($id) {
    require __DIR__ . '/controllers/orgsctrl.php';
    $o = new OrgController();
    $o->byType($id);
});

$router->map('GET', '/organizations.top', function () {
    require __DIR__ . '/controllers/orgsctrl.php';
    $o = new OrgController();
    $o->orderByRating();
});

$router->map('GET', '/organization.get/[i:id]', function ($id) {
    require __DIR__ . '/controllers/orgsctrl.php';
    $o = new OrgController();
    $o->orderById($id);
});

$router->map('GET', '/nearest/[i:x]/[i:y]/[i:id]', function ($x, $y, $id) {
    require __DIR__ . '/controllers/orgsctrl.php';
    $o = new OrgController();
    $o->nearest($x, $y, $id);
});

$router->map('POST', '/auth', function () {
    require __DIR__ . '/controllers/userctrl.php';
    $u = new UserController();
    $u->auth($_POST['number']);
});

$router->map('GET', '/profile', function () {
    require __DIR__ . '/controllers/userctrl.php';
    $u = new UserController();
    $u->check(function ($user) {
        Controller::json($user);
    }, function () {
        Controller::json(['message' => ':(']);
    });
});

$router->map('POST', '/signup', function () {
    require __DIR__ . '/controllers/userctrl.php';
    $u = new UserController();
    $u->signup();
});

$router->map('POST', '/signup.org', function () {
    require __DIR__ . '/controllers/orgsctrl.php';
    $o = new OrgController();
    $o->signup();
});

$router->map('GET', '/myreviews', function () {
    require __DIR__ . '/controllers/userctrl.php';
    $u = new UserController();
    $u->myreviews();
});

$router->map('DELETE', '/rw', function () {
    require __DIR__ . '/controllers/userctrl.php';
    $u = new UserController();
    $h = getallheaders();
    $u->delrw($h['REVIEW_ID']);
});

?>