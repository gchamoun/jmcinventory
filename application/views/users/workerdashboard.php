<h2>Welcome</h2>
<?php
        echo "Welcome back " . user('id');
        echo "<br />Your role is " . user('role_id');
?>

<h2>Current Reservations</h2>
<table>
<?php

foreach ($reservations as $reservation):
    
   
endforeach;

?>
</table>
<br /><br /><br />