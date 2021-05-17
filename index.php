<?php echo file_get_contents("html/header1.html"); ?>
<title> Home Page </title>
<?php echo file_get_contents("html/header2.html"); ?>
<h2><?php echo "Welcome to The Sparks Bank" ?></h2>
<div class="about">
    <b>About Us</b><br>
    A bank is a financial institution which is involved
     in borrowing and lending money. Banks take customer 
     deposits in return for paying customers an annual 
     interest payment. The bank then uses the majority 
     of these deposits to lend to other customers for 
     a variety of loans. The difference between the 
     two interest rates is effectively the profit margin 
     for banks. Banks play an important role in the 
     economy for offering a service for people wishing 
     to save. Banks also play an important role in 
     offering finance to businesses who wish to invest 
     and expand.
</div>
<div class="row">
    <div class="column">
        <div class="extra-card"></div>
    </div>
    <div class="column">
        <div class="card">
            <img src="img/user.jpg" alt="Customer" style="width:100%">
            <form action="customerpage.php" method="POST">
                <button class="button">View Customers</button>
            </form>
        </div>
    </div>

    <div class="column">
        <div class="card">
            <img src="img/transfer.jpg" alt="Transfer" style="width:100%">
            <form action="transferpage.php" method="GET">
                <button class="button">Funds Transfer</button>
            </form>
        </div>
    </div>

    <div class="column">
        <div class="card">
            <img src="img/history.jpg" alt="History" style="width:100%">
            <form action="historypage.php" method="POST">
                <button class="button">Transaction History</button>
            </form>
        </div>
    </div>
</div>

<?php echo file_get_contents("html/footer.html"); ?>
<?php echo file_get_contents("html/sidenav.html"); ?>
