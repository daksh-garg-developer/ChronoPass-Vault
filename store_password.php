
<?php

if (isset($_POST['submit'])) {
    $website = $_POST['website'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $content = $_POST['content'];
    // Process the form data as needed
//     echo "Form submitted successfully!";
}
else {
    // echo "Form submitted successfully!";
}

$conn=mysqli_connect('localhost','root','','chronopass');

  if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
  }

  $website=$_POST['website'];
  $username=$_POST['username'];
  $password=$_POST['password'];
  $content=$_POST['content'];
$_query="INSERT INTO pass_form(`Website`, `Username`, `Password`, `Content`) VALUES ('$website', '$username', '$password', '$content')";
$data=mysqli_query($conn, $_query);
  
  if($data){
    // echo "Data inserted into database";
    
  }
  else{
    // echo "Failed to insert data into database";
  }
?>
echo "<script>alert('Password Saved Successfully!'); window.location.href='home.html';</script>";