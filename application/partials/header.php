<?php 
    session_start(); 
    
    //check if session cookie is set and not expired
    if(isset($_SESSION['username']) && $_SESSION['expires'] > time()){
        //update session expire time
        $_SESSION['expires'] = time() + 60 * 60 * 24 * 30;
    }else{
        //redirect to login page
        $this->user->logout();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo "{$page_title} - {$this->config['title']}" ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<?php 
    foreach ($this->config['menu'] as $item) {
        if($item['name'] == 'sign-in' && isset($_SESSION['username'])) continue;
        if($item['name'] == 'sign-up' && isset($_SESSION['username'])) continue;

        echo '<a href="' . $item['url'] . '" class="mr-4 uppercase bg-blue-500">' . $item['name'] . '</a>';
    }

    if(isset($_SESSION['username'])){
        echo '
            <span>Hi, ' . $_SESSION['username'] . '</span>
            <a href="/auth/logout" class="mr-4 uppercase bg-red-500">Logout</a>
        ';
    }
?>

