<?php echo file_get_contents("html/header1.html"); ?>
    <title> Customer Page </title>
<?php echo file_get_contents("html/header2.html"); ?>
    <?php echo "<h2>List of Customers</h2>" ?>
    <?php
        include 'databaseConnections/custdatabase.php';
        $conn = OpenCon();

        $sql = "SELECT * FROM customer order by serialno";
        $result = pg_query($conn, $sql);
        
        if (pg_num_rows($result)) {
            // output data of each row
            ?>
            <table class="styled-table">
                <thead>
                    <th>Serial No.</th>
                    <th>Account No.</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Current Balance</th>
                </thead>
                <tbody>
                    <?php
                        while($row = pg_fetch_row($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo $row[4] ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        <?php
        } 
        else{
            echo "0 results";
        }
        pg_close($conn);
    ?>
<?php echo file_get_contents("html/footer.html"); ?>
<?php echo file_get_contents("html/sidenav.html"); ?>