
<div class="prtTicketTmpSel">
    <!--<div class="prtTicketName">
        <?php echo $this->multiVar['name']; ?>
    </div>-->
    <div class="prtTicketImgBlock ptrTemplateSelect <?php echo $this->multiVar['paid'] ? 'prtPaidTemplate' : ''; ?>" id="<?php echo $this->multiVar['name']; ?>">
        <div class="prtTicketImg">
           <img src="<?php echo $this->multiVar['src']; ?>" /> 
        </div>
    </div>
    
    <input id="<?php echo $this->multiVar['name']; ?>" class="button button-primary button-large ptrTemplateSelect <?php echo $this->multiVar['paid'] ? 'prtPaidTemplate' : ''; ?>" type="button" value="<?php echo $this->multiVar['paid'] ? 'Available in PRO version' : 'Apply'; ?>">

</div>