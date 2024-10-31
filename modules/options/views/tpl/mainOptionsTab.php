<form class="cspNiceStyle" id="prtAdminMainForm">
<div class="main-progress-bar" style="display:none;">
	<div class="progress-bar devblue shine"> <!-- -->
    	<span style="width: 0%"></span>
	</div>
</div>
	<div id="BUP_MESS_MAIN"></div>
    <?php
		$wpcontent = ABSPATH.'wp-content';
		$wh = framePrt::_()->getModule('options')->get('warehouse');
		$warehouse = substr(ABSPATH, 0, strlen(ABSPATH)-1).substr($wh, 0, strlen($wh)-1);
		
		//$access_wp_content = (is_writable($wpcontent) && is_readable($wpcontent)) ? true : false;
		$access_wp_content = is_writable($wpcontent) ? true : false;
		//echo $access_wp_content ? 'access_wp_content = true<br />' : 'access_wp_content = false<br />';
		$access_warehouse = (is_writable($warehouse) && is_readable($warehouse)) ? true : false;
		//echo $access_warehouse ? 'access_warehouse = true<br />' : 'access_warehouse = false<br />';

		
		if (!$access_wp_content && !$access_warehouse) {
			echo '<div id="checkWritable" style="color:#C00;"><strong>Warning:</strong> Please change FTP access to 755 or 777<br />Folder or create it manually - "'.ABSPATH.'wp-content"</div>';
		} elseif (!$access_warehouse) {
			echo '<div id="checkWritable" style="color:#C00;"><strong>Warning:</strong> Please change FTP access to 755<br />Folder or create it manually - "'.substr(ABSPATH, 0, strlen(ABSPATH)-1).framePrt::_()->getModule('options')->get('warehouse').'"</div>';
		}
		
		
	?>

	<table width="100%">
    	<tr class="cspAdminOptionRow cspTblRow">
        	<td width="100">Backup site</td>
            <td>
                <?php echo htmlPrt::hidden('reqType', array('value' => 'ajax'))?>
                <?php echo htmlPrt::hidden('page', array('value' => 'backup'))?>
				<?php echo htmlPrt::hidden('action', array('value' => 'backUpNow'))?>
                <?php echo htmlPrt::hidden('start', array('value' => '1'))?>
				<?php echo htmlPrt::submit('backupnow', array('value' => langPrt::_('Backup Now'), 'attrs' => 'class="button button-primary button-large"'))?>
            </td>
        </tr>
    </table>
</form>
<form class="cspNiceStyle" > <!--id="prtAdminMainForm"-->
    <table width="100%">
    	<tr class="cspAdminOptionRow cspTblRow">
        	<td width="100">Restore site</td>
            <td>
            	<?php echo htmlPrt::button(array('attrs' => 'class="button button-primary button-large" id="redirStorage"', 'value' => langPrt::_('Restore'))); ?>
            </td>
        </tr>
        <tr class="cspAdminOptionRow cspTblRow">
        	<td></td>
            <td></td>
        </tr>
    </table>
</form>    
    <div id="resBox"></div>
    
    <div align="left">
    	<a id="prt_a_maininfo" href="javascript: void (0)">Options info</a> &darr;
        <div id="BUP_MESS_INFO"></div>
        <div id="prtInfoBlock"></div>
    </div>
    
    <!--<div align="left">
        <a id="prt_a_loginfo" href="javascript: void (0)">Log current backup</a> &darr;
        <div id="BUP_MESS_LOG"></div>
        <div id="prtLogBlock">empty</div>
    </div>-->	



