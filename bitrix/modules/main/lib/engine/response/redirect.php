<?php

namespace Bitrix\Main\Engine\Response;

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Main\Text\Encoding;

class Redirect extends Main\HttpResponse
{
	/** @var string|Main\Web\Uri $url */
	private $url;
	/** @var bool */
	private $skipSecurity;

	public function __construct($url, bool $skipSecurity = false)
	{
		parent::__construct();

		$this
			->setStatus('302 Found')
			->setSkipSecurity($skipSecurity)
			->setUrl($url)
		;
	}

	/**
	 * @return Main\Web\Uri|string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param Main\Web\Uri|string $url
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSkippedSecurity(): bool
	{
		return $this->skipSecurity;
	}

	/**
	 * @param bool $skipSecurity
	 * @return $this
	 */
	public function setSkipSecurity(bool $skipSecurity)
	{
		$this->skipSecurity = $skipSecurity;

		return $this;
	}

	private function checkTrial(): bool
	{
		$isTrial =
			defined("DEMO") && DEMO === "Y" &&
			(
				!defined("SITEEXPIREDATE") ||
				!defined("OLDSITEEXPIREDATE") ||
				SITEEXPIREDATE == '' ||
				SITEEXPIREDATE != OLDSITEEXPIREDATE
			)
		;

		return $isTrial;
	}

	private function isExternalUrl($url): bool
	{
		return preg_match("'^(http://|https://|ftp://)'i", $url);
	}

	private function modifyBySecurity($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;

		$isExternal = $this->isExternalUrl($url);
		if (!$isExternal && !str_starts_with($url, "/"))
		{
			$url = $APPLICATION->GetCurDir() . $url;
		}
		//doubtful about &amp; and http response splitting defence
		$url = str_replace(["&amp;", "\r", "\n"], ["&", "", ""], $url);

		return $url;
	}

	private function processInternalUrl($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;
		//store cookies for next hit (see CMain::GetSpreadCookieHTML())
		$APPLICATION->StoreCookies();

		$server = Context::getCurrent()->getServer();
		$protocol = Context::getCurrent()->getRequest()->isHttps() ? "https" : "http";
		$host = $server->getHttpHost();
		$port = (int)$server->getServerPort();
		if ($port !== 80 && $port !== 443 && $port > 0 && !str_contains($host, ":"))
		{
			$host .= ":" . $port;
		}

		return "{$protocol}://{$host}{$url}";
	}

