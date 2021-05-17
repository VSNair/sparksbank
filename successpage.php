<?php echo file_get_contents("html/header1.html"); ?>
<title> Successful </title>
<?php echo file_get_contents("html/header2.html"); ?>

<?php
include 'databaseConnections/custdatabase.php';
$conn = OpenCon();
session_start();
$payeraccno = $_SESSION["payer"];
$payeeaccno = $_SESSION["payee"];
$amount = $_SESSION["amt"];
$sql1 = "SELECT * FROM customer WHERE AccountNo = '$payeraccno'";
$result1 = pg_query($conn, $sql1);
if ($result1) {
?>
    <table class="styled-table" style="width: 60%">
        <thead>
            <tr>
                <th colspan="3">Payer Details</th>
            </tr>
            <tr style="background-color: rgba(17, 124, 143, .5)">
                <th>Account No.</th>
                <th>Name</th>
                <th>Email Address</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align:center">
                <?php
                while ($row = pg_fetch_row($result1)) {
                ?>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td><?php echo $row[3]; $payerbal = $row[4];?></td>
                <?php
                }
                ?>
            </tr>
        </tbody>
    </table>
<?php
} else {
    echo "0 results";
}
$sql = "UPDATE customer SET CurrentBalance = $payerbal-$amount WHERE AccountNo = '$payeraccno'";

if (pg_query($conn, $sql) === FALSE) {
    echo "Error updating record: " . pg_last_error($conn);
}
?>

<?php
$sql2 = "SELECT * FROM customer WHERE AccountNo = '$payeeaccno'";
$result2 = pg_query($conn, $sql2);
if ($result2) {
?>
    <table class="styled-table" style="width: 60%">
        <thead>
            <tr>
                <th colspan="3">Payee Details</th>
            </tr>
            <tr style="background-color: rgba(17, 124, 143, .5)">
                <th>Account No.</th>
                <th>Name</th>
                <th>Email Address</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color:#f3f3f3; text-align:center">
                <?php
                while ($row = pg_fetch_row($result2)) {
                ?>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td><?php echo $row[3]; $payeebal = $row[4];?></td>
                <?php
                }
                ?>
            </tr>
        </tbody>
    </table>
<?php
} else {
    echo "0 results";
}
$sql = "UPDATE customer SET CurrentBalance = $payeebal+$amount WHERE AccountNo = '$payeeaccno'";

if (pg_query($conn, $sql) === FALSE) {
    echo "Error updating record: " . pg_last_error($conn);
}
pg_close($conn);
?>
<table class="styled-table" style="text-align:center; width: 200px; height: 200px">
    <thead>
        <th>Account No.</th>
        <th>Old Balance</th>
        <th>New Balance</th>
    </thead>
    <tbody>
        <tr>
            <th>Payer: <?php echo $payeraccno ?></th>
            <td><?php echo $payerbal ?></td>
            <td><?php echo $payerbal - $amount ?></td>
        </tr>
        <tr>
            <th>Payee: <?php echo $payeeaccno ?></th>
            <td><?php echo $payeebal ?></td>
            <td><?php echo $payeebal + $amount ?></td>
        </tr>
    </tbody>
</table>
<?php
$conn = OpenCon();
$sql = "INSERT INTO transact(PayerAcc, PayeeAcc, Amount) VALUES ('$payeraccno', '$payeeaccno', $amount)";
pg_query($conn,$sql);
pg_close($conn);
?>
<?php echo file_get_contents("html/footer.html"); ?>
<?php echo file_get_contents("html/sidenav.html"); ?>