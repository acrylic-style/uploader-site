<?php
function endsWith($haystack, $needle) {
  return (strrpos($haystack, $needle) === strlen($haystack) - strlen($needle));
}
require_once("config.php");
//if($_POST['p'] == "force-uploading") { $blocked = false; $_POST['p'] = ""; }
if($blocked) {
?>
<!DOCTYPE HTML>
<html>
<head>
<title>
使用制限
</title>
</head>
<body>
<?=$blocked_msg;?>
<br />
<br />
<a href="/">〉ここから戻る</a>
</body>
</html>
<?php
exit();
}
?>
<?php
$get = $_REQUEST['report'];
ini_set("display_errors", "On");
error_reporting(E_ALL);
if($get == "true") {
ini_set("display_errors", "On");
error_reporting(E_ALL);
}
ini_set("display_errors", "Off");
$rand = "";
for($i = 1; $i <= 8; $i++) {
    $rand .= rand(0,10);
}
if (isset($_SERVER["HTTP_CF-Connecting-IP"])) {
 $_SERVER["REMOTE_ADDR"] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}
$remoteip = $_SERVER['REMOTE_ADDR'];
$rhraw = $remoteip."/".$rand;
$rh = preg_replace("/\./", "", $rhraw);
global $rh;
$path = "./../ups/".$rh;
if(!file_exists($path)) {
  mkdir($path, 0777, true);
}
$uploadname = mb_ereg_replace(" ", "_", $_FILES["upfile"]["name"]);

if (endsWith($uploadname, '.php')) {
  die("<script>location.href=\"https://upload.acrylicstyle.xyz/index.html#notspecified\"</script>");
} elseif (endsWith($uploadname, '.aspx')) {
  die("<script>location.href=\"https://upload.acrylicstyle.xyz/index.html#notspecified\"</script>");
}
//$uploaded = "<a href=\"https://u.rht0910.tk/dl.php/".$rh."/".$uploadname."\">".$uploadname."</a>";
//$uploaded2 = "<a href=\"https://um.rht0910.tk/dl.php/".$rh."/".$uploadname."\">".$uploadname."</a>";
if($_POST['p'] == "image") {
  $uploaded = "https://img.acrylicstyle.xyz/upload/".$rh."/".$uploadname;
  $uploaded2 = "https://img.acrylicstyle.xyz/upload/".$rh."/".$uploadname;
//  $uploaded2 = "<a href=\"https://img.acrylicstyle.tk/upload/".$rh."/".$uploadname."\">".$uploadname."</a>";
} else {
  $uploaded = $rh."/".$uploadname;
  $uploaded2 = $rh."/".$uploadname;
}
$matched = 0;
$uploadto = "./../ups/$rh/" . $uploadname;
require_once("password.php");
if(!empty($_POST['p'])) {
	foreach($passwords as $key => $value) {
		if($_POST['p'] == $key) {
			$dir = $value;
			$uploadto = $value.$uploadname;
			if(!file_exists($dir)) {
 			   mkdir($dir, 0777, true);
			}
			$matched = 2;
		} else {
			if($matched != 2) {
				$matched = 1;
			}
		}
	}
}
if($matched == 1) {
	echo "パスワードが正しくありません。";
	exit;
} elseif($matched == 0) {
	$uploadto = "./../ups/$rh/" . $uploadname;
	$dir = "./../ups/".$rh."/";
}
unset($key);

if(file_exists("./../ups/".$rh."/".$uploadname)) {
  unlink("/extended/root/var/www/ups/".$rh."/".$uploadname);
}
//die($_FILES["upfile"]["tmp_name"]); // todo: for debug
if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
  if (move_uploaded_file($_FILES["upfile"]["tmp_name"], $uploadto)) {
    if($_FILES["upfile"]["error"] === UPLOAD_ERR_OK) {
      if ($_POST["type"] === "json") {
        if($_POST['p'] == "image") { echo $uploaded; exit; }
        echo "https://um.acrylicstyle.xyz/".$uploaded;
        exit;
      }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>
アップロード状況
</title>
<link rel="stylesheet" href="base.css" type="text/css">
<body class="font">
<?php
      echo "<script>console.log(\"done. redirecting to https://upload.acrylicstyle.xyz/index.html#".$uploaded."\")</script>";
      echo "<script>location.href=\"https://upload.acrylicstyle.xyz/index.html#".$uploaded."\"</script>";
      //echo "アップロード#1：". $uploaded2 . " (" . $uploaded . ") をアップロードしました(パスワードを入れた場合はURLは利用できません)。<br />";
?>
<p>URLを短縮したい場合は、上のURLをコピーして、<a href="https://asyn.cf">https://asyn.cf</a>をご利用ください。</p>
<?php
      chmod($dir, 0777);
    } else {
      echo "<script>location.href=\"https://upload.acrylicstyle.xyz/index.html#error\"</script>";
    }
  } else {
    echo "<script>location.href=\"https://upload.acrylicstyle.xyz/index.html#error\"</script>";
  }
} else {
  echo "<script>location.href=\"https://upload.acrylicstyle.xyz/index.html#notspecified\"</script>";
}
?>
<br /><a href="/">続けてアップロード</a>
</body>
</html>
