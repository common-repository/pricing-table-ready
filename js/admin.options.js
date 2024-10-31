var prtAdminFormChanged = [];
var prtReSaveIgnore = false;
window.onbeforeunload = function(){
	// If there are at lease one unsaved form - show message for confirnation for page leave
	if(prtAdminFormChanged.length)
		return 'Some changes were not-saved. Are you sure you want to leave?';
};
jQuery(document).ready(function(){
	
	ptrChangeOptSelectEvent();
	ptrChangeColumnSelectEvent();
	prtFirstOpen();
	
	prtSortFields();
	
	prtSetWidthTableField();
	prtSetHeightTableField();
	refeshPreview();
	
	jQuery(document).on('click','.add_column', prtAddColumn);
	jQuery(document).on('click','.trash', function() { prtRemoveColumn(jQuery(this).attr('id')); });
	jQuery(document).on('click','.prtSetClickSlide', function() { prtSetHideShow(jQuery(this)); });
	
	jQuery(document).on('click', '.ptrTemplateSelect', function(){
		if (jQuery(this).hasClass('prtPaidTemplate')){
			document.location.href = 'http://readyshoppingcart.com/product/pricing-table-ready-plugin-pro/';
		} else {
			changeTemlate(jQuery(this).attr('id'));
			jQuery('#prt-templates-list').dialog('close');
		}
	});
	
	jQuery(document).on('click','#prtTemplates-list-icon', function(){ showTemlpaleDialog(); });
	
	
	
/*-----*/
	
});
//------ end event ready

function ptrChangeOptSelectEvent(){
	jQuery('#prtWidthTable').change(function(){ prtSaveOptFields(2); });
	jQuery('#prtColumnsCount').change(function(){ prtSaveOptFields(3); });
	jQuery('#prtRowCount').change(function(){ prtSaveOptFields(3); });
	jQuery('#prtDescColunm').change(function(){ prtSaveOptFields(2); prtSetWidthTableField(); });
	jQuery('#prtTemplateSelect').change(function(){ prtSaveOptFields(4); });
	jQuery(document).on('change','#prtStyleSelect', function() { prtSaveOptFields(2); });
	jQuery('#prtFloat').change(function(){ prtSaveOptFields(2); });
	jQuery('#prtFloatText').change(function(){ prtSaveOptFields(2); });
	jQuery('#prtPrwEnable').change(function(){ prtSaveOptFields(2); });
}

function prtPause(){
	for(var i = 0; i < 5000; i++){
			
		}
}

function ptrChangeColumnSelectEvent(){
	jQuery(document).on('change', '.prtMainTable input', function() { ptrSaveFields(2); });
}

function prtSaveOptFields(d){
	
		var sendData = getDataFromRightOptPanel();
		
		jQuery(this).sendFormPrt({
			msgElID: 'PRT_OPTRIGHT_MSG',
			data: {page: 'handle', action: 'saveOptGroup', reqType: 'ajax', post_id: jQuery('#post_ID').val(), indata : sendData},
			onSuccess: function(res) {
				if(!res.error) {
					switch(d){
						case 1: refeshTables();break;
						case 2: refeshPreview(); break;
						case 3: refeshTables(); refeshPreview(); break;
						case 4: checkStyle(res.data[0], res.data[1]); refeshPreview(); break;
						default: null; break;
					}
				}
			}
		});
}

function refeshTables(){
	jQuery(this).sendFormPrt({
			msgElID: 'PRT_OPTRIGHT_MSG',
			data: {page: 'handle', action: 'refreshTables', reqType: 'ajax', post_id: jQuery('#post_ID').val()},
			onSuccess: function(res) {
				if(!res.error) {
					jQuery('#pricing-table-tables-options .inside').html(res.data);
					prtSetWidthTableField();
					prtSetHeightTableField()
				}
			}
		});
}

