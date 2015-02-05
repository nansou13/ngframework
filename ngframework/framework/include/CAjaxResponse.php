<?php
class CAjaxResponse
{
    public static function dieResponse($html=null,$js=null){
	die(json_encode(array('html' => $html, 'js' => $js)));
    }

    public static function forward($url) {
	self::dieResponse(null, 'CJAjaxRequest.forward(\''.$url.'\')');
    }

    public static function reload() {
	self::dieResponse(null, 'CJAjaxRequest.reload()');
    }

    public static function dialogMessage($message = null, $fctOk = null) {
		$jsAction = 'CJAjaxRequest.dialogMessage(\''.addslashes(str_replace("\n", "<br/>",$message)).'\'';
		if ($fctOk != null) $jsAction .= ', \''.$fctOk.'\'';
		$jsAction .= ')';
		self::dieResponse(null, $jsAction);
	}

	public static function dialogForSMSSend($message, $url, $fctOk = null ) {
		$jsAction = 'CJAjaxRequest.dialogForSMSSend(\''.$message.'\' , \''.$url.'\'';
		if ($fctOk != null) $jsAction .= ', \''.$fctOk.'\'';
		$jsAction .= ')';
		self::dieResponse(null, $jsAction);
	}

	public static function dialogError() {
		self::dieResponse(null, 'CJAjaxRequest.dialogError()');
	}

	public static function dialogConfirm($message, $fctYes = null, $fctNo = null, $btnYes=null, $btnNo=null) {
		$jsAction = 'CJAjaxRequest.dialogConfirm(\''.$message.'\'';
		if ($fctYes != null) {
			$jsAction .= ', \''.$fctYes.'\'';
		} else {
			$jsAction .= ', \'\'';
		}
		if ($fctNo != null) {
			$jsAction .= ', \''.$fctNo.'\'';
		} else {
			$jsAction .= ', \'\'';
		}
		if ($btnYes != null) {
			$jsAction .= ', \''.$btnYes.'\'';
		} else {
			$jsAction .= ', null';
		}
		if ($btnNo != null) {
			$jsAction .= ', \''.$btnNo.'\'';
		} else {
			$jsAction .= ', null';
		}
		$jsAction .= ')';
		self::dieResponse(null, $jsAction);
	}
}

?>