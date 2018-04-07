<?php
/* used to load pages using cURL */
function loadPage($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

/* load page, decode it and create a variable to store all powers */
$page   = loadPage('https://xatproject.com/fairtrade/api.php?action=powers');
$json   = json_decode($page, true);
$powers = [];

/* get information of each power category */
foreach ($json['powers'] as $i => $p)
{
	if ($p['is_ep']) { $powers['everypower'][] = $p; }
	if ($p['is_epic']) { $powers['epic'][] = $p; }
	if ($p['is_allp']) { $powers['allpowers'][] = $p;	}
	if ($p['is_group']) { $powers['group'][] = $p; }
	if ($p['limited'] == 1) { $powers['limited'][] = $p; }
	if ($p['limited'] != 1) { $powers['unlimited'][] = $p; }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Fairtrade</title>
	<style>
		table { border-collapse: collapse; width: 100%; }
		th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
		tr:hover {background-color:#f5f5f5;}
	</style>
</head>
<body>

<div align="center"> <h2>Total prices</h2> </div>
<table>
  <tr>
    <th>Type</th>
    <th>Xats</th>
    <th>Days</th>
    <th>Powers</th>
  </tr>
  <?php
  /* list total prices xats, days and amount of powers */
  foreach ($powers as $t => $v):
  ?>
  <tr>
    <td><?php echo ucfirst($t); ?></td>
    <td><?php echo array_sum(array_column($v, 'min_xats')) . '-' . array_sum(array_column($v, 'max_xats')); ?></td>
    <td><?php echo array_sum(array_column($v, 'min_xats')) . '-' . array_sum(array_column($v, 'max_xats')); ?></td>
    <td><?php echo count($v); ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<div align="center"> <h2>Power list</h2> </div>
<table>
	<tr>
		<th>Name</th>
		<th>Title</th>
		<th>Store</th>
		<th>Xats</th>
		<th>Days</th>
		<th>Limited</th>
		<th>Unlimited</th>
		<th>Game</th>
		<th>Group</th>
		<th>Hug</th>
		<th>Epic</th>
		<th>Allpowers</th>
	</tr>
	<?php
	/* list all powers prices and info */
	foreach ($powers['everypower'] as $i => $p):
	?>
	<tr>
		<td><?php echo ucfirst($p['name']); ?></td>
		<td><?php echo $p['title']; ?></td>
		<td><?php echo $p['store']; ?></td>
		<td><?php echo $p['min_xats'] . '-' . $p['max_xats']; ?></td>
		<td><?php echo $p['min_days'] . '-' . $p['max_days']; ?></td>
		<td><?php echo $p['limited'] == 1 ? 'Yes' : 'No'; ?></td>
		<td><?php echo $p['limited'] == 1 ? 'No' : 'Yes'; ?></td>
		<td><?php echo $p['is_game'] == 1 ? 'Yes' : 'No'; ?></td>
		<td><?php echo $p['is_group'] == 1 ? 'Yes' : 'No'; ?></td>
		<td><?php echo $p['is_hug'] == 1 ? 'Yes' : 'No'; ?></td>
		<td><?php echo $p['is_epic'] == 1 ? 'Yes' : 'No'; ?></td>
		<td><?php echo $p['is_allp'] == 1 ? 'Yes' : 'No'; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
</body>
</html>