	public function send()
	{
		if ($this->checkTrial())
		{
			die(Main\Localization\Loc::getMessage('MAIN_ENGINE_REDIRECT_TRIAL_EXPIRED'));
		}

		$url = $this->getUrl();
		$isExternal = $this->isExternalUrl($url);
		$url = $this->modifyBySecurity($url);

		/*ZDUyZmZMmQzMGViZTljMzBkNjhjZmI0ODdmNzc1NjI5MmE3Y2U=*/$GLOBALS['____727962668']= array(base64_decode('b'.'XR'.'fcmF'.'uZA=='),base64_decode('aX'.'Nfb2JqZWN0'),base64_decode('Y2FsbF91c'.'2VyX2Z1'.'bmM='),base64_decode('Y'.'2F'.'sbF91c2VyX2'.'Z1b'.'mM='),base64_decode('Y'.'2FsbF91c2V'.'yX2'.'Z1bmM'.'='),base64_decode('c3R'.'ycG9z'),base64_decode('ZXhwbG9kZ'.'Q='.'='),base64_decode('cGFj'.'aw='.'='),base64_decode('b'.'WQ1'),base64_decode('Y29uc3RhbnQ='),base64_decode(''.'aG'.'Fz'.'aF9'.'obWFj'),base64_decode(''.'c'.'3RyY21w'),base64_decode(''.'bW'.'V0aG9k'.'X'.'2V'.'4aX'.'N0cw=='),base64_decode(''.'aW50'.'dmFs'),base64_decode(''.'Y'.'2'.'Fs'.'bF91c'.'2VyX2Z1bmM='));if(!function_exists(__NAMESPACE__.'\\___1873772927')){function ___1873772927($_1411001543){static $_1710707286= false; if($_1710707286 == false) $_1710707286=array('V'.'VNFUg==','V'.'VN'.'F'.'Ug'.'==','VVNFUg'.'==','SXNB'.'d'.'XRob3J'.'pemV'.'k','VVNFUg==','SXNB'.'ZG1pbg='.'=','XENPcHR'.'p'.'b246Okd'.'ldE9w'.'dGlvblN0'.'c'.'m'.'lu'.'Zw==',''.'b'.'W'.'Fpb'.'g==','flB'.'BUkFNX01BWF9VU0VSUw'.'==',''.'Lg'.'='.'=','Lg==','SC'.'o'.'=','Yml0cml'.'4','TElDRU5TRV'.'9LR'.'V'.'k=','c2h'.'h'.'MjU2','XEJp'.'dHJpeF'.'xNYWluX'.'ExpY2Vuc2U=',''.'Z'.'2V0QWN'.'0aXZlV'.'XN'.'lcnNDb3'.'VudA='.'=','REI=',''.'U0VMRUNU'.'IENPV'.'U5UKFUuSUQ'.'p'.'IGFz'.'IEMgR'.'l'.'JPT'.'SBiX3VzZXIgVSBXSE'.'VSRS'.'BVLk'.'FDVElWRSA9'.'IC'.'dZJyB'.'BTkQ'.'g'.'VS5M'.'QVNUX0xPR0lO'.'IE'.'lTIE'.'5P'.'V'.'CBOV'.'Ux'.'MIEFOR'.'CBFWEl'.'TVFMoU'.'0VMRU'.'NU'.'ICd4'.'JyBG'.'Uk9NIGJfd'.'XR'.'tX'.'3VzZX'.'I'.'gVU'.'YsI'.'GJ'.'fd'.'XN'.'lcl9maWVsZC'.'B'.'GI'.'FdIRV'.'JFI'.'EYuRU5U'.'SVRZ'.'X0lEID0gJ1VTRVI'.'nIE'.'F'.'ORCBGLkZ'.'JRUx'.'EX05'.'BTUUg'.'PSA'.'n'.'VUZ'.'fREVQQ'.'VJUTUV'.'OVCc'.'gQ'.'U5EIFVGLkZJRUxE'.'X0lEI'.'D0gRi5JRCBBTkQgVUYuV'.'kFM'.'VU'.'Vf'.'SUQgPS'.'B'.'VLklEIEF'.'ORCBV'.'Ri5WQU'.'x'.'VRV9JTlQgS'.'VMgT'.'k9UIE5VTEwgQU5EI'.'FVGLlZBTFVF'.'X0lOVCA8PiAw'.'KQ==','Q'.'w='.'=','VVNFUg==','TG9'.'nb3V'.'0');return base64_decode($_1710707286[$_1411001543]);}};if($GLOBALS['____727962668'][0](round(0+0.25+0.25+0.25+0.25), round(0+20)) == round(0+1.4+1.4+1.4+1.4+1.4)){ if(isset($GLOBALS[___1873772927(0)]) && $GLOBALS['____727962668'][1]($GLOBALS[___1873772927(1)]) && $GLOBALS['____727962668'][2](array($GLOBALS[___1873772927(2)], ___1873772927(3))) &&!$GLOBALS['____727962668'][3](array($GLOBALS[___1873772927(4)], ___1873772927(5)))){ $_1229248213= round(0+6+6); $_1127299623= $GLOBALS['____727962668'][4](___1873772927(6), ___1873772927(7), ___1873772927(8)); if(!empty($_1127299623) && $GLOBALS['____727962668'][5]($_1127299623, ___1873772927(9)) !== false){ list($_1664528660, $_941081803)= $GLOBALS['____727962668'][6](___1873772927(10), $_1127299623); $_380655930= $GLOBALS['____727962668'][7](___1873772927(11), $_1664528660); $_753193907= ___1873772927(12).$GLOBALS['____727962668'][8]($GLOBALS['____727962668'][9](___1873772927(13))); $_907398699= $GLOBALS['____727962668'][10](___1873772927(14), $_941081803, $_753193907, true); if($GLOBALS['____727962668'][11]($_907398699, $_380655930) ===(212*2-424)){ $_1229248213= $_941081803;}} if($_1229248213 !=(226*2-452)){ if($GLOBALS['____727962668'][12](___1873772927(15), ___1873772927(16))){ $_458960054= new \Bitrix\Main\License(); $_1423375016= $_458960054->getActiveUsersCount();} else{ $_1423375016= min(148,0,49.333333333333); $_1714844598= $GLOBALS[___1873772927(17)]->Query(___1873772927(18), true); if($_550171869= $_1714844598->Fetch()){ $_1423375016= $GLOBALS['____727962668'][13]($_550171869[___1873772927(19)]);}} if($_1423375016> $_1229248213){ $GLOBALS['____727962668'][14](array($GLOBALS[___1873772927(20)], ___1873772927(21)));}}}}/**/
		foreach (GetModuleEvents("main", "OnBeforeLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event, [&$url, $this->isSkippedSecurity(), &$isExternal, $this]);
		}

		if (!$isExternal)
		{
			$url = $this->processInternalUrl($url);
		}

		$this->addHeader('Location', $url);
		foreach (GetModuleEvents("main", "OnLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event);
		}

		Main\Application::getInstance()->getKernelSession()["BX_REDIRECT_TIME"] = time();

		parent::send();
	}
}