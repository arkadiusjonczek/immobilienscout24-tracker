<?php foreach ($data['entries'] as $entry): ?>

---
<?php echo $entry->getId() . "\r\n"; ?>
<?php echo $entry->getTitle() . "\r\n"; ?>
<?php echo $entry->getSubtitle() . "\r\n"; ?>
<?php echo $entry->getPrice(); ?>, <?php echo $entry->getArea(); ?>, <?php echo $entry->getRooms(); ?> Zimmer <?php echo "\r\n"; ?>
<?php echo $entry->getUrl() . "\r\n"; ?>

<?php endforeach; ?>