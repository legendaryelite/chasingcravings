<!DOCTYPE html>
<html>
<body>

<h1>Login</h1>

<form action = "loginPage.php">

   <div class = "container">
     <label><b>Username</b></label>
     <input type = "text" placeholder="Enter Username" name ="username" required>
   </div>
    
   <div class = "container">
     <label><b>Password</b></label>
     <input type = "text" placeholder="Enter Password" name ="password" required>

     <button type ="submit">Login</button>
     <input type ="checkbox" checked = "checked"> Remember me
   </div>

   <div clas ="container">
     <button type = "button" class ="cancelbtn">Cancel</button>
     <button type = "button" class ="forgotbtn">Forgot Password?</button>
   </div>
</form>

</body>
</html>
