<?php
class handleModelPrt extends modelPrt {
	public $_options;
	
	public function __construct() {
		$post = reqPrt::get('post');
		if(empty($post['post_id'])) return false;
        $this->_options = (!empty($post) && isset($post)) ? framePrt::_()->getModule('options')->getPostMeta($post['post_id'], '_ready_options') : NULL;
    }
	
	public function saveOptGroup($post_id, $indata){
		
		if (empty($indata['prtStyleSelect']) && !isset($indata['prtStyleSelect'])){
			$indata['prtStyleSelect'] = $this->checkStyle($indata['prtTemplateSelect']);
		} else {
			$indata['prtStyleSelect'] = $this->checkStyle($indata['prtTemplateSelect'], true) ? $indata['prtStyleSelect'] : '';
		}
		
		update_post_meta($post_id, '_ready_options', $indata);
		
		return array($indata['prtTemplateSelect'], $indata['prtStyleSelect']);//$indata;
	}
	
	public function saveColumn($post_id, $indata){
		add_post_meta($post_id, '_ready_columns', $indata, true) or update_post_meta($post_id, '_ready_columns', $indata);
	}
	
	public function addEmptyColumn($post_id, $count){
		$columnArr = framePrt::_()->getModule('options')->getPostMeta($post_id, '_ready_columns');
		$rowArrIncrement = count($columnArr)-1; 
		$sizeColumn = count($columnArr[1]);
		$sizeFullRow = count($columnArr[$rowArrIncrement]);
		$sizeDinamicLength = $sizeFullRow / $sizeColumn;  // (count row) / (count column)
		
		for($ig=0; $ig < $count; $ig++){
			$columnArr[1][] = array('name' => 'prtColumnName', 'value' => '');
			$columnArr[2][] = array('name' => 'prtButtonUrl', 'value' => '');
			$columnArr[3][] = array('name' => 'prtButtonText', 'value' => '');
			$columnArr[4][] = array('name' => 'prtPrice', 'value' => '');
			$columnArr[5][] = array('name' => 'prtCurrency', 'value' => '');
			
			for ($i=0; $i<$sizeDinamicLength; $i++){
				$columnArr[6][] = array('name' => 'prtRow', 'value' => '');
			}
		}
		update_post_meta($post_id, '_ready_columns', $columnArr);
	}
	
	public function getColumns($id){
		$columnArr = framePrt::_()->getModule('options')->getPostMeta($id, '_ready_columns');
		
		if (!empty($columnArr)){	
			
			/* Set description */
			$blockData[0] = array();
			$sizeDesc = count($columnArr[0]);
			for($i=0; $i < $sizeDesc; $i++){
				$blockData[0][] = $columnArr[0][$i]['value'];
			}
			
			/* Set columns */
			$rowArrIncrement = count($columnArr)-1; 
			$sizeColumn = count($columnArr[1]); // count column wich out description
			$j=0; 
			
			for($ig=0; $ig < $sizeColumn; $ig++){
				$blockData[$ig+1] = array();
				for($i=1; $i < $rowArrIncrement; $i++){ // until 5 ( 6 this start dinamic row)
					//echo 'columnArr['.$i.']['.$ig.']["value"] = '.$columnArr[$i][$ig]['value']."<br />";
					$blockData[$ig+1][] = $columnArr[$i][$ig]['value'];
				}
			}
			
			$sizeFullRow = count($columnArr[$rowArrIncrement]);
			$sizeDinamicLength = $sizeFullRow / $sizeColumn;  // (count row) / (count column)
			$marker = 0; $stop = 0;
						
			for($ig=0; $ig < $sizeColumn; $ig++){
				for($i=$marker; $i < $sizeFullRow; $i++){
					if ($stop >= $sizeDinamicLength) { $stop = 0; $marker = $i; break; }
					$blockData[$ig+1][] =  $columnArr[$rowArrIncrement][$i]['value'];
					$stop++;
				}
			}
			
		} else {
			//new post
			$blockData = array(array('','','','',''), array('','','','','','','',''), array('','','','','','','',''));
		}
		
		return $blockData;
	}
	
