<?php

include "base.php";

$incompleted = $_POST['incompletedVals'];

$updateIncompletedQuery = "update TODOITEMS set completed = 0 where ToDoItemID in (" . $incompleted . ")";

//echo "QUERY: " . $updateIncompletedQuery; 

$updateIncompletedResult = mysqli_query($dbc, $updateIncompletedQuery) or die("bad query".mysqli_error($dbc));

?>