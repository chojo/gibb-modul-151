<ul class="alert alert-danger">
	<?php
	if (isset ( $errors ))
		
		echo $errors;
	
	?>
</ul>
<form action="/gaestebuch/bearbeiten" method="post">
	<textarea type="text" name="inhalt"
		value="<?php if(isset($guestbookentry)) echo $guestbookentry->Text; ?> "></textarea>
	<input type="hidden" name="guestbookId"
		value="<?php if(isset($guestbookentry)) echo $guestbookentry->Id; ?> ">
	<div class="inline-list">
		<input class="btn btn-success" type="submit" value="submit"> <a
			class="btn btn-warning"
			href="<?php if(isset($backurl)) echo $backurl;?>">Cancel</a>
	</div>
<?php
if (isset ( $backurl )) {
	echo "<input type='hidden' name='backurl' value='$backurl'>";
}
?>
</form>
<form action="/gaestebuch/loeschen" method="post">
	<input type="hidden" name="guestbookId"
		value="<?php if(isset($guestbookentry)) echo $guestbookentry->Id; ?> ">
<?php
if (isset ( $backurl )) {
	echo "<input type='hidden' name='backurl' value='$backurl'>";
}
?>
<div><input class="btn btn-danger" type="submit" value="Delete"></div>



</form>