function refeshPreview(){
	jQuery(this).sendFormPrt({
			msgElID: 'PRT_OPTRIGHT_MSG',
			data: {page: 'handle', action: 'refreshPreview', reqType: 'ajax', post_id: jQuery('#post_ID').val()},
			onSuccess: function(res) {
				if(!res.error) {
					jQuery('#pricing-table-preview .inside').html(res.data);
				}
			}
		});
	
}

function getDataFromRightOptPanel(ignore){
	prtValidRightOptPanel();
	
	changeRowCount(jQuery('#prtRowCount').val());
	
	if (prtReSaveIgnore) {
		prtReSaveIgnore = false;
	} else {
		changeColumnCount(jQuery('#prtColumnsCount').val())
	}
	
	changeDescEnable(jQuery('select[name=prtDescColunm] option:selected').val());
	
	//var optArr = { widthTable: jQuery('#prtWidthTable').val(), colCount: jQuery('#prtColumnsCount').val(), colWidth: jQuery('#prtColumnsWidth').val(), rowCount: jQuery('#prtRowCount').val(), rowHeight: jQuery('#prtRowHeight').val(), descColumn: jQuery('#prtDescColunm option:selected').val(), template: jQuery('#prtTemplateSelect option:selected').val(), style: jQuery('#prtStyleSelect option:selected').val(), floatTable: jQuery('#prtFloat option:selected').val(), floatText: jQuery('#prtFloatText option:selected').val() };
	
	var optArr = {};
	
	jQuery('#pricing-table-options .options-right input[type=text]').each(function() {
		//alert(jQuery(this).attr('id'));
		optArr[jQuery(this).attr('id')] = jQuery(this).val();
	});
	
	jQuery('#pricing-table-options .options-right select').each(function() {
		//alert(jQuery(this).attr('id') + '| ' + jQuery(this).find('option:selected').val());
		optArr[jQuery(this).attr('id')] = jQuery(this).find('option:selected').val();
	});
	
	optArr['prtPrwEnable'] = jQuery('#pricing-table-options #prtPrwEnable').prop('checked') ? 1 : 0;
	
	return optArr;
}

function prtValidRightOptPanel(){
	(jQuery('#prtColumnsCount').val() < 1) ? jQuery('#prtColumnsCount').val(1) : false;
	//(jQuery('#prtRowCount').val() < 3) ? jQuery('#prtRowCount').val(3) : false;
	(jQuery('#prtRowCount').val() <= 0) ? jQuery('#prtRowCount').val(3) : false;
}

function changeRowCount(field){
	var count = 0;
	jQuery('#menu-item-1 .prtRow').each(function(){ // get real count row
		++count;
	});
	
	if (field > count) { // add row
		var count_add = field - count;
		for(var i = 1; i <= count_add; i++ ){
			jQuery('.prtMainTable .prt-li-desc .edit-fields').append('<div style="display: block; max-width: 190px;" id="menu-item-settings-0" class="menu-item-settings"><table><tr><td width="20"><?php echo $i; ?> - </td><td><input type="text" size="24" value="" name="prtDescVal" id="prtDescVal" placeholder=""></td></tr></table></div>');
			jQuery('.prtMainTable .prt-li-column .edit-fields').append('<div style="display: block;" id="menu-item-settings-1" class="menu-item-settings"><table><tr><td width="80">Row - </td><td><input type="text" size="26" value="" name="prtRow" class="prtRow" placeholder="text" /></td></tr></table></div>');
		}
		ptrSaveFields(); // save changes
		//alert('saved');
	} else if (field < count){ // remove row
		var new_count = field;
		var new_count_desc = 5 + parseInt(new_count, 10);
		var count_row = 0;
		
		jQuery(".prtMainTable #prtDescVal").each(function() {
			    ++count_row;
				if (count_row > new_count_desc - 3) {
					jQuery(this).parent().parent().parent().parent().parent().remove();
				}
		});

		count_row = 0;
		jQuery('.prtMainTable .prt-li-column').each(function() {
			jQuery(".prt_tr_row", this).each(function() {
				++count_row;
				if (count_row > new_count) {
					jQuery(this).parent().parent().parent().remove();
				}
			});
			count_row = 0;
		});
		ptrSaveFields(); // save changes
	}
}

