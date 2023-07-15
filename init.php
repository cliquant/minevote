<?php
    error_reporting( E_ALL^E_NOTICE );
    ini_set( 'display_errors', 1 );

    define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']."/");

    require_once "application/classes/WebCore.class.php";