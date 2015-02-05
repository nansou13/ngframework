<?php
class Browser
{
	static private $platform = array
	(
        'Win32' => 'win32',
        'Winnt' => 'winnt',
        'Win2000' => 'win2k',
        'WinXP' => 'winxp',
        'WinME' => 'winme',
        'Win2003' => 'win2k3',
        'Win7' => 'win7',
		'WinVista' => 'vista',
		'MacOSX' => 'macosx',
        'iPhone OSX' => 'iphone',
		'Linux' => 'linux',
        'FreeBSD' => 'frbsd',
        'OpenBSD' => 'opbsd',
        'SunOS' => 'sunos',
		'WAP' => 'wap', // Pour la psp !
        'Android' => 'andrd',
        'Bada' => 'bada',
		'Unknown' => 'nok'
	);

	static private $browser = array
	(
		'IE' => 'ie',
		'Firefox' => 'frfox',
        'Mozilla' => 'moz',
		'Opera' => 'opera',
		'Safari' => 'sfri',
        'Chrome' => 'chrm',
        'Konqueror' => 'knqr',
		'Playstation' => 'ps',
		'DSi' => 'dsi',
        'Mobile Safari' => 'mobsfri',
        'iPhone' => 'iphone',
        'iPad' => 'ipad',
        'Dolphin' => 'dolphn',
        'Playstation 3' => 'ps3'
	);

	static public function rawDetect()
	{
		return get_browser(null, false);
	}

	static public function Detect($ua = null)
	{
		$infos = get_browser_local(null, true);//get_browser(null, true);
		var_dump($infos,get_cfg_var('browscap'));die();
        //$restClient = &vmeRestClient::singleton(_CHECKIT_REST_URL_.'identify');
        //$brwsr_id = $restClient->getBrowserID(($ua === null)?$_SERVER['HTTP_USER_AGENT']:$ua);
        $family = self::getBrowser(strtolower($infos->browser));
        if ($family)
			$code = $family.'-'.$infos->majorver.'-'.$infos->minorver.'-'.self::getPlatform(strtolower($infos->platform));
		else
        {                        
            $code = 'X';
        }
        $code .= '@'.$brwsr_id;
		return $code;
	}

    static private function getPlatform($info)
    {
        foreach(self::$platform as $key => $val)
            if (strtolower($key) == $info) return $val;
    }

    static private function getBrowser($info)
    {
        foreach(self::$browser as $key => $val)
            if (strtolower($key) == $info) return $val;
    }

    static public function getAllSupportedPlatforms()
    {
        return self::$platform;
    }

    static public function getAllSupportedBrowsers()
    {
        return self::$browser;
    }
}

?>