	public function getOptions($id){
		$optArr = framePrt::_()->getModule('options')->getPostMeta($id, '_ready_options');
		
		if (!empty($optArr)){	
			$optArr['template_opt'] = $this->getTemplate($optArr['prtTemplateSelect']);
			$optArr['prtStyleSelect'] = $this->getStyleList($optArr['prtTemplateSelect'], $optArr['prtStyleSelect']);
		} else {
			//new post
			$optArr = array( 'prtWidthTable'=> '', 'prtColumnsCount' => 2, 'prtColumnsWidth'=>'', 'prtRowCount' => 3, 'prtRowHeight'=>'', 'prtDescColunm' => 'disable', 'prtFloat' => 'center', 'prtFloatText' => 'center', 'prtPrwEnable' => 1);
			$optArr['prtTemplateSelect'] = 'simple';
			$optArr['prtStyleSelect'] = '';
			
			add_post_meta($id, '_ready_options', $optArr, true);
			$optArr['template_opt'] = $this->getTemplate($optArr['prtTemplateSelect']);
		}
		
		return $optArr;
	}
	
	public function getTemplate($sel){
		$ret = '';
		$files = scandir(PRT_DIR.'constructor/');
		unset($files[0]); unset($files[1]);
		 
		foreach($files as $file) {
			if ($file == 'custom' || $file == 'core.css') continue;
			if ($file != $sel) {
				if (file_exists(PRT_DIR.'constructor/'.$file.'/wrap.php')){
					$ret .= '<option value="'.$file.'">'.$file.'</option>';
				}
			} else {
				$ret .= '<option selected="selected" value="'.$file.'">'.$file.'</option>';
			}
		}
		return $ret;
	}
	
	public function getStyleList($dir, $style, $getDefault = false){
		$path = PRT_DIR.'constructor/'.$dir.'/colors.css';
		$ret = '';
		if (file_exists( $path )){
			$content = file_get_contents($path);
			preg_match_all("~\/\*([a-zA-Z0-9_]+)\*\/~", $content, $out);
			$styleArr = $out[1];
	
			if (empty($style)){ // check default
				for($i = 0; $i < count($styleArr); $i++){
					$el = $styleArr[$i];
					if (ctype_upper($el[0])){
						$styleArr[$i] = $style = strtolower($styleArr[$i]);
						break;
					} 
				}
			}
			
			if ($getDefault) return $style;
			
			if (!empty($styleArr) && isset($styleArr)){
				foreach($styleArr as $el){
					$el = strtolower($el);
					$sel = ($style == $el) ? 'selected="selected"' : '';
					$ret .= '<option '.$sel.' value="'.$el.'">'.$el.'</option>';
				}
			}
		} 
		
		return $ret;
	}
	
	public function checkStyle($template, $check = false){
		if ($check){
			$res = $this->getStyleList($template, '');
			return !empty($res) ? true : false;
		} else {
			return $res = $this->getStyleList($template, '', true);
		}
	}
	
	public function deleteColumn($id, $num){
		$columnArr = framePrt::_()->getModule('options')->getPostMeta($id, '_ready_columns');
		
		$rowArrIncrement = count($columnArr)-1; 
		$sizeColumn = count($columnArr[1]); // count column wich out description
		$sizeFullRow = count($columnArr[$rowArrIncrement]);
		$sizeDinamicLength = $sizeFullRow / $sizeColumn;  // (count row) / (count column)
		$marker = 0; $stop = 0;
		
		for($i=1; $i < $rowArrIncrement; $i++){ 
			//unset($columnArr[$i][$num]); 
			 array_splice($columnArr[$i], $num, 1);
		}
			
		for($ig=0; $ig < $sizeColumn; $ig++){
			for($i=$marker; $i < $sizeFullRow; $i++){
				if ($stop >= $sizeDinamicLength) { $stop = 0; $marker = $i; break; }
				if ($ig == $num) { 
				  array_splice($columnArr[$rowArrIncrement], $i, 1);
				  $i--;
				}
				$stop++;
			}
		}
		
		$this->saveColumn($id, $columnArr);
	}
	
