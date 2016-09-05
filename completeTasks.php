<?php

include "base.php";

$completed = $_POST['completedVals'];

$updateCompletedQuery = "update TODOITEMS set completed = 1 where ToDoItemID in (" . $completed . ")";

//echo "QUERY: " . $updateCompletedQuery; 

$updateCompletedResult = mysqli_query($dbc, $updateCompletedQuery) or die("bad query".mysqli_error($dbc));

?>