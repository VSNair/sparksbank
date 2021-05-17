<?php echo file_get_contents("html/header1.html"); ?>
<title> Transfer Page </title>
<?php echo file_get_contents("html/header2.html"); ?>
<?php echo "<h2> Funds Transfer </h2>" ?>

<?php
session_start();
$payeeErr = $payerErr = $amountErr = "";
$payee = $payer = $amount = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payer = test_input($_POST["payeraccno"]);
    $payee = test_input($_POST["payeeaccno"]);
    $amount = test_input($_POST["amount"]);
    if (empty($_POST["payeraccno"]) or empty($_POST["payeeaccno"]) or empty($_POST["amount"])) {
        if (empty($_POST["payer"])) {
            $payerErr = "Account number is required!";
        }
        if (empty($_POST["payee"])) {
            $payeeErr = "Account Number is required!";
        }
        if (empty($_POST["amount"])) {
            $amountErr = "Amount is required!";
        }
    } else if (!preg_match("/^[0-9.]*$/", $amount)) {
        $amountErr = "Only positive digits are allowed!";
    } else if ($payer == $payee) {
?>
        <script>
            swal({
                title: "Transfering to same account!",
                icon: "warning",
                button: "Ok",
            });
        </script>
        <?php
    } else {
        include 'databaseConnections/custdatabase.php';
        $conn = OpenCon();
        $payeraccno = $_POST["payeraccno"];
        $payeeaccno = $_POST["payeeaccno"];
        $amount = $_POST["amount"];
        $sql1 = "SELECT * FROM customer WHERE AccountNo = '$payeraccno'";
        $result1 = pg_query($conn, $sql1);
        if (pg_num_rows($result1)) {
            $row = pg_fetch_row($result1);
            if ($row[4] >= $amount) {
                $_SESSION["payer"] = $_POST["payeraccno"];
                $_SESSION["payee"] = $_POST["payeeaccno"];
                $_SESSION["amt"] = $_POST["amount"];
        ?>
                <script>
                    swal({
                        customClass: 'swalsuccess',
                        title: "Transfered Successfully!",
                        icon: "success",
                        button: "Ok",
                    }).then(function() {
                        window.location = "successpage.php";
                    });
                </script>
            <?php
            } else {
            ?>
                <script>
                    swal({
                        title: "Insufficient balance!",
                        icon: "error",
                        button: "Ok",
                    });
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                swal({
                    title: "Wrong Payer Account number!",
                    icon: "error",
                    button: "Ok",
                });
            </script>
        <?php
        }
        $sql2 = "SELECT * FROM customer WHERE AccountNo = '$payeeaccno'";
        $result2 = pg_query($conn, $sql2);
        if (pg_num_rows($result2) == 0) {
        ?>
            <script>
                swal({
                    title: "Wrong Payee Account number!",
                    icon: "error",
                    button: "Ok",
                });
            </script>
<?php
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <table class="styled-table-form">
        <thead>
            <tr>
                <th colspan="2">Funds Transfer Form</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2"><span class="error">* required field</span></td>
            </tr>
            <tr>
                <th>Payer Account No.</th>
                <td>
                    <input type="text" name="payeraccno">
                    <span class="error">* <?php echo $payerErr; ?></span>
                </td>
            </tr>
            <tr>
                <th>Payee Account No.</th>
                <td>
                    <input type="text" name="payeeaccno">
                    <span class="error">* <?php echo $payeeErr; ?></span>
                </td>
            </tr>
            
            <tr>
                <th>Enter Amount</th>
                <td>
                    <input type="text" name="amount">
                    <span class="error">* <?php echo $amountErr; ?></span>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><button class="button">Submit</button></td>
            </tr>
        </tfoot>
    </table>
</form>
<?php echo file_get_contents("html/footer.html"); ?>
<?php echo file_get_contents("html/sidenav.html"); ?>