function checkStyle(template, style){
	if (style != '') {
	jQuery(this).sendFormPrt({
			//msgElID: 'PRT_OPTRIGHT_MSG',
			data: {page: 'handle', action: 'checkStyle', reqType: 'ajax', prtTemplateSelect: template, prtStyleSelect: style},
			onSuccess: function(res) {
				if(!res.error) {
					jQuery('#forStyle').html('<strong>Color style:</strong><select id="prtStyleSelect" name="prtStyleSelect">' + res.data + '</select>');
				}
			}
		});
	} else {
		jQuery('#forStyle').html('');
	}
}

function changeDescEnable(d){
	if ( d == 'enable' ){
		jQuery('.prt-li-desc').show();
	} else {
		jQuery('.prt-li-desc').hide();
	}
}

function changeColumnCount(field){
	var count = 0;
	//var sendNumArr = [];
	jQuery('.prtMainTable .prt-li-column').each(function() {// get real count column
		++count;
	});
	
	if (field > count) { // add column
		var count_added = field - count;
		addEmptyColumn(count_added);
	} else if (field < count){ // remove column
		var new_count = field;
		var count_col = 0;
		jQuery('.prtMainTable .prt-li-column').each(function() {// get real count column
			++count_col;
			if (count_col > new_count) {
					jQuery(this).remove();
				}
		});
		ptrSaveFields(); // save changes
	}
}

function addEmptyColumn(count_added){
	jQuery(this).sendFormPrt({
			msgElID: 'PRT_OPTRIGHT_MSG',
			data: {page: 'handle', action: 'addEmptyColumn', reqType: 'ajax', post_id: jQuery('#post_ID').val(), num: count_added},
			onSuccess: function(res) {
				if(!res.error) {
					//return res.data;
				}
			}
		});
}

function prtSortFields(){
    jQuery( ".prtMenu" ).sortable({
        stop:ptrSaveFields
    });
    jQuery(".edit-fields").sortable({
        stop:ptrSaveFields
    });
}

function ptrSaveFields(d){
	
	var desc_value = jQuery(".prtMainTable #prtDescVal").serializeArray();
	
	var name_value = jQuery(".prtMainTable #prtColumnName").serializeArray();
	var url_value = jQuery(".prtMainTable #prtButtonUrl").serializeArray();
	var text_value = jQuery(".prtMainTable #prtButtonText").serializeArray();
	var price_value = jQuery(".prtMainTable #prtPrice").serializeArray();
	var currency_value = jQuery(".prtMainTable #prtCurrency").serializeArray();
	var row_value = jQuery(".prtMainTable .prtRow").serializeArray();
	//alert(row_value);
	
	var sendArr = [desc_value, name_value, url_value, text_value, price_value, currency_value, row_value];
	
	var sendData = getDataFromRightOptPanel();
		jQuery(this).sendFormPrt({
			msgElID: 'PRT_OPTRIGHT_MSG',
			data: {page: 'handle', action: 'saveColumn', reqType: 'ajax', post_id: jQuery('#post_ID').val(), indata : sendArr},
			onSuccess: function(res) {
				if(!res.error) {
					switch(d){
						case 1: refeshTables();break;
						case 2: refeshPreview(); break;
						case 3: refeshTables(); refeshPreview(); break;
						default: null; break;
					}
				}
			}
		});

}

function prtAddColumn(){
	var count = jQuery("#prtColumnsCount").val();
	++count;
	jQuery("#prtColumnsCount").val(count);
	prtSaveOptFields(3);
}

