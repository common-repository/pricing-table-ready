<div class="mainOpinonsBup">
	<table>
    <tr>
    	<td width="120">Full backup</td>
        <td><?php echo htmlBup::checkbox('opt_values[full]', array('attrs'=>'class="bupCheckbox"', 'value' => 1, 'checked' => frameBup::_()->getModule('options')->get('full') ? 'checked' : '' )); ?></td>
    </tr>
    <tr>
    	<td>Database backup</td>
        <td><?php echo htmlBup::checkbox('opt_values[database]', array('attrs'=>'class="bupCheckbox"', 'value' => 1, 'checked' => frameBup::_()->getModule('options')->get('database') ? 'checked' : '')); ?></td>
    </tr>
    <tr>
    	<td>Plugins backup</td>
        <td><?php echo htmlBup::checkbox('opt_values[plugins]', array('attrs'=>'class="bupCheckbox"', 'value' => 1, 'checked' => frameBup::_()->getModule('options')->get('plugins') ? 'checked' : '')); ?></td>
    </tr>
    <tr>
    	<td>Themes backup</td>
        <td><?php echo htmlBup::checkbox('opt_values[themes]', array('attrs'=>'class="bupCheckbox"', 'value' => 1, 'checked' => frameBup::_()->getModule('options')->get('themes') ? 'checked' : '')); ?></td>
    </tr>
    <tr>
    	<td>Uploads backup</td>
        <td><?php echo htmlBup::checkbox('opt_values[uploads]', array('attrs'=>'class="bupCheckbox"', 'value' => 1, 'checked' => frameBup::_()->getModule('options')->get('uploads') ? 'checked' : '')); ?></td>
    </tr>
    <tr>
    	<td>Any other directories found inside wp-content</td>
        <td><?php echo htmlBup::checkbox('opt_values[any_directories]', array('attrs'=>'class="bupCheckbox"', 'value' => 1, 'checked' => frameBup::_()->getModule('options')->get('any_directories') ? 'checked' : '')); ?></td>
    </tr>
	</table>
    
    <div class="excludeOpt">
    <?php 
		echo langBup::_('Exclude these:'); 
		echo htmlBup::text( 'opt_values[exclude]', array('attrs'=>'class="excludeInput" title="If entering multiple files/directories, then separate them with commas."', 'value' => frameBup::_()->getModule('options')->get('exclude')) ); 
	?>
    </div>
    
</div>
