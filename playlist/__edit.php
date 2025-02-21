<?php

/******************************************************************
/* Inserting (or) Updating the DB Table when edited
******************************************************************/
if($_POST['edited'] == 'true') {
	unset($_POST['edited'], $_POST['save']);
	$wpdb->update($table_name, $_POST, array('id' => $_GET['id']));
	echo '<script>window.location="?page=playlist";</script>';
}

/******************************************************************
/* Getting Input from the DB Table
******************************************************************/
$data = $wpdb->get_row("SELECT * FROM $table_name WHERE id=".$_GET['id']);
	
?>
<div class="wrap">
  <br />
  <?php _e( "HD Webplayer is the Fastest Growing Online Video Platform for your Websites. For More visit <a href='http://hdwebplayer.com'>HD Webplayer</a>." ); ?>
  <br />
  <br />
  <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return webplayer_validate();">
    <?php  echo "<h3>" . __( 'Playlist Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td name="30%"><?php _e("Name" ); ?></td>
        <td><input type="text" id="name" name="name" value="<?php echo $data->name; ?>" size="50" /></td>
      </tr>
    </table>
    <br />
    <input type="hidden" name="edited" value="true" />
    <input type="submit" class="button-primary" name="save" value="<?php _e("Save Options" ); ?>" />
    &nbsp; <a href="?page=playlist" class="button-secondary" title="cancel">
    <?php _e("Cancel" ); ?>
    </a>
  </form>
</div>
<script type="text/javascript">
function webplayer_validate() {
	if(document.getElementById('name').value == '') {
		alert("Warning! You have not added any Name to the Playlist");
		return false;
	}
	
	return true;
}
</script>