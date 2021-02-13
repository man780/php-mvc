<p>Главная страница</p>

<?php foreach ($tasks as $val): ?>
	<h3><?php echo $val['fio']; ?></h3>
	<p><?php echo $val['email']; ?></p>
	<p><?php echo $val['text']; ?></p>
	<hr>
<?php endforeach; ?>