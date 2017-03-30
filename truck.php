<?php
$connection = mysqli_connect("localhost","root","","commentbox");
$name = $_POST['name'];
$comment = $_POST['comment'];
$submit = $_POST['submit'];

$dbLink = mysqli_connect("localhost", "root", "","commentbox");
    mysql_query("SET character_set_client=utf8", $dbLink);
    mysql_query("SET character_set_connection=utf8", $dbLink);

if($submit)
{
if($name&&$comment)
{
$insert=mysqli_query("INSERT INTO commenttable (name,comment) VALUES ('$name','$comment') ");
echo "<meta HTTP-EQUIV='REFRESH' content='0; url=commentindex.php'>";
}
else
{
echo "please fill out all fields";
}
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel = "stylesheet" type="text/css" href="truckpage.css"/>
  <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="css/bootstrap.min.css" rel="stylesheet">
<title></title>
</head>
<body>

<div id = "intro">
<h1> {Truck Name} </h1>
<p> This Is The {Truck Name}'s Personal Page. Here You Will Find The Current Location, Specials, Menu Items, Twitter Live Feed, And Any Thing The Owners Of The Trucks Decide To Post.</br>
  You Will Also Be Able To Give Ratings And Leave Comments Here.</p>
  <div class="form-group">
    <form action="truckpage.php" method="POST">
<table>
<tr><td>Name: <br><input type="text" name="name"/></td></tr>
<tr><td colspan="2">Comment: </td></tr>
<tr><td colspan="5"><textarea name="comment" rows="10" cols="50"></textarea></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Comment"></td></tr>
</table>
</form>

    <?php
$dbLink = mysqli_connect("localhost", "root", "","commentbox");
    mysql_query("SET character_set_results=utf8", $dbLink);
    mb_language('uni');
    mb_internal_encoding('UTF-8');

$getquery=mysqli_query("SELECT * FROM commenttable ORDER BY id DESC");
while($rows=mysql_fetch_assoc($getquery))
{
$id=$rows['id'];
$name=$rows['name'];
$comment=$rows['status'];
echo $name . '<br/>' . '<br/>' . $comment . '<br/>' . '<br/>' . '<hr size="1"/>'
;}
?>
    </div>
</div>
  <div>
    <a class="twitter-timeline" data-width="300" data-height="600" href="https://twitter.com/FoxNews">Tweets by FoxNews</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
  </div>


  <!--Need Comment Box
   Need GPS Locator
   Need Twitter Live Feed
   Need Updatable Menu
   Status Box/Wall -->
</body>
</html>
