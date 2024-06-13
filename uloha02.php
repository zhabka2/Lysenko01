<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Úloha 02</title>
</head>
<body>
    <div class="container">
        <?php
        require_once "connect.php";

        function execute_query($conn, $sql, $header) {
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "Error: " . mysqli_error($conn) . "<br>";
                return;
            }

            echo '<div class="table-container">';
            echo "<h2>$header</h2>";
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<thead><tr>";
                $fields = mysqli_fetch_fields($result);
                foreach ($fields as $field) {
                    echo "<th>" . $field->name . "</th>";
                }
                echo "</tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No results found.</p>";
            }
            echo '</div>';
        }

      
        echo "<h1>požiadavka 01</h1>";
        $sql = "SELECT o.OrderID, o.CustomerID, c.CompanyName
                FROM orders o
                INNER JOIN customers c ON o.CustomerID = c.CustomerID
                WHERE YEAR(o.OrderDate) = 1996";
        execute_query($conn, $sql, "Prehľad pre všetky objednávky z roku 1996 a ich zákazníkov");

        
        echo "<h1>požiadavka 02</h1>";
        $sql = "SELECT e.City, COUNT(DISTINCT e.EmployeeID) AS EmployeeCount, COUNT(DISTINCT c.CustomerID) AS CustomerCount
                FROM employees e
                INNER JOIN customers c ON e.City = c.City
                GROUP BY e.City";
        execute_query($conn, $sql, "Počet zamestnancov a zákazníkov z každého mesta, ktoré má zamestnancov");

        
        echo "<h1>požiadavka 03</h1>";
        $sql = "SELECT c.City, COUNT(DISTINCT e.EmployeeID) AS EmployeeCount, COUNT(DISTINCT c.CustomerID) AS CustomerCount
                FROM customers c
                LEFT JOIN employees e ON c.City = e.City
                GROUP BY c.City";
        execute_query($conn, $sql, "Počet zamestnancov a zákazníkov z každého mesta, ktoré má zákazníkov");

        
        echo "<h1>požiadavka 04</h1>";
        $sql = "SELECT City, COUNT(DISTINCT EmployeeID) AS EmployeeCount, COUNT(DISTINCT CustomerID) AS CustomerCount
                FROM (SELECT City, EmployeeID, NULL AS CustomerID FROM employees
                      UNION ALL
                      SELECT City, NULL AS EmployeeID, CustomerID FROM customers) AS combined
                GROUP BY City";
        execute_query($conn, $sql, "Počet zamestnancov a zákazníkov z každého mesta");

        
        echo "<h1>požiadavka 05</h1>";
        $sql = "SELECT o.OrderID, e.FirstName, e.LastName
                FROM orders o
                INNER JOIN employees e ON o.EmployeeID = e.EmployeeID
                WHERE o.ShippedDate > '1996-12-31'";
        execute_query($conn, $sql, "ID objednávok a súvisiace mená zamestnancov pre objednávky, ktoré boli odoslané po 1996-12-31");

        
        echo "<h1>požiadavka 06</h1>";
        $sql = "SELECT ProductID, SUM(Quantity) AS TotalQuantity
                FROM `order details`
                WHERE Quantity < 200
                GROUP BY ProductID";
        execute_query($conn, $sql, "Celkové množstvo objednaných produktov (menej ako 200)");

        
        echo "<h1>požiadavka 07</h1>";
        $sql = "SELECT CustomerID, COUNT(*) AS TotalOrders
                FROM orders
                WHERE OrderDate >= '1994-12-31'
                GROUP BY CustomerID
                HAVING COUNT(*) > 15";
        execute_query($conn, $sql, "Celkový počet objednávok podľa zákazníka od 31. decembra 1994");

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
