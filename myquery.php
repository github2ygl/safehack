<?php
$host = '';
$dbname = '';
$user = '';
$passwd = '';

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $passwd);
    
    // Allow executing multiple SQL statements in one request
    $pdo->setAttribute(PDO::MYSQL_ATTR_MULTI_STATEMENTS, true);

    // Retrieve the user's SQL statement from a form or any other source
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userSql = $_POST['sql_statement'];

        // Execute the user's SQL statement
        $result = $pdo->query($userSql);

        // Display the results or handle errors
        if ($result !== false) {
            echo '<h2>Query Results:</h2>';
            echo '<pre>';
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                print_r($row);
            }
            echo '</pre>';
        } else {
            echo '<h2>Error:</h2>';
            echo '<pre>';
            print_r($pdo->errorInfo());
            echo '</pre>';
        }
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Execute SQL Statement</title>
</head>
<body>
    <h1>Execute SQL Statement</h1>
    <form method="POST">
        <label for="sql_statement">Enter your SQL statement:</label><br>
        <textarea name="sql_statement" id="sql_statement" rows="5" cols="40"></textarea><br>
        <input type="submit" value="Execute">
    </form>
</body>
</html>
