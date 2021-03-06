<?php
function ajax(&$object,$params){
	global $modx;

	switch($object->event) {
		case "onSetCommentsOutput":
			if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
				$object->config["html"]["subscribe"] = '<div id="subscribe-'.$object->_idshort.'">'.$object->config["html"]["subscribe"].'</div>';
				$object->config["html"]["moderate"] = '<div id="moderate-'.$object->_idshort.'">'.$object->config["html"]["moderate"].'</div>';
				$object->config["html"]["navigation"] = '<div class="navigation-'.$object->_idshort.'">'.$object->config["html"]["navigation"].'</div>';
				$object->config["html"]["comments"] = '<div id="comments-'.$object->_idshort.'">'.$object->config["html"]["comments"].'</div>';
				$object->config["html"]["count-comments"] = '<span id="count-'.$object->_idshort.'">'.$object->config["html"]["count-comments"].'</span>';
			}
			break;
		case "onSetFormOutput":
			if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
				$object->config["html"]["form"] = '<div id="form-'.$object->_idshort.'">'.$object->config["html"]["form"].'</div>';
			}
			break;
		case "onReturnOutput":
			if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
				$modx->regClientStartupScript('<script type="text/javascript">window.jQuery || document.write(\'<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"><\/script>\');</script>');
				$modx->regClientStartupScript(MODX_BASE_URL.'assets/snippets/jot/js/ajax.js');
				$modx->regClientStartupScript('<script type="text/javascript">jQuery(document).ready(function() { jotAjax("'.$object->_idshort.'"); });</script>');
			}
			else {
				$res = str_replace('onclick="history.go(-1);return false;"','',$object->config["html"]["form"])
					."|!|~|!|". $object->config["html"]["comments"]
					."|!|~|!|". $object->config["html"]["moderate"]
					."|!|~|!|". $object->config["html"]["navigation"]
					."|!|~|!|". $object->config["html"]["subscribe"]
					."|!|~|!|". $object->config["html"]["count-comments"];
				if (isset($_GET["aj".$object->_idshort]) || $object->isPostback) die($res);
			}
			break;
	}
}

?>