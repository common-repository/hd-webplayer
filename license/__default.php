<?php

global $wpdb;
$table_name = $wpdb->prefix . "webplayer_license";
$data       = array();
	
/******************************************************************
/* Updating the DB Table when edited
******************************************************************/
if($_POST['edited'] == 'true') {
	unset($_POST['edited'], $_POST['save']);
	$wpdb->update($table_name, $_POST, array( id => 1));
} 
	
/******************************************************************
/* Getting Input from the DB Table
******************************************************************/
$results = $wpdb->get_results("SELECT * FROM $table_name WHERE id=1");
$data = $results[0];
?>
<div class="wrap">
  <br />
  <?php _e( "By default, this plugin uses the latest non-commercial version of the HD Webplayer. Use of the player is free for non-commercial use. If you operate a commercial site (i.e., sells products, runs ads, or is owned by a company), you are required to purchase a license for the products you use.<br /><br />Purchasing a license will remove the HD Webplayer watermark and allow you to set your own watermark if desired." ); ?>
  <br />
  <br />
  <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return webplayer_validate();">
    <?php  echo "<h3>" . __( 'License Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10" >
      <tr>
        <td><?php _e("License Key" ); ?></td>
        <td><input type="text" id="licensekey" name="licensekey" value="<?php echo $data->licensekey; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Logo " ); ?></td>
        <td><input type="text" id="logo" name="logo" value="<?php echo $data->logo; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Logo Position" ); ?></td>
        <td><select id="logoposition" name="logoposition">
            <option value="topright" id="topright" >Top Right</option>
            <option value="topleft" id="topleft" >Top Left</option>
            <option value="bottomleft" id="bottomleft" >Bottom Left</option>
            <option value="bottomright" id="bottomright" >Bottom Right</option>
            <option value="center" id="center" >Center</option>
          </select>
          <?php echo '<script>document.getElementById("'.$data->logoposition.'").selected="selected"</script>'; ?> </td>
        </td>
      </tr>
      <tr>
        <td><?php _e("Logo Alpha" ); ?></td>
        <td><input type="text" id="logoalpha" name="logoalpha" value="<?php echo $data->logoalpha; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Logo Target" ); ?></td>
        <td><input type="text" id="logotarget" name="logotarget" value="<?php echo $data->logotarget; ?>" size="50"></td>
      </tr>
    </table>
    <input type="hidden" name="edited" value="true" />
    <input type="submit" class="button-primary" name="save" value="<?php _e("Save Options" ); ?>" />
  </form>
</div>
<script type="text/javascript">

 changeType(<?php echo "'".$data->type."'"; ?>);

 function changeType(typ) {

	document.getElementById('_hdvideo').style.display="none";
	document.getElementById('_streamer').style.display="none";
	document.getElementById('_dvr').style.display="none";
	document.getElementById('_token').style.display="none";

    switch(typ) {
		case 'rtmp' :
			document.getElementById('_streamer').style.display="";
			document.getElementById('_token').style.display="";
			break;
		case 'highwinds' :
			document.getElementById('_dvr').style.display="";
			break;
		default :
			document.getElementById('_hdvideo').style.display="";
			break;
		}
 }

function webplayer_validate() {
	var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
	var isAllowed       = true;
	
	if(document.getElementById('logo').value) {
		isAllowed = checkExtension('IMAGE', document.getElementById('logo').value, imageExtensions);
		if(isAllowed == false) 	return false;
	}
	
	return true;	
}

function checkExtension(type, filePath, validExtensions) {
    var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();

    for(var i = 0; i < validExtensions.length; i++) {
        if(ext == validExtensions[i]) return true;
    }

    alert(type + ' :   The file extension ' + ext.toUpperCase() + ' is not allowed!');
    return false;	
 }
</script>