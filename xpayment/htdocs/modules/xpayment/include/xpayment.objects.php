<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */

	xoops_load('xoopsformloader');
	include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
	include_once 'formselectplugin.php';
	include_once 'formselectuser.php';
	include_once 'formselectinvoicemode.php';
	include_once 'formselectinvoiceremittion.php';
		
	class XpaymentGroupPermForm extends XoopsGroupPermForm
	{
	    function XpaymentGroupPermForm($title, $modid, $permname, $permdesc, $url = "")
	    {
		    $this->XoopsGroupPermForm($title, $modid, $permname, $permdesc, $url);
	    } 
	    
	    function render()
	    { 
	        // load all child ids for javascript codes
	        foreach (array_keys($this->_itemTree)as $item_id) {
	            $this->_itemTree[$item_id]['allchild'] = array();
	            $this->_loadAllChildItemIds($item_id, $this->_itemTree[$item_id]['allchild']);
	        }
	        $gperm_handler =& xoops_gethandler('groupperm');
	        $member_handler =& xoops_gethandler('member');
	        $glist =& $member_handler->getGroupList();
	        foreach (array_keys($glist) as $i) {
	            // get selected item id(s) for each group
	            $selected = $gperm_handler->getItemIds($this->_permName, $i, $this->_modid);
	            $ele = new XpaymentGroupFormCheckBox($glist[$i], 'perms[' . $this->_permName . ']', $i, $selected);
	            $ele->setOptionTree($this->_itemTree);
	            $this->addElement($ele);
	            unset($ele);
	        } 
	        $tray = new XoopsFormElementTray('');
	        $tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
	        $tray->addElement(new XoopsFormButton('', 'reset', _CANCEL, 'reset'));
	        $this->addElement($tray);
	        $ret = '<h4>' . $this->getTitle() . '</h4>' . $this->_permDesc . '<br />';
	        $ret .= "<form name='" . $this->getName() . "' id='" . $this->getName() . "' action='" . $this->getAction() . "' method='" . $this->getMethod() . "'" . $this->getExtra() . ">\n<table width='100%' class='outer' cellspacing='1' valign='top'>\n";
	        $elements =& $this->getElements();
	        $hidden = '';
	        foreach (array_keys($elements) as $i) {
	            if (!is_object($elements[$i])) {
	                $ret .= $elements[$i];
	            } elseif (!$elements[$i]->isHidden()) {
	                $ret .= "<tr valign='top' align='left'><td class='head'>" . $elements[$i]->getCaption();
	                if ($elements[$i]->getDescription() != '') {
	                    $ret .= '<br /><br /><span style="font-weight: normal;">' . $elements[$i]->getDescription() . '</span>';
	                }
	                $ret .= "</td>\n<td class='even'>\n" . $elements[$i]->render() . "\n</td></tr>\n";
	            } else {
	                $hidden .= $elements[$i]->render();
	            }
	        }
	        $ret .= "</table>$hidden</form>";
	        $ret .= $this->renderValidationJS( true );
	        return $ret;
	    }
	}
	
	class XpaymentGroupFormCheckBox extends XoopsGroupFormCheckBox
	{
	    function XpaymentGroupFormCheckBox($caption, $name, $groupId, $values = null)
	    {
		    $this->XoopsGroupFormCheckBox($caption, $name, $groupId, $values);
	    }
	
	    /**
	     * Renders checkbox options for this group
	     * 
	     * @return string 
	     * @access public 
	     */
	    function render()
	    {
			$ret = '<table class="outer"><tr><td class="odd"><table><tr>';
			$cols = 1;
			foreach ($this->_optionTree[0]['children'] as $topitem) {
				if ($cols > 4) {
					$ret .= '</tr><tr>';
					$cols = 1;
				}
				$tree = '<td valign="top">';
				$prefix = '';
				$this->_renderOptionTree($tree, $this->_optionTree[$topitem], $prefix);
				$ret .= $tree.'</td>';
				$cols++;
			}
			$ret .= '</tr></table></td><td class="even">';
			foreach (array_keys($this->_optionTree) as $id) {
				if (!empty($id)) {
					$option_ids[] = "'".$this->getName().'[groups]['.$this->_groupId.']['.$id.']'."'";
				}
			}
			$checkallbtn_id = $this->getName().'[checkallbtn]['.$this->_groupId.']';
			$option_ids_str = implode(', ', $option_ids);
			$ret .= _ALL." <input id=\"".$checkallbtn_id."\" type=\"checkbox\" value=\"\" onclick=\"var optionids = new Array(".$option_ids_str."); xoopsCheckAllElements(optionids, '".$checkallbtn_id."');\" />";
			$ret .= '</td></tr></table>';
			return $ret;
	    } 
	    
	    function _renderOptionTree(&$tree, $option, $prefix, $parentIds = array())
	    {
		    if($option['id'] > 0):
	        $tree .= $prefix . "<input type=\"checkbox\" name=\"" . $this->getName() . "[groups][" . $this->_groupId . "][" . $option['id'] . "]\" id=\"" . $this->getName() . "[groups][" . $this->_groupId . "][" . $option['id'] . "]\" onclick=\""; 
	        foreach ($parentIds as $pid) {
		        if($pid <= 0) continue;
	            $parent_ele = $this->getName() . '[groups][' . $this->_groupId . '][' . $pid . ']';
	            $tree .= "var ele = xoopsGetElementById('" . $parent_ele . "'); if(ele.checked != true) {ele.checked = this.checked;}";
	        } 
	        foreach ($option['allchild'] as $cid) {
	            $child_ele = $this->getName() . '[groups][' . $this->_groupId . '][' . $cid . ']';
	            $tree .= "var ele = xoopsGetElementById('" . $child_ele . "'); if(this.checked != true) {ele.checked = false;}";
	        } 
	        $tree .= '" value="1"';
	        if (in_array($option['id'], $this->_value)) {
	            $tree .= ' checked="checked"';
	        } 
	        $tree .= " />" . $option['name'] . "<input type=\"hidden\" name=\"" . $this->getName() . "[parents][" . $option['id'] . "]\" value=\"" . implode(':', $parentIds). "\" /><input type=\"hidden\" name=\"" . $this->getName() . "[itemname][" . $option['id'] . "]\" value=\"" . htmlspecialchars($option['name']). "\" /><br />\n";
	        else:
	        $tree .= $prefix . $option['name'] . "<input type=\"hidden\" id=\"" . $this->getName() . "[groups][" . $this->_groupId . "][" . $option['id'] . "]\" /><br />\n";
	        endif;
	        if (isset($option['children'])) {
	            foreach ($option['children'] as $child) {
		            if($option['id'] > 0){
		                array_push($parentIds, $option['id']);
	                }
	                $this->_renderOptionTree($tree, $this->_optionTree[$child], $prefix . '&nbsp;-', $parentIds);
	            }
	        }
	    }
	}
?>