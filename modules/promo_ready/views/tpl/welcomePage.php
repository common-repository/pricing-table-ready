<style>
.spacer {width:100%; height:25px;}
	.container {
		position: relative;
		max-width: 1050px;
	}
	.container h1 {text-align:center; font-size: 30px; margin:10px 0; float: left;}
    .container h2 {font-size:24px; margin:10px 0;}
    .container h3 {font-size:20px; margin:10px 0;}
    .container p {line-height:20px; margin-bottom:10px;}
    .container ul {margin-bottom:10px; margin-left:20px;}
    .container ul li {list-style-type:disc;}
	
	.about-message {
		font-size: 21px;
		line-height: 30px;
		float: left;
	}
	
	.plug-icon-shell {
		position: absolute;
		right: 0;
		top: 0;
	}
	.plug-icon-shell a {
		font-size: 14px;
		color: grey;
		text-decoration: none;
	}
	
	.video-wrapper {
		margin:0 auto; 
		width:640px;
		float: left;
	}
    .clear {clear:both;}
    
    .col-3 {
		float:left; 
		padding-right: 20px;
		width:29%;
	}
	
	#prtWelcomePageFindUsForm label {
		line-height: 24px;
		margin-left: 20px;
		font-size: 14px;
		display: block;
	}
</style>
<div id="prt-first-start" style="display:none">
    <div class="container">
        <div id="prtWelcomePageFindUsForm">
            <h1>
                <?php langPrt::_e('Welcome to')?>
                <?php echo S_PRT_WP_PLUGIN_NAME?>
                <?php langPrt::_e('Version')?>
                <?php echo PRT_S_VERSION?>!
            </h1>
            <div class="clear"></div>
            <div class="about-message">
                This is first start up of the <?php echo S_PRT_WP_PLUGIN_NAME?> plugin.<br />
                If you are newbie - check all features on that page, if you are guru - please correct us.
            </div>
            <div class="plug-icon-shell">
                <a target="_blank" href="http://readyshoppingcart.com/"><img src="<?php echo $this->getModule()->getModPath(). 'img/plug-icon.png'?>" /></a><br />
                <a target="_blank" href="http://readyshoppingcart.com/"><?php echo S_PRT_WP_PLUGIN_NAME?></a><br />
                <a target="_blank" href="http://readyshoppingcart.com/"><?php echo PRT_S_VERSION?></a><br />
            </div>
            <div class="clear"></div>
            <div class="spacer"></div>
    
            <h2>Where did you find us?</h2>
            <?php foreach($this->askOptions as $askId => $askOpt) { ?>
                <label><?php echo htmlPrt::radiobutton('where_find_us', array('value' => $askId))?>&nbsp;<?php echo $askOpt['label']?></label>
                <?php if($askId == 4 /*Find on the web*/) { ?>
                    <label id="prtFindUsUrlShell" style="display: none;">Please, post url: <?php echo htmlPrt::text('find_on_web_url')?></label>
                <?php } elseif($askId == 5 /*Other way*/) { ?>
                    <label style="display: none;" id="prtOtherWayTextShell"><?php echo htmlPrt::textarea('other_way_desc')?></label>
                <?php }?>
            <?php }?>
    
            <div class="spacer"></div>
    
    		<a target="_blank" href="http://readyshoppingcart.com/product/pricing-table-ready-plugin-pro/">тут ссылка на плагин!!! (куда её?)</a>
    
            <h2>Video tutorial</h2>
            <div class="video-wrapper">
                <iframe width="640" height="360" src="//www.youtube.com/embed/pMcnYbYx9-I" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="clear"></div>
            
            <div class="about-message">What to do next? Check below section:</div>
            <div class="clear"></div>
            
            <div class="col-3">
                <h3>Boost us:</h3>
                <p>It's amazing when you boost development with your feedback and ratings. So we create special <a target="_blank" href="http://readyshoppingcart.com/boost-our-plugins/">boost page</a> to help you to help us.</p>
            </div>
    
            <div class="col-3">
                <h3>Documentation:</h3>
                <p>Check <a target="_blank" href="http://docs.readyshoppingcart.com/">documentation</a> and FAQ section. If you can't solve your problems - <a target="_blank" href="http://readyshoppingcart.com/contacts/">contact us</a>.</p>
            </div>
    
            <div class="col-3">
                <h3>Full Features List:</h3>
                <p>There are so many features, so we can't post it here. Like:</p>
                <ul>
                    <li>Amazing Pricing Table templates</li>
                    <li>Real time table builder</li>
                    <li>Icons and Tooltips feature</li>
                </ul>
                <p>So check full features list <a target="_blank" href="http://readyshoppingcart.com/product/pricing-table-ready-plugin-pro/">here</a>.</p>
                
            </div>
            <div class="clear"></div>
            
            <a class="button button-primary button-hero prtSendInfo" href="javascript:void(0)">Thank for check info. Start using plugin.</a>
            
            <span id="prtWelcomePageFindUsMsg"></span>
        </div>
    </div>

</div>