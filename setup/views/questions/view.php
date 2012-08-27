<h2><?php print $data['questions'][0]['text']; ?></h2>
<?php
for ($i = 0; $i < count($data['answers']); $i++):
	?>
	<strong><?php print 'Answer [' . ($i + 1) . ']:'; ?></strong><?php print ' "' . $data['answers'][$i]['text'] . '"'; ?><br />
	<?php
endfor;
?>
<?php
foreach (\PDO::getAvailableDrivers() as $pdo_driver):
	print "Your <strong>pdo_$pdo_driver</strong> driver is available and active.<br />";
endforeach;

if (\CRYPT_BLOWFISH === 1) {
	print '<strong>blowfish</strong> hash using <em>crypt()</em> of "jonathan": ' . crypt('jonathan', '$2a$24$ilovephpandyoudotooyup') . '<br />';
}
if (\CRYPT_MD5 === 1) {
	print '<strong>md5</strong> hash using <em>crypt()</em> of "jonathan": ' . crypt('jonathan', '$1$ilovephp5') . '<br />';
}
//if (\CRYPT_SHA256 === 1) {
//	print 'sha256 hash using <em>crypt()</em> of "jonathan": ' . crypt('jonathan', '$2a$24$ilovephpandyoudotooyup') . '<br />';
//}
//if (\CRYPT_SHA512 === 1) {
//	print 'sha512 hash using <em>crypt()</em> of "jonathan": ' . crypt('jonathan', '$2a$24$ilovephpandyoudotooyup') . '<br />';
//}
?>
<?php
$memcache = new Memcache();
$memcache->connect('localhost', 11211);

$sql_query = 'SELECT * FROM pages WHERE page_id = 1';

$memcache_key = md5('sql_query' . $sql_query);
$query_result = $memcache->get($memcache_key);
if ($query_result === NULL) {
	$mysql_query = mysql_query($sql_query);
	if (mysql_num_rows($mysql_query) > 0) {
		$query_result = mysql_fetch_object($mysql_query);

		$memcache->set($memcache_key, $mysql_result, 0, 3600);
	}
}

$content = $query_result->content;
?>