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
<?php echo anchor("inventory/add", "Add item"); ?> |
<?php echo anchor("inventory/import", "Import"); ?>
<table>
<?php
foreach ($items as $item):
    echo "<tr><td>".anchor("inventory/edit/{$item->id}", $item->serial)."</td>";
    echo "<td>{$item->description}</td>";
    echo "<td>{$item->accessories}</td>";
    echo "<td style='text-align:center'>".anchor("inventory/qrcode/{$item->id}/1", img("inventory/qrcode/{$item->id}/1")."<br />print qrcode", ['title'=>"print qrcode"])."</td>";
    echo "<td>".anchor("inventory/delete/{$item->id}", img("assets/img/redx.gif"), ['title'=>'delete','onclick'=>"return confirm('Are you sure you want to delete this item?');"])."</td>";
    echo "</tr>";

endforeach;
?>
</table>

<h2>Users</h2>
<a href="users/adminadd">Add user</a>
<table>
<?php
foreach ($users as $user):
    echo "<tr><td>{$user->email}</td><td>{$user->role}</td><td>{$user->created}</td></tr>";
endforeach;
?>
</table>
<br /><br /><br />