	public function rebuildArrColumn($inarr){
		$ret = array();
		
		if (!empty($inarr['prtDescVal']) && isset($inarr['prtDescVal'])){
			$i=0;
			foreach($inarr['prtDescVal'] as $el){
				$ret[0][$i] = array('name'=>'prtDescVal[]', 'value'=>$el );
				$i++;
			}
		}
		
		if (!empty($inarr['prtColumnName']) && isset($inarr['prtColumnName'])){
			$i=0;
			foreach($inarr['prtColumnName'] as $el){
				$ret[1][$i] = array('name'=>'prtColumnName[]', 'value'=>$el );
				$i++;
			}
		}
		
		if (!empty($inarr['prtButtonUrl']) && isset($inarr['prtButtonUrl'])){
			$i=0;
			foreach($inarr['prtButtonUrl'] as $el){
				$ret[2][$i] = array('name'=>'prtButtonUrl[]', 'value'=>$el );
				$i++;
			}
		}
		
		if (!empty($inarr['prtButtonText']) && isset($inarr['prtButtonText'])){
			$i=0;
			foreach($inarr['prtButtonText'] as $el){
				$ret[3][$i] = array('name'=>'prtButtonText[]', 'value'=>$el );
				$i++;
			}
		}
		
		if (!empty($inarr['prtPrice']) && isset($inarr['prtPrice'])){
			$i=0;
			foreach($inarr['prtPrice'] as $el){
				$ret[4][$i] = array('name'=>'prtPrice[]', 'value'=>$el );
				$i++;
			}
		}
		
		if (!empty($inarr['prtCurrency']) && isset($inarr['prtCurrency'])){
			$i=0;
			foreach($inarr['prtCurrency'] as $el){
				$ret[5][$i] = array('name'=>'prtCurrency[]', 'value'=>$el );
				$i++;
			}
		}
		
		if (!empty($inarr['prtRow']) && isset($inarr['prtRow'])){
			$i=0;
			foreach($inarr['prtRow'] as $arr){
				foreach($arr as $el){
					$ret[6][$i] = array('name'=>'prtRow', 'value'=>$el );	
					$i++;
				}
			}
		}
		
		return $ret;
	}
	
	public function rebuildArrOpt($inarr){
		return array('prtWidthTable'=>$inarr['prtWidthTable'], 'prtColumnsCount' => $inarr['prtColumnsCount'], 'prtRowCount' => $inarr['prtRowCount'], 'prtDescColunm' => $inarr['prtDescColunm'], 'prtTemplateSelect' => $inarr['prtTemplateSelect'], 'prtStyleSelect' => $inarr['prtStyleSelect'], 'prtFloat' => $inarr['prtFloat'], 'prtFloatText' => $inarr['prtFloatText'], 'prtPrwEnable' => $inarr['prtPrwEnable']);
	}
    
	
	/*--- Popup Template ---*/
	public function getPopupTemlpate($paid){
		$cons_path = PRT_DIR.'constructor/';
		$files = scandir($cons_path);
		$template = array(); $ret = '';
		unset($files[0]); unset($files[1]);
		 
		foreach($files as $file) {
			if ($file == 'custom' || $file == 'core.css') continue;
			$templateFiles = scandir($cons_path.$file.'/');
			foreach($templateFiles as $tFile) {
				preg_match_all("~\.jpg~i", $tFile, $out);
				if (!empty($out[0][0])){
					preg_match_all("~_(\d+)\.jpg~i", $tFile, $num);
					$paid_t = file_exists($cons_path.$file.'/wrap.php') ? false : true;
					$template[$num[1][0]] = array('name'=>$file, 'src'=>PRT_DIR_S.'/constructor/'.$file.'/'.$tFile, 'paid'=> $paid_t);
				}
			}
			
		}
		
		ksort($template);
		
		foreach($template as $el){
			$ret .= $this->getModule()->getView()->getTicketPopupTemplate($el);
		}

		return $ret;	
	}
	
	/*--- preview ---*/
	
