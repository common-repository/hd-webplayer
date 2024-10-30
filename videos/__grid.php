<?php $data = $wpdb->get_results("SELECT id,playlistid,video,type FROM $table_name"); ?>
<div class="wrap">
<br />
<?php _e( "HD Webplayer is the Fastest Growing Online Video Platform for your Websites. For More visit <a href='http://hdwebplayer.com'>HD Webplayer</a>." ); ?>
<br />
<br />
<div><a href="?page=videos&opt=add" class="button-primary" title="addnew"><?php _e("Add New Video" ); ?></a></div>
<br />
<table class="widefat">
  <thead>
    <tr>
      <th><input type="checkbox" disabled="disabled" /></th>
      <th><?php _e("Video ID" ); ?></th>
      <th><?php _e("Playlist ID" ); ?></th>
      <th><?php _e("Video URL" ); ?></th>
      <th><?php _e("Video Type" ); ?></th>
      <th><?php _e("Actions" ); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
	for ($i=0, $n=count($data); $i < $n; $i++) {
		$item = $data[$i];	
    	echo '<tr>';
		echo '<td style="padding-left:14px;"><input type="checkbox" disabled="disabled" /></td>';
       	echo '<td>'.$item->id.'</td>';
		echo '<td>'.$item->playlistid.'</td>';
		echo '<td>'.$item->video.'</td>';
		echo '<td>'.$item->type.'</td>';
		if($item->id == 1) {
			echo '<td style="padding:7px"><a class="button-secondary" href="?page=videos&opt=edit&id='.$item->id.'" title="Edit">Edit</a></td>';
		} else {
			echo '<td style="padding:7px"><a class="button-secondary" href="?page=videos&opt=edit&id='.$item->id.'" title="Edit">Edit</a>&nbsp;<a class="button-secondary" href="?page=videos&opt=delete&id='.$item->id.'" title="Delete">Delete</a></td>';
		}		
    	echo '<tr>';
	}
  ?>
  </tbody>
</table>