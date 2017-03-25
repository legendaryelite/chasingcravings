<!DOCTYPE  html>
<head><title> CreateUserAccount</title></head>
<body>
<div>
<h1> Create User Account</h1>
<form action = "CreateAccount.php">
    <div class="container">
        <label><b>Username</b></label>
        <input type = "text" placeholder="Enter Username" name ="username" required>
    </div>
    <div class="container">
        <label><b>Email</b></label>
        <input type = "text" placeholder="Enter Email" name ="email" required>
    </div>
    <div class="container">
        <label><b>Password</b></label>
        <input type = "text" placeholder="Enter Password" name ="password" required>
     </div>
    <div class="container">
        <label><b>Confirm Password</b></label>
        <input type = "text" placeholder="Re-Enter Password" name ="confirmpassword" required>
     </div>

    <div class="container">
        <button type ="submit"> Submit</button>
       <button type ="submit"> Submit</button>
     </div>
</form>
</body>
</html>