	public function refreshPreview($id){
		$options = framePrt::_()->getModule('options')->getPostMeta($id, '_ready_options');
		
		if (!isset($id)) return '<div style="color:red;">ID is empty ([ready-pricing-tables id=???])</div>'; 
		if (empty($options)) return '<br /><div><span style="color:#C00;">Error!</span> That\'s wrong shrotcode: [ready-pricing-tables id=<span style="color:red;">'.$id.'</span>]</div><br />';

		if ($options['prtTemplateSelect'] != 'custom') {
			$table = $this->setTemplate($id, $options['prtTemplateSelect']);
			$table = dispatcherPrt::applyFilters('beforeTblReturn', $table);
		} else {
			//$table = $this->callConstructor($id);	
		}
		
		return $table;
	}
	
	
	public function setTemplate($id, $template){
		$options = framePrt::_()->getModule('options')->getPostMeta($id, '_ready_options');
		$columnArr = framePrt::_()->getModule('options')->getPostMeta($id, '_ready_columns');
		$fullCountRow = count($columnArr[6]);
		$style = '';
		$this->post_id = $id;
		
		$wrap_tpl = $this->getTpl($template, 'wrap', NULL);
		$desc_tpl = $this->getTpl($template, 'desc', NULL);
		$column_tpl = $this->getTpl($template, 'column', NULL);
		$row_tpl = $this->getTpl($template, 'row', NULL);
		
		$cl = '{columns}'; $rw = '{row}';
		$marker = 0; $stop = 0;
		$table = $wrap_tpl;
		
		//style
		$style = $this->loadStyle($template);
		$table = preg_replace("~{style}~", $style, $table);
		
		//description
		if ($options['prtDescColunm'] == 'enable'){
			$table = preg_replace("~$cl~", $desc_tpl.$cl, $table);
			$n = count($columnArr[0]);
			for($i = 0; $i < $n; $i++){
				$tpl = "~{row".$i."}~";
				$table = preg_replace("~{row$i}~", isset($columnArr[0][$i]['value']) ? $columnArr[0][$i]['value'] : '', $table);
			}
			
			preg_match_all("~\{row \[(\d+)\]\}~", $table, $out);
			
			$start_i =  $out[1][0];
			$rwd = "{row [$start_i]}";
			for($i = $start_i; $i < $n; $i++){
				$table = preg_replace("~\{row \[(\d+)\]\}~", $row_tpl.$rwd, $table);
				$hoke_Row = '~{prtRow}~'; 
				$table = preg_replace($hoke_Row, isset($columnArr[0][$i]['value']) ? $columnArr[0][$i]['value'] : '', $table);
			}
			$table = preg_replace("~\{row \[(\d)\]\}~", '', $table);
		}
		
		// table
		for($i = 0; $i < $options['prtColumnsCount']; $i++){
			
			$table = preg_replace("~$cl~", $column_tpl.$cl, $table);	
			
			$table = preg_replace("~{num_col}~", $i, $table);
			
			$hoke_nameColumn = $this->delSpecLiteral('~{'.$columnArr[1][$i]['name'].'}~');
			//echo $hoke_nameColumn.'|'.$columnArr[1][$i]['value'].'|'."\n";
			$table = preg_replace($hoke_nameColumn, $columnArr[1][$i]['value'], $table);
			
			$hoke_urlButton =  $this->delSpecLiteral('~{'.$columnArr[2][$i]['name'].'}~');
			$url = $columnArr[2][$i]['value'];
			/*if (preg_match('~@~', $url)) {
				$table = preg_replace($hoke_urlButton, 'mailto:'.$url, $table);	
			} elseif(preg_match('~www\.~', $url)){
				$table = preg_replace($hoke_urlButton, 'http://'.$url, $table);	
			} else {
				$table = preg_replace($hoke_urlButton, $url, $table);	
			}*/
			
			if (preg_match('~@~', $url)) {
				$table = preg_replace($hoke_urlButton, 'mailto:'.$url, $table);	
			} else {
				if ( !preg_match('~http(s?):\/\/~', $url) && preg_match('~www\.~', $url) ) {
					if (!preg_match('~https:\/\/~', $url)) {
						$table = preg_replace($hoke_urlButton, 'http://'.$url, $table);
					} else {
						$table = preg_replace($hoke_urlButton, $url, $table);
					}
				} elseif(!preg_match('~www\.~', $url)){
					if (!preg_match('~http(s?):\/\/~', $url)) {
						$table = preg_replace($hoke_urlButton, 'http://'.$url, $table);
					} else {
						$table = preg_replace($hoke_urlButton, $url, $table);
					}
				} else {
					$table = preg_replace($hoke_urlButton, $url, $table);
				}
				
			}
			
			
			$hoke_textButton = $this->delSpecLiteral('~{'.$columnArr[3][$i]['name'].'}~');
			$table = preg_replace($hoke_textButton, $columnArr[3][$i]['value'], $table);
			
			$hoke_Price = $this->delSpecLiteral('~{'.$columnArr[4][$i]['name'].'}~');
			$table = preg_replace($hoke_Price, $columnArr[4][$i]['value'], $table);
			
			$hoke_Currency = $this->delSpecLiteral('~{'.$columnArr[5][$i]['name'].'}~');
			$table = preg_replace($hoke_Currency, $columnArr[5][$i]['value'], $table);
			
			for($r = $marker; $r < $fullCountRow; $r++){
				if ($stop >= $options['prtRowCount']) { $stop = 0; $marker = $r; break; }
				
				$table = preg_replace("~$rw~", $row_tpl.$rw, $table);	
				$hoke_Row = '~{prtRow}~';
				$table = preg_replace($hoke_Row, $columnArr[6][$r]['value'], $table);
				$stop++;
			}
			$table = preg_replace("~$rw~", '', $table);
			
		}
		
		$table = preg_replace("~$cl~", '', $table);
		$table = preg_replace("~$rw~", '', $table);
		
		// clear hook paid template
		$table = preg_replace('~{dBox1}~','', $table);
		$table = preg_replace('~{dBox2}~','', $table);
		$table = preg_replace('~{prtLabel}~','', $table);

		// set prefix		
		if (file_exists( PRT_DIR.'constructor/'.$template.'/meta.txt' )){
			ob_start();
			require( PRT_DIR.'constructor/'.$template.'/meta.txt' );
			$t = ob_get_contents();
			ob_end_clean();
			preg_match_all("~pref=\"(.*)\"~U", $t, $out);
			$cpref = $out[1][0];
		}
		$table = preg_replace("~\{cpref\}~", $cpref, $table);		
		return $table;
	}
	
