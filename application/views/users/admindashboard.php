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

<h2>Past Reservations</h2>
<table>
<?php

foreach ($reservations as $reservation):
    
   
endforeach;

?>
</table>

<h2>Inventory</h2>
<a href="/inventory/add">Add item</a>
<table>
<?php
foreach ($items as $item):
    echo "<tr><td>{$item->serial}</td>";
    echo "<td>{$item->description}</td>";
    echo "<td>{$item->accessories}</td>";
    echo "<td><a href=\"/inventory/qrcode/{$item->id}\">print qrcode</a></td>";
    echo "<td><img src=\"/inventory/qrcode/{$item->id}\" /></td>";
    echo "</tr>";
   
endforeach;
?>
</table>

<h2>Users</h2>
<a href="/users/adminadd">Add user</a>
<table>
<?php
foreach ($users as $user):
    echo "<tr><td>{$user->email}</td><td>{$user->role}</td><td>{$user->created}</td></tr>";
endforeach;
?>
</table>
<br /><br /><br />