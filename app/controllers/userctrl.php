<?

class UserController extends Controller{
    function auth($number) {
        header("Content-type:application/json");
        header("Access-Control-Allow-Origin: *");
        $u = R::findOne('user', 'number = ?', [ $number ]);
        if($u != null) {
            $data = JWT::encode(['number' => $number], 'supersecretkey');
            self::json(['token' => $data]);
        }else{
            self::json(['message' => 'error']);
        }
    }
    function check($func, $funcErr) {
        $headers = getallheaders();
        if(isset($headers['Authorization'])) {
            $data = JWT::decode($headers['Authorization'], 'supersecretkey');
            $u = R::findOne('user', 'number = ?', [$data->number]);
            if($u != null) {
                $func($u);
            }else{
                $funcErr();
            }
        }else{
            $funcErr();
        }
    }
    function signup() {
        try{
            $user = R::dispense('user');
            $user->name = $_POST['name'];
            $user->number = $_POST['number'];
            $user->email = $_POST['email'];
            $user->sex = $_POST['sex'];
            $user->age = $_POST['age'];
            $id = R::store($user);
            self::json($id);
        }catch(Exception $e) {
            self::json(['message' => 'error']);
        }
    }
    function myreviews() {
        $this->check(function ($user) {
            $rw = R::findAll('review', 'userId = ?', [$user->id]);
            self::json($rw);
        }, function () {
            self::json(['message' => 'error']);
        });
    }
    function delrw($id) {
        $this->check(function ($user) use($id) {
            $rw = R::findOne('review', 'id = ?', [$id]);
            R::trash($rw);
        }, function () {
            self::json(['message' => 'error']);
        });
    }
}

?>