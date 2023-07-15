<?php

    $response = false;
    $message = '';

    $this->Header("Sign Up");

    //redirect if user is already signed in
    if(isset($_SESSION['username'])) return $this->MoveTo('/home');

    //check if form is submitted
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $message = "";
        
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordVerify = $_POST['passwordVerify'];

        $results = $this->user->signUp($username, $email, $password, $passwordVerify);
        if($results['success']) {
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
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required>

        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>

        <label for="passwordVerify">Verify Password</label>
        <input type="password" name="passwordVerify" id="passwordVerify" placeholder="Enter your password again" required>

        <input type="submit" value="Sign Up">
</form>

<?php $this->Footer(); ?>