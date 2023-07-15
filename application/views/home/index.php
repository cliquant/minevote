<?php 

    $this->Header($this->language['home']);


    if(isset($this->user->username)){
        echo "Welcome, {$this->user->username}";
    };

    $this->Footer();