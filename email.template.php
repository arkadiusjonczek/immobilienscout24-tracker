<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Immobilienscout24 Overview</title>
		<style type="text/css">
			body {
				font-family: verdana, arial, helvetica, sans-serif;
				font-size: 12pt;
			}
		</style>
	</head>
	<body>
		<?php foreach ($data['entries'] as $entry): ?>
			<div style="margin: 20px 0;">
				<span id="expose-id"><?php echo $entry->getId(); ?></span><br />
				<img src="<?php echo $entry->getPictureUrl(); ?>" /><br />
				<span id="title"><a href="<?php echo $entry->getUrl(); ?>"><?php echo $entry->getTitle(); ?></a></span><br />
				<span id="subtitle"><?php echo $entry->getSubtitle(); ?></span><br />
				<span id="details"><?php echo $entry->getPrice(); ?>, <?php echo $entry->getArea(); ?>, <?php echo $entry->getRooms(); ?> Zimmer</span>
			</div>
		<?php endforeach; ?>
	</body>
</html>
