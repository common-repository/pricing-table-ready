	<li class="table-item menu-item-depth-0 menu-item-custom pending menu-item-edit-inactive prt-li-desc" id="menu-item-0" style="display:<?php echo ($this->optList['prtDescColunm'] == 'enable') ? 'block' : 'none' ?>">
    
	    <dl class="menu-item-bar">
            <dt class="menu-item-handle" style="max-width:170px;">
                <div class="prtHead1"></div>
                <div class="prtHead2"><input type="text" size="15" value="<?php echo $this->decsArr[0]; ?>" name="prtDescVal[]" id="prtDescVal" placeholder="Description"></div>
                <div class="prtHead3"><!--<div class="trash"></div>--></div>
                <div class="cls"></div>
            </dt>
        </dl>
        
    	<div class="edit-fields ui-sortable">
            <div style="display: block; max-width: 190px; height:83px;" id="menu-item-settings-0" class="menu-item-settings">
            	<!--<table>
	                <?php //for($i=1; $i<=2 ; $i++ ) : ?>
                	<tr>
                    	<td width="25"><?php //echo $i; ?> - </td>
                        <td><input type="text" size="16" value="<?php echo $this->decsArr[$i] ?>" name="prtDescVal" id="prtDescVal" placeholder=""></td>
                    </tr>
                    <?php //endfor; ?>
                </table>-->
            </div>
            
            <div style="display: block; max-width: 190px;" id="menu-item-settings-0" class="menu-item-settings correct1">
            	<table>
                 <?php //for($i=1; $i<=2; $i++ ) : ?>
                	<tr>
                    	<td width="25"><?php echo 1; ?> - </td>
                        <td><input type="text" size="16" value="<?php echo $this->decsArr[1] ?>" name="prtDescVal[]" id="prtDescVal" placeholder=""></td>
                    </tr>
                 <?php //endfor; ?>
                </table>
            </div>
           
            <?php for($i=2; $i < count($this->decsArr); $i++ ) : ?>
            <div style="display: block; max-width: 190px;" id="menu-item-settings-0" class="menu-item-settings">
            	<table>
                	<tr>
                    	<td width="25"><?php echo $i; ?> - </td>
                        <td><input type="text" size="16" value="<?php echo $this->decsArr[$i] ?>" name="prtDescVal[]" id="prtDescVal" placeholder=""></td>
                    </tr>
                </table>
            </div>
            <?php endfor; ?>
 
            
        </div>
        
	</li>