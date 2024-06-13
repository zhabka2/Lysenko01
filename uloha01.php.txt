<?php
require_once "connect.php";

// požiadavka 01
echo "<h1>požiadavka 01</h1>";

// Function to print all data from a table
function print_all_data($table_name, $conn) {
    $sql = "SELECT * FROM $table_name";
    $result = $conn->query($sql);
    echo "<h2>$table_name</h2>";
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr>";
        // Print table headers
        $fieldinfo = $result->fetch_fields();
        foreach ($fieldinfo as $val) {
            echo "<th>{$val->name}</th>";
        }
        echo "</tr>";
        // Print table rows
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found for table $table_name.";
    }
}

print_all_data('customers', $conn);
print_all_data('orders', $conn);
print_all_data('suppliers', $conn);

// požiadavka 02
echo "<h1>požiadavka 02</h1>";
$sql = "SELECT * FROM customers ORDER BY country, companyName";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1'><tr>";
    while ($fieldinfo = $result->fetch_field()) {
        echo "<th>{$fieldinfo->name}</th>";
    }
    echo "</tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

// požiadavka 03
echo "<h1>požiadavka 03</h1>";
$sql = "SELECT * FROM orders ORDER BY orderDate";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1'><tr>";
    while ($fieldinfo = $result->fetch_field()) {
        echo "<th>{$fieldinfo->name}</th>";
    }
    echo "</tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

// požiadavka 04
echo "<h1>požiadavka 04</h1>";
$sql = "SELECT COUNT(*) AS count FROM orders WHERE YEAR(orderDate) = 1995";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo "Počet objednávok v roku 1995: " . $row['count'];

// požiadavka 05
echo "<h1>požiadavka 05</h1>";
$sql = "SELECT contactName FROM customers WHERE contactTitle LIKE '%Manager%' ORDER BY contactName";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>" . $row['contactName'] . "</li>";
    }
    echo "</ul>";
}

// požiadavka 06
echo "<h1>požiadavka 06</h1>";
$sql = "SELECT * FROM orders WHERE orderDate = '1995-09-28'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1'><tr>";
    while ($fieldinfo = $result->fetch_field()) {
        echo "<th>{$fieldinfo->name}</th>";
    }
    echo "</tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();
?>