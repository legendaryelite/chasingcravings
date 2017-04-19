<!DOCTYPE html>
<html>

<body>

<h1>Report An Issue</h1>

<form action = "Report.php">

   <div class = "container">
     <label for = "firstname"><b>First Name</b></label>
     <input type = "text" id="First Name" name ="firstname" placeholder = "Enter first name">

     <label for = "lastname"><b>Last Name</b></label>
     <input type = "text" id="Last Name" name ="lastname" placeholder = "Enter last name">
    
    
     <label for = "email"><b>Email</b></label>
     <input type = "text" id="email" name ="email" placeholder = "Enter email address">
     
     <label for = "issues"><b>Issue</b></label>
     <select id="issues" name ="issues">
         <option value = "inappropriate">Inappropriate Behavior</option>
         <option value = "wrongaddress">Address Was Incorrect</option>
         <option value = "nonexistent">Truck No Longer Exists</option>
         <option value = "siteerror">Issue With Website</option>
     </select>
    
    <label for = "report"><b>Report Issue</b></label>
     <text area id="report" name ="report" placeholder = "Please write about issue here..."
     style = "height: 300px"></textarea>
     <button type = "submit">Submit</button>
 </div>
</form>

</body>
</html>
