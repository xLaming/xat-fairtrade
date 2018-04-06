<?php
function loadPage($url)
{
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

$page = loadPage('https://xatproject.com/fairtrade/api.php?action=powers');
$json = json_decode($page, true);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Fairtrade List</title>
	<style>
		table { border-collapse: collapse; width: 100%; }
		th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
		tr:hover {background-color:#f5f5f5;}
	</style>
</head>
<body>
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
	foreach ($json['powers'] as $i => $p):
	?>
	<tr>
		<th><?php echo ucfirst($p['name']); ?></th>
		<th><?php echo $p['title']; ?></th>
		<th><?php echo $p['store']; ?></th>
		<th><?php echo $p['min_xats'] . '-' . $p['max_xats']; ?></th>
		<th><?php echo $p['min_days'] . '-' . $p['max_days']; ?></th>
		<th><?php echo $p['limited'] == 1 ? 'Yes' : 'No'; ?></th>
		<th><?php echo $p['limited'] == 1 ? 'No' : 'Yes'; ?></th>
		<th><?php echo $p['is_game'] == 1 ? 'Yes' : 'No'; ?></th>
		<th><?php echo $p['is_group'] == 1 ? 'Yes' : 'No'; ?></th>
		<th><?php echo $p['is_hug'] == 1 ? 'Yes' : 'No'; ?></th>
		<th><?php echo $p['is_epic'] == 1 ? 'Yes' : 'No'; ?></th>
		<th><?php echo $p['is_allp'] == 1 ? 'Yes' : 'No'; ?></th>
	</tr>
	<?php endforeach; ?>
</table>
</body>
</html>
