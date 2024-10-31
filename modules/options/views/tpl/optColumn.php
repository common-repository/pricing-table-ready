<?php //print_r($this->columns); ?> 

  <?php for($i=2; $i < count($this->columns); $i++ ) : ?> 
  
    <li class="table-item menu-item-depth-0 menu-item-custom pending menu-item-edit-inactive prt-li-column" id="menu-item-<?php echo $i; ?>" style="position: relative; top: 0px; margin-top: 0px; ">
	    <dl class="menu-item-bar">
                <dt class="menu-item-handle" style="max-width: 240px; padding:10px 0px 10px 15px !important;">
                    <div class="prtHead1"><?php echo __('Column', 'prtTD'); ?> - <?php echo $i; ?></div>
                    <div class="prtHead2"><input type="text" size="13" value="<?php echo $this->columns[$i][0]; ?>" name="prtColumnName[]" id="prtColumnName" placeholder="Title"></div>
                    <div class="prtHead3"><div class="trash" id="<?php echo $i-1; ?>"></div></div>
                    <div class="cls"></div>
                </dt>
        </dl>

    	<div class="edit-fields ui-sortable">
        
	        <div style="display: block;" id="menu-item-settings-1" class="menu-item-settings">
            	<table>
                	<tr>
                    	<td width="80"><?php echo __('Button URL', 'prtTD'); ?> - </td>
                        <td><input type="text" size="18" value="<?php echo $this->columns[$i][1]; ?>" name="prtButtonUrl[]" id="prtButtonUrl" placeholder="<?php echo __('Input URL', 'prtTD'); ?>"></td>
                    </tr>
                    <tr>
                    	<td><?php echo __('Button text', 'prtTD'); ?> - </td>
                        <td><input type="text" size="18" value="<?php echo $this->columns[$i][2]; ?>" name="prtButtonText[]" id="prtButtonText" placeholder="Input text"></td>
                    </tr>
                </table>
            </div>
            
            <div style="display: block;" id="menu-item-settings-1" class="menu-item-settings correct1">
            	<table>
                	<tr>
                    	<td width="80">Price - </td>
                        <td><input type="text" size="18" value="<?php echo $this->columns[$i][3]; ?>" name="prtPrice[]" id="prtPrice" placeholder="10" /></td>
                    </tr>
                    <tr>
                    	<td>Currency - </td>
                        <td><input type="text" size="18" value="<?php echo $this->columns[$i][4]; ?>" name="prtCurrency[]" id="prtCurrency" placeholder="USD" /></td>
                    </tr>
                </table>
            </div>
            
            <?php for($ir=5; $ir < count($this->columns[$i]); $ir++ ) : ?> 
            <div style="display: block;" id="menu-item-settings-1" class="menu-item-settings">
            	<table>
                	<tr class="prt_tr_row">
                    	<td width="80"><?php echo __('Row', 'prtTD'); ?> - </td>
                        <td><input type="text" size="18" value="<?php echo $this->columns[$i][$ir]; ?>" name="prtRow[<?php echo $i; ?>][<?php echo $ir; ?>]" class="prtRow" placeholder="<?php echo __('text', 'prtTD'); ?>" /></td>
                    </tr>
                </table>
            </div>
 		   <?php endfor; ?>            
           
        </div>
        
	</li>
    
  <?php endfor; ?>
  
  <li id="add_column" class="add_column">
  	<div id="add_column_text" class="add_column_text"><?php echo __('Add Column', 'prtTD'); ?></div>
  </li>
