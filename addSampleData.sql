INSERT INTO `useraccounts`(`userID`, `username`, `email`, `pwd`, `acctType`) VALUES (1,"billy","billy@gmail.com","abc123","user");
INSERT INTO `useraccounts`(`userID`, `username`, `email`, `pwd`, `acctType`) VALUES (2,"bobby","bobby@hotmail.com","abc123","user");
INSERT INTO `useraccounts`(`userID`, `username`, `email`, `pwd`, `acctType`) VALUES (3,"brenda","brenda@yahoo.com","abc123","user");
INSERT INTO `useraccounts`(`userID`, `username`, `email`, `pwd`, `acctType`) VALUES (4,"sandy","sandy@earthlink.com","abc123","user");
INSERT INTO `useraccounts`(`userID`, `username`, `email`, `pwd`, `acctType`) VALUES (5,"mitch","mitch@nc.rr.com","abc123","user");
INSERT INTO `useraccounts`(`userID`, `username`, `email`, `pwd`, `acctType`) VALUES (6,"mike","mike@flamincajun.com","abc123","truck");
INSERT INTO `useraccounts`(`userID`, `username`, `email`, `pwd`, `acctType`) VALUES (7,"polly","polly@thetacotruck.com","abc123","truck");
INSERT INTO `useraccounts`(`userID`, `username`, `email`, `pwd`, `acctType`) VALUES (8,"peter","peter@tasteofthesouth.com","abc123","truck");

INSERT INTO `trucks`(`truckID`, `truckName`, `userID`, `cuisine`, `hours`, `pictureURL`, `truckURL`, `servesBreakfast`, `servesLunch`, `servesDinner`, `lastUserLat`, `lastUserLong`, `lastTruckLat`, `lastTruckLong`) VALUES (1,"Flamin' Cajun",6,"Cajun","M-F 11-7","http://www.flamincajun.com/pics/truck.jpg","http://www.flamincajun.com",0,1,1,70.32,33.2,70.32,33.2);
INSERT INTO `trucks`(`truckID`, `truckName`, `userID`, `cuisine`, `hours`, `pictureURL`, `truckURL`, `servesBreakfast`, `servesLunch`, `servesDinner`, `lastUserLat`, `lastUserLong`, `lastTruckLat`, `lastTruckLong`) VALUES (2,"The Taco Truck",6,"Tex-Mex","Su-Sa 10-3","http://www.thetacotruck.com/pics/truck.jpg","http://www.thetacotruck.com",0,1,0,75.59,31.45,70.32,33.2);
INSERT INTO `trucks`(`truckID`, `truckName`, `userID`, `cuisine`, `hours`, `pictureURL`, `truckURL`, `servesBreakfast`, `servesLunch`, `servesDinner`, `lastUserLat`, `lastUserLong`, `lastTruckLat`, `lastTruckLong`) VALUES (3,"Taste of the South",6,"Southern Food","M-F 7-9","http://www.tasteofthesouth.com/pics/truck.jpg","http://www.tasteofthesouth.com",1,1,1,70.8,33.4,70.32,33.2);

INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (1,1,1,4,"Good food");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (2,1,3,2,"Undercooked, so bad!");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (3,2,1,1,"Too spicy!");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (4,2,3,5,"Good food for the soul");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (5,3,2,3,"Average stuff");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (6,3,3,3,"Pricey, but not terrible.");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (7,4,1,5,"HOLY CRAP IT'S SO GOOD!");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (8,4,2,5,"TACO TUESDAY IS A THING!");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (9,5,2, null,"Hmmm...");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (10,5,3,1,"");
INSERT INTO `comments`(`commentID`, `userID`, `truckID`, `rating`, `cmnt`) VALUES (11,6,3,1,"Southern Food is lame!");

INSERT INTO `favorites`(`favoriteID`, `userID`, `truckID`) VALUES (1,1,1);
INSERT INTO `favorites`(`favoriteID`, `userID`, `truckID`) VALUES (2,2,3);
INSERT INTO `favorites`(`favoriteID`, `userID`, `truckID`) VALUES (3,4,1);
INSERT INTO `favorites`(`favoriteID`, `userID`, `truckID`) VALUES (4,4,2);

INSERT INTO `reports`(`reportID`, `userID`, `pageReported`, `cmnt`) VALUES (1,4,"Taste of the South reviews","mike is saying southern food sucks! Ban him pls!")
