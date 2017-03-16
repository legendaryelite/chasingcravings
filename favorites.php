<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="favorite.css"/>
  <title>Favorite Trucks</title>
</head>
<body>
  <h1> Hello {name} </h1> </br>
  <p>Welcome To Your Favorites Page. All Your Favorites Will Be Added To Page Via Adding Them Manually Here, Or Through The Trucks Pages Itself.</p>
  <p>Below Are Your Current Favorites</p>

  <script>
  var counter = 1; 
  var limit = 1000;
  function addInput(){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
              var newdiv = document.createElement('div');
              newdiv.innerHTML = "<div class='inputElement'><br>Favorite " + (counter + 1) + "<input type='text' name='Favorites[]'><input type ='button' value ='Remove' onClick='removeInput(this)'></div>";
              document.getElementById("Favorites").appendChild(newdiv);
              counter++;
       }
  }

  function removeInput(removeLink){
     var inputElement = removeLink.parentNode;
    inputElement.remove();
    counter = counter - 1;
  }
  </script>
  <form action="Favorites.php" method ="_POST">
   <div id="Favorites">
     <div class='inputElement'>
        Favorite 1<input type="text" name="Favorites[]">
     </div>
    </div>
    <br>
      <input type="button" value="Add New Favorite" onClick="addInput();">
     <input type = "submit" value = "Submit">
     <button type="button" style="btn-info" name="button">hey</button>
</form>

<p>Today&rsquo;s date (according to this web server) is

</p>
</body>
</html>

