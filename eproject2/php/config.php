<?php
// Database connection
include 'dbconnect.php';
// Fetch data from webconfig table
$sql = "SELECT * FROM webconfig";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $websiteName = $row["website_name"];
  $address = $row["address"];
  $phone = $row["phone"];
  $email = $row["email"];
  $webintro = $row["webintro"];
  $video = $row["video"];
  $mapaddress = $row["google_address"];
  // Assuming social links are stored as an array in the database
  $socialLinks = json_decode($row["social_links"], true);
} else {
  echo "No data found in webconfig table";
}
