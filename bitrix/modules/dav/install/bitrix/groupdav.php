<?
define("STOP_STATISTICS", true);
define("STOP_WEBDAV", true);
define("NOT_CHECK_PERMISSIONS", true);
define('NO_AGENT_CHECK', true);
define("DisableEventsCheck", true);

if (
	isset($_REQUEST["help"])
	&& (
		$_REQUEST["help"] === "Y"
		|| $_REQUEST["help"] === "y"
	)
)
{
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/dav/help.php");
	die();
}

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("dav");

CDav::Report(
	"<<<<<<<<<<<<<< REQUEST >>>>>>>>>>>>>>>>",
	"\n".print_r([
		"REQUEST_METHOD" => $_SERVER["REQUEST_METHOD"] ?? null,
		"REQUEST_URI" => $_SERVER["REQUEST_URI"] ?? null,
		"PATH_INFO" => $_SERVER["PATH_INFO"] ?? null,
		"HTTP_DEPTH" => $_SERVER["HTTP_DEPTH"] ?? null,
		"AUTH_TYPE" => $_SERVER["AUTH_TYPE"] ?? null,
		"PHP_AUTH_USER" => $_SERVER["PHP_AUTH_USER" ] ?? null
	], true)."\n",
	"UNDEFINED",
	true
);

CDav::ProcessRequest();

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>