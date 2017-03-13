<?

class Controller{
    static function json($data) {
        self::close();
        echo json_encode($data);
    }
    static function close() {
        R::close();
    }
}

?>