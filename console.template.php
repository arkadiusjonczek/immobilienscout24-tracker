<?php foreach ($param['entries'] as $entry): ?>

---
<?php echo $entry['id'] . "\r\n"; ?>
<?php echo $entry['title'] . "\r\n"; ?>
<?php echo $entry['subtitle'] . "\r\n"; ?>
<?php echo $entry['price']; ?>, <?php echo $entry['area']; ?>, <?php echo $entry['rooms']; ?> Zimmer <?php echo "\r\n"; ?>
<?php echo $entry['url'] . "\r\n"; ?>

<?php endforeach; ?>