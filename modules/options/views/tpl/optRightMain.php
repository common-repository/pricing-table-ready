<?php //print_r($this->multiVar);  ?>
<div class="options-right">

    	<div class="misc-pub-section">
        	<div align="center">
            	<!--<a href="#TB_inline?height=600&width=640&inlineId=prt-templates-list" class="thickbox">
                	<div id="templates-list-icon" class="templates-list-icon">Choose Table Template</div>
                </a>-->
                <div id="prtTemplates-list-icon" class="prtTemplates-list-icon"><?php echo __('Choose Table Template', 'prtTD'); ?></div>
            </div>
        </div>
        
        <div id="prt-templates-list" style="display:none">
        	<div align="center" class="prtPopupTemplate">
            	<div class="prtPopupTemplateWrap">
            		<?php echo $this->popupTemplate; ?>
                    <div class="cls"></div>
                </div>
            </div>
		</div>
        
        <?php //print_r($this->multiVar); ?>
        <div class="misc-pub-section">
        	<strong><?php echo __('Width table:', 'prtTD'); ?></strong>
            	<input type="text" id="prtWidthTable" name="prtWidthTable" size="4" value="<?php echo $this->multiVar['prtWidthTable']; ?>"> px
        </div>
        <div class="misc-pub-section">
        	<strong><?php echo __('Columns Number:', 'prtTD'); ?></strong>
            	<input type="text" placeholder="" id="prtColumnsCount" name="prtColumnsCount" size="2" value="<?php echo $this->multiVar['prtColumnsCount']; ?>"> 
            <!--<strong title="Columns width">Width:</strong><input type="text" id="prtColumnsWidth" name="prtColumnsWidth" size="4" value="<?php echo $this->multiVar['prtColumnsWidth']; ?>">-->
        </div>
        
        <div class="misc-pub-section">
        	<strong><?php echo __('Rows Number:', 'prtTD'); ?></strong>
            	<input type="text" placeholder="" id="prtRowCount" name="prtRowCount" size="2" value="<?php echo $this->multiVar['prtRowCount']; ?>"> &nbsp;&nbsp;&nbsp;&nbsp;
               <!-- <strong title="Row height">Height:</strong><input type="text" id="prtRowHeight" name="prtRowHeight" size="4" value="<?php echo $this->multiVar['prtRowHeight']; ?>">-->
        </div>
        
        <div class="misc-pub-section">
        	<strong><?php echo __('Description Table:', 'prtTD'); ?></strong>
            	<select id="prtDescColunm" name="prtDescColunm">
		        	<option value="enable" 
			        <?php
			        selected($this->multiVar['prtDescColunm'], 'enable'); 
			        ?> >Enable</option>
			        <option value="disable" 
			        <?php
			        selected($this->multiVar['prtDescColunm'], 'disable'); 
			        ?> >Disable</option>
			    </select>
        </div>
        
        <div class="misc-pub-section">
        	<strong><?php echo __('Table Template:', 'prtTD'); ?></strong>
            <select id="prtTemplateSelect" name="prtTemplateSelect">
            	<?php echo $this->multiVar['template_opt']; ?>
            </select>
            <div id="forStyle">
            <?php if (!empty($this->multiVar['prtStyleSelect'])) : ?>
           	<strong><?php echo __('Color style:', 'prtTD'); ?></strong>
            <select id="prtStyleSelect" name="prtStyleSelect">
            	<?php echo $this->multiVar['prtStyleSelect']; ?>
            </select>
            <?php endif; ?>
            </div>
        </div>
        
        <div class="misc-pub-section">
        <strong><?php echo __('Float Table:', 'prtTD'); ?></strong>
        <select id="prtFloat" name="prtFloat">
        <option value="left" 
        <?php 
        selected($this->multiVar['prtFloat'], 'left');
        ?> >Left</option>
        <option value="center" 
        <?php
        selected($this->multiVar['prtFloat'], 'center');
        ?> >Center</option>
        <option value="right" 
        <?php
        selected($this->multiVar['floatTable'], 'right');
        ?> >Right</option>
        </select>
        </div>
        
        <div class="misc-pub-section">
        <strong><?php echo __('Float Text in Table:', 'prtTD'); ?></strong>
        <select id="prtFloatText" name="prtFloatText">
        <option value="left" 
        <?php
        selected($this->multiVar['prtFloatText'], 'left');
        ?> >Left</option>
        <option value="center" 
        <?php
        selected($this->multiVar['prtFloatText'], 'center');
        ?> >Center</option>
        <option value="right" 
        <?php
        selected($this->multiVar['prtFloatText'], 'right');
        ?> >Right</option>
        </select>
        </div>
        
        <div class="misc-pub-section">
        	<strong><?php echo __('Preview enable:', 'prtTD'); ?></strong> <input type="checkbox" <?php echo $this->multiVar['prtPrwEnable'] ? 'checked="checked"' : ''; ?> id="prtPrwEnable" name="prtPrwEnable" style="margin:0px 0px 4px 4px;" />
        </div>
 		
        <div id="ptrInfoPanel">
			<div id="PRT_OPTRIGHT_MSG"></div>
        </div>
       <!-- <input id="prtPost_id" type="hidden" value="<?php echo $_GET['post']; ?>">-->
       
</div>