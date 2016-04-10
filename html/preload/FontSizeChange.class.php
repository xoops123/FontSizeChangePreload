<?php
/**
 * @file FontSizeChange.class.php
 * @package For legacy Cube Legacy 2.2
 * @version $Id: FontSizeChange.class.php ver0.01 2012/12/27  00:00:00 marine  $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class FontSizeChange extends XCube_ActionFilter
{
	public function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('Site.JQuery.AddFunction',array(&$this, 'addScript'));
	}

	public function addScript(&$jQuery)
	{
		$jQuery->addStylesheet('/common/FontSizeChange/FontSizeChange.css', true);
		$jQuery->addLibrary('/common/FontSizeChange/jquery.cookie.js', true);
   	$jQuery->addScript('
			jQuery(\'<div id="FontSizeChange"><div id="zf">zoom</div><div id="df">default</div></div>\').appendTo(\'body\');
			jQuery(document).ready(function() {
				var boxID = "#FontSizeChange";
				var maxValue = 30;
				var zoomValue = 2;
				var cookieName = "my_font_size";
				var defaultFont = jQuery("body").css("font-size");
				//フローティングボックス設定
				jQuery(boxID).mousedown(function(e){
					jQuery(boxID)
						.data("clickPointX" , e.pageX - jQuery(boxID).offset().left)
						.data("clickPointY" , e.pageY - jQuery(boxID).offset().top);
					jQuery(document).mousemove(function(e){
						jQuery(boxID).css({
							top:e.pageY  - jQuery(boxID).data("clickPointY")+"px",
							left:e.pageX - jQuery(boxID).data("clickPointX")+"px"
						})
					})
				}).mouseup(function(){
					jQuery(document).unbind("mousemove")
				});
				//文字サイズデフォルト
				jQuery("#df").click(function () {
				        jQuery("body").css("font-size", defaultFont);
				        jQuery.cookie(cookieName, defaultFont, {
				                path: \'/\',
				                expires: 365
				        });
				        return false;
				});
				jQuery("body").css("font-size", jQuery.cookie(cookieName));
				//文字サイズズームアップ
				jQuery("#zf").click(function () {
				        var zoomFont = parseInt((jQuery("body").css("font-size")).replace(/px/, ""));
				        if (zoomFont != maxValue) {
				                zoomFont += zoomValue;
				        }
				        jQuery("body").css("font-size", zoomFont + "px");
				        jQuery.cookie(cookieName, zoomFont + "px", {
				                path: \'/\',
				                expires: 365
				        });
				        return false;
				});
			});
		');
	}
//class END
}
?>
