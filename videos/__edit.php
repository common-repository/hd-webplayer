<?php

/******************************************************************
/* Inserting (or) Updating the DB Table when edited
******************************************************************/
if($_POST['edited'] == 'true') {
	unset($_POST['edited'], $_POST['save']);
	$wpdb->update($table_name, $_POST, array('id' => $_GET['id']));
	echo '<script>window.location="?page=videos";</script>';
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
    <?php  echo "<h3>" . __( 'Video Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td width="30%"><?php _e("Video Title " ); ?></td>
        <td><input type="text" id="title" name="title" value="<?php echo $data->title; ?>" size="50"></td>
      </tr>
      <tr>
        <td class="key">Video type</td>
        <td><select id="type" name="type" onchange="javascript:changeType(this.options[this.selectedIndex].id);">
            <option value="video" id="video" >Direct URL</option>
            <option value="youtube" id="youtube" >Youtube Videos</option>
            <option value="dailymotion" id="dailymotion" >Dailymotion Videos</option>
            <option value="rtmp" id="rtmp" >RTMP Streams</option>
            <option value="highwinds" id="highwinds" >SMIL</option>
            <option value="lighttpd" id="lighttpd" >Lighttpd Videos</option>
            <option value="bitgravity" id="bitgravity" >Bitgravity Videos</option>
          </select>
          <?php echo '<script>document.getElementById("'.$data->type.'").selected="selected"</script>'; ?> </td>
      </tr>
      <tr>
        <td width="30%"><?php _e("Video URL " ); ?></td>
        <td><input type="text" id="_video" name="video" value="<?php echo $data->video; ?>" size="50"></td>
      </tr>
      <tr id="_hdvideo">
        <td width="30%"><?php _e("HD Video URL" ); ?></td>
        <td><input type="text" id="hdvideo" name="hdvideo" value="<?php echo $data->hdvideo; ?>" size="50"></td>
      </tr>
      <tr id="_streamer">
        <td class="key"><?php _e("Streamer" ); ?></td>
        <td><input type="text" id="streamer" name="streamer" size="60" value="<?php echo $data->streamer; ?>" /></td>
      </tr>
      <tr id="_token">
        <td class="key"><?php _e("Security Token [Wowza]" ); ?></td>
        <td><input type="text" id="token" name="token" size="60" value="<?php echo $data->token; ?>"/></td>
      </tr>
      <tr>
        <td><?php _e("Preview Image" ); ?></td>
        <td><input type="text" id="preview" name="preview" value="<?php echo $data->preview; ?>" size="50"></td>
      </tr>
       <tr>
        <td><?php _e("Thumb Image" ); ?></td>
        <td><input type="text" id="thumb" name="thumb" value="<?php echo $data->thumb; ?>" size="50"></td>
      </tr>
      <tr id="_dvr">
        <td class="key"><?php _e("DVR" ); ?></td>
        <td><input type="hidden" name="dvr" value=""><input type="checkbox" id="dvr" name="dvr" value="1" <?php if($data->dvr==1){echo 'checked="checked" ';}?> /></td>
      </tr>
      <tr>
        <td class="key"><?php _e("Playlist ID" ); ?></td>
        <td><input type="text" id="playlistid" name="playlistid" value="<?php echo $data->playlistid; ?>" /></td>
      </tr>
    </table>
    <br />
    <input type="hidden" name="edited" value="true" />
    <input type="submit" class="button-primary" name="save" value="<?php _e("Save Options" ); ?>" />
    &nbsp; <a href="?page=videos" class="button-secondary" title="cancel">
    <?php _e("Cancel" ); ?>
    </a>
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
		case 'bitgravity' :
			document.getElementById('_dvr').style.display="";
			break;
		case 'video' :
			document.getElementById('_hdvideo').style.display="";
			break;
		}
 }

function webplayer_validate() {
	var type            = document.getElementById("type");
    var method          = type.options[type.selectedIndex].value;
	var videoExtensions = ['flv', 'mp4' , '3g2', '3gp', 'aac', 'f4b', 'f4p', 'f4v', 'm4a', 'm4v', 'mov', 'sdp', 'vp6', 'smil'];
	var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
	var isAllowed       = true;
	
	if(document.getElementById('title').value == '') {
		alert("Warning! You must Provide a Title for the Video.");
		return false;
	}
	
	if(document.getElementById('video').value == '') {
		alert("Warning! You have not added any Video to the Player.");
		return false;
	}
	
	if(method == 'video' || method == 'smil' || method == 'lighttpd') {
		isAllowed = checkExtension('VIDEO', document.getElementById('_video').value, videoExtensions);
		if(isAllowed == false) 	return false;
		
		if(document.getElementById('hdvideo').value) {
			isAllowed = checkExtension('VIDEO', document.getElementById('hdvideo').value, videoExtensions);
			if(isAllowed == false) 	return false;
		}
	}
	
	if(document.getElementById('preview').value) {
		isAllowed = checkExtension('IMAGE', document.getElementById('preview').value, imageExtensions);
		if(isAllowed == false) 	return false;
	}
	
	if(document.getElementById('thumb').value) {
		isAllowed = checkExtension('IMAGE', document.getElementById('thumb').value, imageExtensions);
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