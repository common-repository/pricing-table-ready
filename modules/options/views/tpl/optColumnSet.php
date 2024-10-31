<li class="table-item menu-item-depth-0 menu-item-custom pending menu-item-edit-inactive prt-li-column" id="menu-item-<?php echo 1; ?>" style="position: relative; top: 0px; margin-top: 0px; ">
    
	    <dl class="menu-item-bar">
                <dt class="menu-item-handle" style="max-width: 225px;">
                    <div class="prtHead1"><?php echo __('Column', 'prtTD'); ?> - <?php echo 1; ?></div>
                    <div class="prtHead2"><input type="text" size="13" value="<?php echo isset($this->columns[1][0]) ? $this->columns[1][0] : ''; ?>" name="prtColumnName[]" id="prtColumnName" placeholder="Title"></div>
                    <div class="prtHead3"><!--<div class="trash"></div>--></div>
                    <div class="cls"></div>
                </dt>
        </dl>
        
    	<div class="edit-fields ui-sortable">
        
	        <div style="display: block;" id="menu-item-settings-1" class="menu-item-settings "><!--add-settings1-->
            	<table>
                	<tr>
                    	<td width="80"><?php echo __('Button URL', 'prtTD'); ?> - </td>
                        <td><input type="text" size="18" value="<?php echo isset($this->columns[1][1]) ? $this->columns[1][1] : ''; ?>" name="prtButtonUrl[]" id="prtButtonUrl" placeholder="<?php echo __('Input URL', 'prtTD'); ?>"></td>
                    </tr>
                    <tr>
                    	<td><?php echo __('Button text', 'prtTD'); ?> - </td>
                        <td><input type="text" size="18" value="<?php echo isset($this->columns[1][2]) ? $this->columns[1][2] : ''; ?>" name="prtButtonText[]" id="prtButtonText" placeholder="<?php echo __('Input text', 'prtTD'); ?>"></td>
                    </tr>
                </table>
                    <!--<div class="prtSetClickSlide">settings &#9660;</div>
                	<div class="prtHeadSetSlide">
                    <table>
                        <tr>
                            <td width="80">Width: </td>
                            <td><input type="text" size="6" value="" name="prtButtonWidth" id="prtButtonWidth" /></td>
                        </tr>
                        <tr>
                            <td>Height: </td>
                            <td><input type="text" size="6" value="" name="prtButtonHeight" id="prtButtonHeight" /></td>
                        </tr>
                        <tr>
                            <td>Color: </td>
                            <td><input type="text" size="6" value="" name="prtButtonColor" id="prtButtonColor" /></td>
                        </tr>
                         <tr>
                            <td>Border-radius: </td>
                            <td><input type="text" size="6" value="" name="prtButtonBR" id="prtButtonBR" /></td>
                        </tr>
                    </table>
                    </div>-->
                    
               </div>
            
            <div style="display: block;" id="menu-item-settings-1" class="menu-item-settings correct1"> <!--add-settings2--> 
            	<table>
                	<tr>
                    	<td width="80">Price - </td>
                        <td><input type="text" size="18" value="<?php echo isset($this->columns[1][3]) ? $this->columns[1][3] : ''; ?>" name="prtPrice[]" id="prtPrice" placeholder="10" /></td>
                    </tr>
	            </table>
                
                <!--<div class="prtSetClickSlide">settings &#9660;</div>
                <div class="prtHeadSetSlide">
                    <table>
                        <tr>
                            <td>Height: </td>
                            <td><input type="text" size="6" value="" name="prtPriceHeight" id="prtPriceHeight" /></td>
                        </tr>
                        <tr>
                            <td>Color: </td>
                            <td><input type="text" size="6" value="" name="prtPriceColor" id="prtPriceColor" /></td>
                        </tr>
                         <tr>
                            <td>Background color: </td>
                            <td><input type="text" size="6" value="" name="prtPriceBG" id="prtPriceBG" /></td>
                        </tr>
                    </table>
                </div>-->
        
                <table>
                    <tr>
                    	<td width="80">Currency - </td>
                        <td><input type="text" size="18" value="<?php echo isset($this->columns[1][4]) ? $this->columns[1][4] : ''; ?>" name="prtCurrency[]" id="prtCurrency" placeholder="USD" /></td>
                    </tr>
                </table>
                
                <!--<div class="prtSetClickSlide">settings &#9660;</div>
                <div class="prtHeadSetSlide">
                    <table>
                        <tr>
                            <td>Height: </td>
                            <td><input type="text" size="6" value="" name="prtCurrencyHeight" id="prtCurrencyHeight" /></td>
                        </tr>
                        <tr>
                            <td>Color: </td>
                            <td><input type="text" size="6" value="" name="prtCurrencyColor" id="prtCurrencyColor" /></td>
                        </tr>
                         <tr>
                            <td>Background color: </td>
                            <td><input type="text" size="6" value="" name="prtCurrencyBG" id="prtCurrencyBG" /></td>
                        </tr>
                    </table>
                </div>-->
                
            </div>
            
            <?php for($ir=5; $ir < count($this->columns[1]); $ir++ ) : ?> 
            <div style="display: block;" id="menu-item-settings-1" class="menu-item-settings">
            	<table>
                	<tr class="prt_tr_row">
                    	<td width="80"><?php echo __('Row', 'prtTD'); ?> - </td>
                        <td><input type="text" size="18" value="<?php echo isset($this->columns[1][$ir]) ? $this->columns[1][$ir] : ''; ?>" name="prtRow[1][<?php echo $ir ?>]" class="prtRow" placeholder="<?php echo __('text', 'prtTD'); ?>" /></td>
                    </tr>
                </table>
            </div>
 		   <?php endfor; ?>            
           
        </div>
        
</li>