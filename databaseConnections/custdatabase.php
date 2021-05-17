<?php
function OpenCon()
{
    $host        = "host = ec2-54-220-35-19.eu-west-1.compute.amazonaws.com";
    $port        = "port = 5432";
    $dbname      = "dbname = dfbl6dt9tv32ll";
    $credentials = "user = jxxuanuksbdvvn password= a5ac10d0e75077d071af669549f9c3615320baa47bf98e9441dfc5714473454e";

    $conn = pg_connect("$host $port $dbname $credentials");
    if (!$conn) {
        return "Error : Unable to open database\n";
    } else {
        return $conn;
    }

}
function CloseCon($conn)
{
    $conn->close();
}
?> 