<?

class OrgController extends Controller{
    function index() {
        header("Content-type:application/json");
        header("Access-Control-Allow-Origin: *");
        $orgs = R::findAll('organization');
        self::json($orgs);
    }
    function byType($id) {
        header("Content-type:application/json");
        header("Access-Control-Allow-Origin: *");
	    $orgs = R::findAll('organization', ' type_id = ? ', [ $id ]);
        self::json($orgs);
    }
    function orderByRating() {
        header("Content-type:application/json");
        header("Access-Control-Allow-Origin: *");
	    $orgs = R::findAll('organization', ' ORDER BY `sub_b` DESC LIMIT 10 ');
        self::json($orgs);
    }
    function orderById($id) {
        header("Content-type:application/json");
        header("Access-Control-Allow-Origin: *");
	    $orgs = R::findOne('organization', 'id = ?', [$id]);
        self::json($orgs);
    }
    function signup() {
        try{
            $organization = R::dispense('organization');
            $organization->name = $_POST['name'];
            $organization->number = $_POST['number'];
            $organization->email = $_POST['email'];
            $organization->address = $_POST['address'];
            $organization->description = $_POST['description'];
            $organization->typeId = $_POST['typeId'];
            $organization->coordianteX = $_POST['coordianteX'];
            $organization->coordianteY = $_POST['coordianteY'];
            $organization->countB = 0;
            $organization->subB = 0;
            $id = R::store($organization);
            self::json($id);
        }catch(Exception $e) {
            self::json(['message' => 'error']);
        }
    }
    function nearest($x, $y, $id) {
        $coords = [
            $x - 12, $y - 12,
            $x + 12, $y + 12
        ];
        header("Content-type:application/json");
        header("Access-Control-Allow-Origin: *");
	    /*$orgs = R::getAssoc("
            SELECT * FROM `organization` WHERE `coordinate_x` => ".$xy[0]." AND `coordinate_x` <= ".$xy[2]."
            AND `coordinate_y` => ".$xy[1]." AND `coordinate_x` <= ".$xy[3]."
        ");*/
        R::close();
        $db = new PDO('mysql:host=localhost;dbname=api', 'root', '');
        $data = $db->query("
            SELECT * FROM `organization` WHERE `type_id` = '".$id."' AND 
            coordiante_x >= ".$coords[0]." AND coordiante_y >= ".$coords[1]." AND
            coordiante_x <= ".$coords[2]." AND coordiante_y <= ".$coords[3]."
        ");
        $d = $data->fetchall(PDO::FETCH_ASSOC);
        $data = null;
        $db = null;
        echo json_encode($d);
    }
}

?>