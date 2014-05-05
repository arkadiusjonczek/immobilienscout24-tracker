<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Immobilienscout24 Overview</title>
		<style type="text/css">
			body {
				font-family: verdana, arial, helvetica, sans-serif;
				font-size: 12pt;
			}
		</style>
	</head>
	<body>
		<?php foreach ($param['entries'] as $entry): ?>
			<div style="margin: 20px 0;">
				<span id="expose-id"><?php echo $entry['id']; ?></span><br />
				<img src="<?php echo $entry['picture_url']; ?>" /><br />
				<span id="title"><a href="<?php echo $entry['url']; ?>"><?php echo $entry['title']; ?></a></span><br />
				<span id="subtitle"><?php echo $entry['subtitle']; ?></span><br />
				<span id="details"><?php echo $entry['price']; ?>, <?php echo $entry['area']; ?>, <?php echo $entry['rooms']; ?> Zimmer</span>
			</div>
		<?php endforeach; ?>
	</body>
</html>
