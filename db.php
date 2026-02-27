<?php

define('servername','localhost');
define('hostname','root');
define('password', '');
define('database','busineess_ratings');
$conn = mysqli_connect(servername, hostname,password,database);

if(!$conn){
   die ("connection Failed !".mysqli_error());
}
// else{
//     echo "connection Successfully.";
// }