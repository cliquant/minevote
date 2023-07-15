<?php

    $response = false;
    $message = '';

    $this->Header("Sign In");

    //redirect if user is already signed in
    if(isset($_SESSION['username'])) return $this->MoveTo('/home');

    //check if form is submitted
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $message = "";
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        $results = $this->user->signIn($username, $password);
        if($results['success']) {
            $response = true;
            $message = $results['message'];

            $this->MoveTo('/home');
        } else {
            $response = true;
            $message = $results['message'];
        }
    }
?>


<form action="" method="post" class="pt-20">
        <?php
            if($response) {
                echo "<p>{$message}</p>";
            }
        ?>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>

        <input type="submit" value="Sign In">
</form>

<?php $this->Footer(); ?>