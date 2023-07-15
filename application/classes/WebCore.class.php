<?php
    require_once ROOT_DIR."application/classes/Database.class.php";
    require_once ROOT_DIR.'application/classes/models/User.class.php';

class WebCore {

    public $config;
    public $language;
    public $GET;

    public $db;
    public $user;

    public function __construct() 
    {
        $this->GET = explode('/', $_SERVER['REQUEST_URI']);

        $this->config = require_once ROOT_DIR.'/application/inc/config.php';
        $this->language = require_once ROOT_DIR.'/application/languages/'.$this->config['language'].'.php';

        $this->db = new Database(
            $this->config['database']['name'], 
            $this->config['database']['user'], 
            $this->config['database']['password'], 
            $this->config['database']['host'], 
            $this->config['database']['port']
        );

        $this->user = new User($this->db);    
    }

    public function Header($page_title) 
    {
        require_once ROOT_DIR.'application/partials/header.php';
    }

    public function Footer()
    {
        require_once ROOT_DIR.'application/partials/footer.php';
    }

    public function Run() 
    {
        $view = $this->GET[1];

        if (empty($view)) return $this->MoveTo("/home");

        if (in_array($view, $this->config['views']) && is_dir(ROOT_DIR . 'application/views/' . $view)) {

            $file = $this->GET[2] ?? 'index';
            $filePath = ROOT_DIR . 'application/views/' . $view . '/' . $file . '.php';

            if (file_exists($filePath)) {
                return require_once $filePath;
            }
        }

        return $this->MoveTo("/404");
    }

    public function MoveTo($url) {
        return header("Location: {$url}");
    }

}

$WebCore = new WebCore();