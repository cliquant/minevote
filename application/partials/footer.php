<?php

    $online_users = $this->user->onlineUsers();
    
    echo "<p class='pt-20'>There are currently {$online_users['count']} users online.</p>";
    echo "<p>Online users: ".implode(", ", array_column($online_users['users'], 'username'))."</p>";
?>

</body>
</html>