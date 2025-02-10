   <?php
    $dsn = 'mysql:host=localhost;dbname=cms;';
    $username = 'root';
    $password = '';
    $db = new PDO($dsn, $username, $password);
    $development_mode = true;
    ?>