	public function delSpecLiteral($str){
		$str = preg_replace("~\[~", '', $str);
		$str = preg_replace("~\]~", '', $str);
		return $str;
	}
	
	public function loadStyle($dir){
		ob_start();
		require( PRT_DIR.'constructor/'.$dir.'/style.css' );
		$ret = ob_get_contents();
		ob_end_clean();
		
		ob_start();
		require( PRT_DIR.'constructor/core.css' );
		$ret .= "\n".ob_get_contents();
		ob_end_clean();
		
		if (file_exists( PRT_DIR.'constructor/'.$dir.'/colors.css' )){
			ob_start();
			require( PRT_DIR.'constructor/'.$dir.'/colors.css' );
			$colorStyle = "\n".ob_get_contents();
			ob_end_clean();
			$ret .= $this->getColorStyle($colorStyle);	
		}
		
		$ret = $this->getCoreCss($ret);
		
		return $ret;
	}
	
	public function getTpl($dir, $fn, $nc){
		ob_start();
		require( PRT_DIR.'constructor/'.$dir.'/'.$fn.$nc.'.php' );
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	
	public function getCoreCss($content){
		$options = framePrt::_()->getModule('options')->getPostMeta($this->post_id, '_ready_options');
		$content = !empty($options['prtWidthTable']) ? preg_replace("~\[mainWidth\]~", 'width:'.$options['prtWidthTable'].'px;', $content) : $content;
		$content = !empty($options['prtFloat']) ? preg_replace("~\[floatTable\]~", 'text-align:'.$options['prtFloat'].';', $content) : $content;
		$content = !empty($options['prtFloatText']) ? preg_replace("~\[floatText\]~", 'text-align:'.$options['prtFloatText'].';', $content) : $content;
		
		return $content;
	}
	
	public function getColorStyle($content){
		$options = framePrt::_()->getModule('options')->getPostMeta($this->post_id, '_ready_options');
		$block = $options['prtStyleSelect'];
		preg_match_all("~/\*$block\*\/(.*)\/\*\-+\*\/~sU", $content, $out);
		
		if (empty($out[1][0])){ // if default template
			$block[0] = strtoupper($block[0]);
			preg_match_all("~/\*$block\*\/(.*)\/\*\-+\*\/~sU", $content, $out);
			$style = $out[1][0];
		} else {
			$style = $out[1][0];
		}
		return $style;
	}
	
	/* for future development */
	public function callConstructor($id){
		
	}
	
	
}
?>