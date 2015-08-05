<form action="vitamins-mailchimp-slave.php" method="post">
	<select name="action">
		<option value="subscribe">subscribe</option>
		<option value="addinterest">addinterest</option>
		<option value="reminterest">reminterest</option>
		<option value="changename">changename</option>
		<option value="checklist">checklist</option>
	</select>
	<input type="text" name="email" placeholder="email" />
	<input type="text" name="fname" placeholder="fname" />
	<input type="text" name="interest" placeholder="interest" />
	<input type="text" name="listid" placeholder="list ID" />
	<select name="debug">
		<option value="0">false</option>
		<option value="1">true</option>
	</select>
	<input type="submit" value="Execute query" />
</form>