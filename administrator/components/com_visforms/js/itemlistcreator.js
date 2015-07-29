/**
 *------------------------------------------------------------------------------
 *  com_visforms by vi-solutions for Joomla! 3.x
 *------------------------------------------------------------------------------
 * @package     com_visforms
 * @copyright   Copyright (c) 2014 vi-solutions. All rights preserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Aicha Vack
 * @link        http://www.vi-solutions.de
 *
 * @version     1.0.0 2014-04-20
 * @since       1.0
 *------------------------------------------------------------------------------
*/

(function(){
    //public plugin functions go in there
	jQuery.extend(jQuery.fn, {
		visformsItemlistCreator : function (options) {
			var defaults = {
				texts : {
					txtMoveUp: "Move Up",
					txtMoveDown: "Move Down",
					txtChange: "Change",
					txtDelete: "Delete",
					txtClose: "Close",
					txtAddItem: "Add item",
                    txtCreate: "Create item",
					txtReset: "Reset",
					txtSave: "Save",
                    txtJYes : "Yes",
                    txtJNo : "No",
                    txtAlertRequired : "Value and Label are required",
                    txtValue: "Value",
                    txtLabel: "Label",
                    txtDefault: "Default"
				},
                params : {
                    fieldName : 'f_radio_list_hidden'
                }
			};
			//use true as first paremeter to merge objects recursivly
			var settings = jQuery.extend(true, {}, defaults, options);
            
			var hdnMFldNames = ["listitemvalue", "listitemlabel", "listitemischecked"];
            
            var idPrefix = "jform_defaultvalue_";
            var dbFieldExt = "_list_hidden";
            var ctype = getCType();
            var dbFieldName = idPrefix + "f_" + ctype + dbFieldExt;
            
            var hdnItemListId = "hdnItemList" + ctype;
            var addButtonId = "add" + ctype;
            var itemListContId = "itemListCont" + ctype;
            var itemListId = "itemList" + ctype;
            
			
			//Protected Helper functions
            
            //get value of the highest used id in itemlist
            function getLastItemId()
            {
                return jQuery("#" + idPrefix + "f_" + ctype + '_lastId').val();
            }
            
            //increment stored value of highest used id
            function setLastItemId()
            {
                var oldId = jQuery("#" + idPrefix + "f_" + ctype + '_lastId').val();
                var newId = 1 + parseInt(oldId);
                jQuery("#" + idPrefix + "f_" + ctype + '_lastId').attr("value", newId);
            }
			
            
            //extract stringified user inputs from hidden field
			function getItemsStr () {
				var itemsDB = jQuery("#" + dbFieldName).val();
				return itemsDB;
			}
			
			//convert stored user inputs string into an object
            function createItemsObjFromString (itemsDB) {
				if (itemsDB != "") {
					var itemsObj = JSON.parse(itemsDB);
				}
				else {
					var itemsObj =  {};
				}
				return itemsObj;
			}
			
			function getItemsObj () {
				var itemsStr = getItemsStr();
				var itemsObj = createItemsObjFromString(itemsStr);
				return itemsObj;
			}
			
            //stringify user inputs
			function createItemsStr (obj) {
					return itemsStr = JSON.stringify(obj);
			}
			
            //set stringified user inputs string in hidden field, that is stored in Joomla! database
			function setItemsStr (itemsStr) {
				if (itemsStr != "") {
					jQuery("#" + dbFieldName).attr("value", itemsStr);
				}
			}
			
			//remove some enclosing bracket and create a lean image object that only contains the key/value pairs
			function cleanItemArr (arr) {
				$object = {};
				jQuery.each(arr, function() {
				if ($object[this.name] !== undefined) {
					if (!$object[this.name].push) {
						$object[this.name] = [$object[this.name]];
					}
					$object[this.name].push(this.value || '');
					} else {
					   $object[this.name] = this.value || '';
					}
				});
				return $object;
			}
			
			//return user input in one item list configuration field as string
			function getListItem (i, fieldName) {
				var item = getItemsObj()[i];
                var itemName = item[fieldName];
                if (fieldName == 'listitemischecked')
                {
                    if (itemName == '1')
                    {
                        itemName = settings.texts.txtJYes;
                    }
                    else
                    {
                        itemName = settings.texts.txtJNo;
                    }
                }
                
                return itemName;
			}
            
            function removeListItemValues(i)
            {
                var li = jQuery("#" + itemListId + " .liItem").eq(i);
				var container = li.find("span.itemValues");
                container.remove();
            }
			
            //Append user input in item list which is visible for user
			function setListItemValue(text, i) {
				var li = jQuery("#" + itemListId + " .liItem").eq(i);
                //if the list element is the first one, we insert it after the a.itemDown arrow, else after the last list element 
                var itemBefore = li.find("span.itemValues");
                if (itemBefore.length < 1)
                {
                    itemBefore = li.find("a.itemDown");
                }
                else
                {
                    itemBefore = itemBefore.last();
                }
                var span = jQuery("<span/>", {
                    "class" : "itemValues",
                    html : text
                })
                span.insertAfter(itemBefore);
            }
			
			//create a list item in ul#itemList
			function createListItem () {
				// Create list entry
				var li = jQuery("<li/>", {
					"class" : "liItem",
				});
				jQuery("#" + itemListId).append(li);
				return li;
			}
			
            //create html elements in visible item list
			function createListItemElements (i) {
				var li = jQuery("#" + itemListId + " .liItem").eq(i);
				jQuery("<a/>", {
					"href" : "#",
					"data-target" : "#" + hdnItemListId,
					"class" : "itemUp",
					html : "<i class=\"icon-arrow-up-3\" title=\"" + settings.texts.txtMoveUp + "\"></i>"
				}).appendTo(li);
				jQuery("<a/>", {
					"href" : "#",
					"data-target" : "#" + hdnItemListId,
					"class" : "itemDown",
					html : "<i class=\"icon-arrow-down-3\" title=\"" + settings.texts.txtMoveDown + "\"></i>"
				}).appendTo(li);
				jQuery("<a/>", {
					"href" : "#",
					"data-target" : "#" + hdnItemListId,
					"class" : "itemChange",
					html: settings.texts.txtChange
				}).appendTo(li);
				jQuery("<a/>", {
					"href" : "#",
					"data-target" : "#" + hdnItemListId,
					"class" : "itemRemove",
					html: settings.texts.txtDelete
				}).appendTo(li);
			}
			
            //Disable itemUp/itemDown arrow with CSS, first list item cannot be moved up, last cannot be moved down
			function setArrowClassDisabled (i, up) {
				if (up) {
					var ancor = jQuery("#" + itemListId + " .liItem").eq(i).find(".itemUp");
				}
				else {
					var ancor = jQuery("#" + itemListId + " .liItem").eq(i).find(".itemDown");
				}
					
				ancor.addClass("disabled");		
			}
			
            //enable itemUp/itemDown arrow with CSS
			function removeArrowClassDisabled (i, up) {
				if (up) {
					var ancor = jQuery("#" + itemListId + " .liItem").eq(i).find(".itemUp");
				}
				else {
					var ancor = jQuery("#" + itemListId + " .liItem").eq(i).find(".itemDown");
				}
					
				ancor.removeClass("disabled");		
			}
            
            function checkRequiredFields(form)
            {
                var requiredFields = ["listitemvalue", "listitemlabel"];
                var valid = true;
                jQuery.each(requiredFields, function (key, value) {
                    if (form.find("." + value + " input").val() == "")
                    {
                        form.find("." + value + " input").addClass("error");
                        valid = false;
                    }
                });
                if (valid == false)
                {
                    alert(settings.texts.txtAlertRequired);
                    return false;
                }
                return true;
            }
            
            function removeClassError (form)
            {
                var requiredFields = ["listitemvalue", "listitemlabel"];
                jQuery.each(requiredFields, function (key, value) {
                   form.find("." + value + " input").removeClass("error");
                });
            }
			
			function createHiddenForm (idx) {				
				//copy master form
				var $clone = jQuery("#formMaster").clone();
                //we use clone(), without parameter true, to prevent tooltips from been copied and postitioned relatively to the original element
                $clone.removeAttr("id");
                jQuery("#" + hdnItemListId).append($clone);
				
				//create tooltips for copied master elements
				setTips(idx);
				
				// create buttons
				// Close button top
				var p = jQuery("<p/>", {
					html : "<a href=\"#\" class=\"btn closeForm\" title=\"" + settings.texts.txtClose + "\"><span class=\"icon-unpublish\"></span></a><a href=\"#\" class=\"btn newItemClose\" title=\"" + settings.texts.txtClose + "\"><span class=\"icon-unpublish\"></span></a>",
					"class" : "pull-right"
				});
				jQuery("#"+ hdnItemListId + " .itemForm").eq(idx).prepend(p);
				// Reset, Save, Close button bottom
				var btns = '<a href=\"#\" class=\"btn btn-success addItem\">' + settings.texts.txtAddItem + '</a> ';
				btns += '<a href=\"#\" class=\"btn btn-danger newItemClose\">' + settings.texts.txtClose + '</a> ';
				btns += '<a href=\"#\" class=\"btn btn-success saveForm\">' + settings.texts.txtSave + '</a> ';
				btns += '<a href=\"#\" class=\"btn resetForm\">' + settings.texts.txtReset + '</a> ';
				btns += '<a href=\"#\" class=\"btn btn-danger closeForm\">' + settings.texts.txtClose + '</a>';
				
				var pBtn = jQuery("<span class=\"btnContainer text-center\">" + btns + "</span>");
				jQuery("#"+ hdnItemListId + " .itemForm").eq(idx).append(pBtn);
			
				var form = jQuery("#"+ hdnItemListId + " .itemForm").eq(idx);
				return form;
			}
			
			function setTips (i) {
				var form = jQuery("#"+ hdnItemListId + " .itemForm").eq(i);
					form.find("[data-original-title]").addClass("hasTooltip");
				form.find(".hasTooltip").tooltip();
			}
			
			function setFormPosition (li, idx) {
				var position = li.position();
				//we either recieve a numeric index or an id string! Build id string if a numeric index is given
				var height = jQuery("#"+ hdnItemListId + " .itemForm").eq(idx).height();
				if (position.top < height + 40) { height = position.top - 40}
				jQuery("#"+ hdnItemListId + " .itemForm").eq(idx).css({
					"position" : "absolute",
					"top" : position.top - height,
					"left" : position.left - 25
				});
			}
			
			function setValuesInHiddenForm (i) {
				var item = getItemsObj()[i];
				jQuery.each(item, function (key, value) {
                    var control = jQuery("#"+ hdnItemListId + " .itemForm").eq(i).find("." + key + " .controls ." + key);
                    if (key == 'listitemischecked')
                    {
                        control.attr("checked", "checked");
                    }
                    else
                    {
                        control.attr("value", value);
                    }
				});
			}
			
			function delItemElements (i) {
				//remove list item
				jQuery("#" + itemListId + " .liItem").eq(i).remove();
				//remove form
				jQuery("#"+ hdnItemListId + " .itemForm").eq(i).remove();
			}
			
			function saveForm($form) {
				var idx = $form.index();
				//get the current items as object
				var rawObj = getItemsObj();
				var itemsObj = buildItemsObj (rawObj, idx);
                setCountOfDefaultOptions(itemsObj);
				//Stingify images object and set the string as value in itemsDB field (so that it will be stored in database, when module is saved)
				var itemsStr = createItemsStr(itemsObj);
				setItemsStr (itemsStr);
			}
            
            function setCountOfDefaultOptions (itemsObj)
            {
                var defaults = jQuery.map(itemsObj, function (n, i) {
                    return n['listitemischecked'];
                });
                var count = defaults.length;
                jQuery("#" + idPrefix + "f_" + ctype + "_countDefaultOpts").val(count);
            }
			
			
			function buildItemsObj (itemsObj, idx) {
				var $form = jQuery("#"+ hdnItemListId + " .itemForm").eq(idx);
                var inputs = $form.find("input");
				var itemArr = inputs.serializeArray();
				//create object of items and prittify the array
				var itemObj = {};
				itemObj[idx] = cleanItemArr(itemArr);
				//push item into items array, overwrite item if it already exists
				var newitemsObj = jQuery.extend(itemsObj, itemObj);
				itemsObj = newitemsObj;
				return itemsObj;
			}
			
			function moveItem (idx, up) {
				var last = jQuery("#" + itemListId + " .liItem").length - 1;
				removeArrowClassDisabled (1, true);
				removeArrowClassDisabled (last, false);
				var li = jQuery("#" + itemListId + " .liItem").eq(idx);
				var form = jQuery("#"+ hdnItemListId + " .itemForm").eq(idx);
				if (up) {
					var prevLi = jQuery("#" + itemListId + " .liItem").eq(idx - 1);
					var prevForm = jQuery("#"+ hdnItemListId + " .itemForm").eq(idx - 1);
					li.insertBefore(prevLi);
					form.insertBefore(prevForm);
				}
				else {
					var nextLi = jQuery("#" + itemListId + " .liItem").eq(idx + 1);
					var nextForm = jQuery("#"+ hdnItemListId + " .itemForm").eq(idx + 1);
					li.insertAfter(nextLi);
					form.insertAfter(nextForm);
				}
				setArrowClassDisabled (1, true);
				setArrowClassDisabled (last, false);
				//We have to newly build the images object from all remaining images with correct index
				var itemsObj = {};
				jQuery("#"+ hdnItemListId + " .itemForm").each(function (idx, el) {
                    if (idx > 0)
                    {
                        itemsObj = buildItemsObj (itemsObj, idx);
                    }
				});
				//Stingify images object and set the string as value in itemsDB field (so that it will be stored in database, when module is saved)
				var itemsStr = createItemsStr(itemsObj);
				setItemsStr (itemsStr);
			}
            
            function getCType () {
                var leftTrimmed = settings.params.fieldName.replace("f_", "");
                var ctype = leftTrimmed.replace("_list_hidden", "");
                return ctype;
            }
            
            //create a li as table header of option list
            function createListHeader ()
            {
                jQuery("<li/>", {
                    "class" : "listHeader liItem"
                }).appendTo("#" + itemListId);
                jQuery("<span/>", {                   
                }).appendTo("#" + itemListId + " .listHeader");
                jQuery("<span/>", {                   
                }).appendTo("#" + itemListId + " .listHeader");
                jQuery("<span/>", {  
                    "class" : "headerValue",
                    text: settings.texts.txtValue
                }).appendTo("#" + itemListId + " .listHeader");
                jQuery("<span/>", {  
                    "class" : "headerLabel",
                    text: settings.texts.txtLabel
                }).appendTo("#" + itemListId + " .listHeader");
                jQuery("<span/>", {  
                    "class" : "headerDefault",
                    text: settings.texts.txtDefault
                }).appendTo("#" + itemListId + " .listHeader");
                jQuery("<span/>", {                   
                }).appendTo("#" + itemListId + " .listHeader");
                jQuery("<span/>", {                   
                }).appendTo("#" + itemListId + " .listHeader");
            }
            
            function  createEmptyDivInFormContainer()
            {
                jQuery("<div/>", {   
                    "style" : "display: none;",
                   "class" : "itemForm"
                }).appendTo("#" + hdnItemListId);
            }
			//End helper functions
			
			// We create button Templates via php (to get translated button texts)
			// Move button template to the bottom of the page
			//jQuery("#buttonMasters").appendTo("body");
			            
            jQuery("<div/>", {
                "id" : itemListContId
            }).insertBefore("#" + dbFieldName);
            
            jQuery("<ul/>", {
                "id" : itemListId
            }).appendTo("#" + itemListContId);
            
            jQuery("<a/>", {
                "id" : addButtonId,
                "class" : "btn",
                "href" : "#",
                text : settings.texts.txtCreateItem
            }).insertAfter("#" + itemListId);
            
            //Create container for hidden forms
			jQuery("<div/>", {
				"id" : hdnItemListId,
			}).insertAfter("#" + itemListContId);
            
            createListHeader();
            createEmptyDivInFormContainer();
			
			// Add existing li's to itemList and hidden image list
			if (jQuery("#" + dbFieldName).val() != "") {
				var itemsObj = getItemsObj();
				jQuery.each(itemsObj, function (i, o) {
                    //create empty list item
					var li = createListItem();
					//create html elements in list item
					createListItemElements(i);
					//get property
                    jQuery.each(hdnMFldNames, function (index, value) {
                        var text = getListItem(i, value);
                        //property in list item
                        setListItemValue(text, i);
                    });
					
					//create popup form element
					var form = createHiddenForm(i);
					//set values in Form element
					setValuesInHiddenForm(i);
					// hide addItem button in form
					form.find("a.addItem").hide();
					form.find("a.newItemClose").hide();

				});
				//set class disabled on peripheral arrows in last li
				setArrowClassDisabled (1, true);
				setArrowClassDisabled (jQuery("#" + itemListId + " .liItem").length - 1, false);
			}
			
			// add event listener
			
			// Add new item to list
			jQuery("#add" + ctype).on("click", function () {
				var idx = 0;
				var $itemList = jQuery("#" + itemListId + " .liItem"); 
				if ($itemList.length) {
					idx = $itemList.length;
				}
				// create empty img list item to use for positioning popup form
				var li = createListItem();
				//create html elements in list item
				createListItemElements(idx);
				//create empty form
				var form = createHiddenForm(idx);
                //set list item id in form
                //get highest used id
                var lastItemId = getLastItemId();
                form.find(".listitemid input").val(lastItemId);
				//hide default save, close and reset button in form
				form.find("a.saveForm").hide();
				form.find("a.resetForm").hide();
				form.find("a.closeForm").hide();
				//give form a position which is needed when showing form in a popup
				//var position = li.position();
				setFormPosition(li, idx);
				//show form
				form.show();				
			});
			
			//Form Button events			
			// add button in form popup ("Save button for saving new image/article for the first time)
			jQuery("#" + hdnItemListId).on("click", "a.addItem", function (e){
				var $form = jQuery(this).parents(".itemForm");
                //check that required fields contain a value
                if ( checkRequiredFields($form) == false)
                {
                    e.preventDefault();
                    return false;
                }
				// save data in form in hidden input field and hide form
				saveForm($form);
                //update pointer with highest used item id
                setLastItemId();
				//get form index
				var idx = $form.index();
                //get add user inputs to visible list item
                jQuery.each(hdnMFldNames, function (index, value) {
                    var text = getListItem(idx, value);
                    //property in list item
                    setListItemValue(text, idx);
                });
                
                //disable arrow up in first element
                if (idx == 1) {
					setArrowClassDisabled (idx, true);
				}
                
				//we have a new last element in image list, so remove class disabled on previous list item
				if (idx > 0) {
					removeArrowClassDisabled (idx - 1, false);
				}
				//Disable arrow down on new = last element
				setArrowClassDisabled (idx, false);
				// hide a.addItem
				jQuery(this).hide();
				//hide a.newItemClose
				$form.find("a.newItemClose").hide();
				// show a.saveForm and a.resetForm button for use of hdnForm
				$form.find("a.saveForm").show();
				$form.find("a.resetForm").show();
				$form.find("a.closeForm").show();
				//hide the popup form
				$form.hide();
			});
			
			jQuery("#" + hdnItemListId).on("click", "a.newItemClose", function (e){
				var $form = jQuery(this).parents(".itemForm");
				var idx = $form.index();
				//Remove form and list element from HTML
				delItemElements(idx);
			});
			
			// close buttons in form popup
			jQuery("#" + hdnItemListId).on("click", "a.closeForm", function (e){
				var $form = jQuery(this).parents(".itemForm");
				var idx = $form.index();
				//reset values in Form element
				setValuesInHiddenForm(idx);
                removeClassError($form);
				$form.hide();
			});
			
			// reset button in form popup
			jQuery("#" + hdnItemListId).on("click", "a.resetForm", function (e){
				var $form = jQuery(this).parents(".itemForm");
				var idx = $form.index();
				//set values in Form element
				setValuesInHiddenForm(idx);
                removeClassError($form);
			});
			
			// save button in form popup
			jQuery("#" + hdnItemListId).on("click", "a.saveForm", function (e){
				var $form = jQuery(this).parents(".itemForm");
                //check that required fields contain a value       
                if (checkRequiredFields($form) == false)
                {
                    e.preventDefault();
                    return false;
                }
				saveForm($form);
				var idx = $form.index();
                //remove old values in list
                removeListItemValues(idx);
				//set new values in list
                //get property
                jQuery.each(hdnMFldNames, function (index, value) {
                    var text = getListItem(idx, value);
                    //property in list item
                    setListItemValue(text, idx);
                });
                removeClassError($form);
				$form.hide();
				
			});
			
			//List link events
			
			// link itemUp
			jQuery("#" + itemListId).on("click", "a.itemUp", function (e) {
				var li = jQuery(this).parents(".liItem");
				var idx = li.index();
				if (idx == 0) {
					return;
				}
				else {
					moveItem(idx, true);
				}
			});
			
			// link itemDown
			jQuery("#" + itemListId).on("click", "a.itemDown", function (e) {
				var li = jQuery(this).parents(".liItem");
				var idx = li.index();
				var last = jQuery("#" + itemListId + " .liItem").length - 1;
				if (idx == last) {
					return;
				}
				else {
					moveItem(idx, false);
				}
			});
			
			// link (image name) and link "Change" in image list
			jQuery("#" + itemListId).on("click", "a.itemChange", function (e) {
				var li = jQuery(this).parent();
				var idx = li.index();
                setFormPosition(li, idx);
				jQuery("#"+ hdnItemListId + " .itemForm").eq(idx).show();
			});
			
			// link "Delete" in image list
			jQuery("#" + itemListId).on("click", "a.itemRemove", function (e) {
				var li = jQuery(this).parent();
				var idx = li.index();
				//remove class disable on arrows in first and last list item
				removeArrowClassDisabled (1, true);
				removeArrowClassDisabled (jQuery("#" + itemListId + " .liItem").length - 1, false);
				//Remove form and list element from HTML
				delItemElements(idx);
				//set class disabled on arrows in first and last list item in new list
				setArrowClassDisabled (1, true);
				setArrowClassDisabled (jQuery("#" + itemListId + " .liItem").length - 1, false);
				//We have to newly build the images object from all remaining images with correct index
				var itemsObj = {};
				jQuery("#"+ hdnItemListId + " .itemForm").each(function (i, el) {
                    if (i > 0)
                    {
                        itemsObj = buildItemsObj (itemsObj, i);
                    }
				});
				//Stingify images object and set the string as value in itemsDB field (so that it will be stored in database, when module is saved)
				var itemsStr = createItemsStr(itemsObj);
				setItemsStr (itemsStr);
			});           
			
			//Window resize
			jQuery( window ).resize(function() {
				jQuery("#"+ hdnItemListId + " .itemForm").each( function (i, el) {
                    if (i > 0)
                    {
                        var li = jQuery("#" + itemListId + " .liItem").eq(i);
                        setFormPosition(li, i);
                    }
				});
			});
		}
	});
}(jQuery));