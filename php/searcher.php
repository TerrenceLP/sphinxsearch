<?php
  require_once('sphinxapi.php');

/* Start the SphinxClient class. */
  $cl = new SphinxClient();
  $cl->SetServer( "127.0.0.1", 9312 );
  $cl->SetMatchMode( SPH_MATCH_ANY  );
  $cl->SetLimits( 0, 1000 );
  // search form field
  $field1 = htmlspecialchars($_POST['searchinput']);

  /* The Query method will search the search term against the selected index. */
 // $result = $cl->Query("$field1", "test1stemmed");
  $result = $cl->Query("$field1", "test1");

  if ( $result === false ) {
      echo "Query failed: " . $cl->GetLastError() . ".\n";
  }
  else {
      if ( $cl->GetLastWarning() ) {
          echo "WARNING: " . $cl->GetLastWarning() . "";
      }

      if ( !empty($result["matches"]) ) {
      	$found = "";
          foreach ( $result["matches"] as $doc => $docinfo ) {
                $found .= "$doc,";
          }

	/* Here, we are using a MySQL IN clause to pull the from the DB for display. */
	$db = new PDO('mysql:host=127.0.0.1;dbname=employees;charset=utf8', 'yourdb', 'yourpwxxxx');
	$statement = $db->prepare('SELECT e.emp_no, e.first_name, e.last_name
  FROM employees.employees AS e
	WHERE e.emp_no IN (' . rtrim($found, ",") . ') GROUP BY e.emp_no');
	$statement->execute();
	$row = $statement->fetchALL(PDO::FETCH_ASSOC); // Use fetchAll() if you want all results, or just iterate over the statement
  $ncount = 1; // numbering for display
  echo '<div class="row"><h3>Total: ' . count($row) . ' </h3></div>';
echo '<pre>';
print_r($found);
echo '</pre>';
  $view_results = '<div class="row row-eq-height">';

		foreach ($row as $key => $rvalue) {

      for($i=0;$i<12;$i++)
      {
      // Start the math here
      if ( ($i % 3) == 0 ) {
      $view_results .= "<div class='col-md-4'>$ncount. $rvalue[emp_no]</div>";
      $view_results .= "<div class='col-md-4'>$rvalue[first_name]</div>";
      $view_results .= "<div class='col-md-4'>$rvalue[last_name]</div>";
      $ncount++;
    } else {
     // I'm closing and opening a row
        $view_results .=  '</div>';
        $view_results .= '<div class="row row-eq-height">';
    }
  }
  }
}
	echo $view_results;
}
?>