function prtRemoveColumn(n){
	jQuery(this).sendFormPrt({
			msgElID: 'PRT_OPTRIGHT_MSG',
			data: {page: 'handle', action: 'deleteColumn', reqType: 'ajax', post_id: jQuery('#post_ID').val(), num: n},
			onSuccess: function(res) {
				if(!res.error) {
					prtReSaveIgnore = true;
					var count = jQuery("#prtColumnsCount").val();
					--count;
					jQuery("#prtColumnsCount").val(count);
					prtSaveOptFields(3);
				}
			}
		});
}

function prtSetHideShow(obj){
	if (obj.next().css('display') == 'none') {
		obj.next().show();
	} else {
		obj.next().hide();
	} 
}

function prtFirstOpen(){
	if (jQuery('.prtMainTable input').val() == ''){
		ptrSaveFields(2);			
	}
	
}

function changeTemlate(val){
	jQuery('#prtTemplateSelect option[value='+val+']').prop('selected', true);
	prtSaveOptFields(4);
}

function prtSetWidthTableField(){
	var i = 0;
	var cw = 267; // column
	var dw = 212; // description
	var aw = 226; // add column
	jQuery('.table-item').each(function() {
		++i;
	});
	
	if (jQuery('#menu-item-0').css('display') == 'none') {
		dw = 0;
	} 
	
	var newWidht = dw + ((i-1) * cw) + aw;
	jQuery('.prtMainTable').css('width', newWidht);
	//alert('i=' + i + ' | ' + newWidht);
}

function prtSetHeightTableField(){
	var i = 0;
	var def = 520;
	var hr = 55;
	jQuery('#menu-item-1 .prt_tr_row').each(function() {
		++i;
	});

	var newHeight = def + ((i - 3) * hr);
	jQuery('#pricing-table-tables-options .inside').css('height', newHeight);
}

function showTemlpaleDialog(){
	toeShowDialogCustomized('#prt-templates-list', {
		openCallback: function() {
			//alert('callback');
		},
		buttons: { /* 
			'Don\'t show this message again': function() {
				setCookieCsp('csp_hide_set_defs_tpl_popup', true, 300);
				jQuery(this).dialog('close');
			},*/
		Close: function() {
				jQuery(this).dialog('close');
			}
		},
		close: function( event, ui ) {
			//alert('red close');
		}
	});
}

function toeShowDialogCustomized(element, options) {
	options = jQuery.extend({
		resizable: false
	,	width: 836
	,	height: 600
	,	closeOnEscape: true
	,	open: function(event, ui) {
			jQuery('.ui-dialog-titlebar').css({
				'background-color': '#222222'
			,	'background-image': 'none'
			,	'border': 'none'
			,	'margin': '0'
			,	'padding': '0'
			,	'border-radius': '0'
			,	'color': '#CFCFCF'
			,	'height': '27px'
			});
			jQuery('.ui-dialog-titlebar-close').css({
				'background': 'url("../wp-includes/js/thickbox/tb-close.png") no-repeat scroll 0 0 transparent'
			,	'border': '0'
			,	'width': '15px'
			,	'height': '15px'
			,	'padding': '0'
			,	'border-radius': '0'
			,	'margin': '-7px 0 0'
			}).html('');
			jQuery('.ui-dialog').css({
				'border-radius': '3px'
			,	'background-color': '#FFFFFF'
			,	'background-image': 'none'
			,	'padding': '1px'
			,	'z-index': '300000'
			});
			jQuery('.ui-dialog-buttonpane').css({
				'background-color': '#FFFFFF'
			});
			jQuery('.ui-dialog-title').css({
				'color': '#CFCFCF'
			,	'font': '12px sans-serif'
			,	'padding': '6px 10px 0'
			});
			if(options.openCallback && typeof(options.openCallback) == 'function') {
				options.openCallback(event, ui);
			}
		}
	}, options);
	return jQuery(element).dialog(options);
}

//-----------------

function changeAdminFormPrt(formId) {
	if(jQuery.inArray(formId, prtAdminFormChanged) == -1)
		prtAdminFormChanged.push(formId);
}

