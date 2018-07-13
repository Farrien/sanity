<?
unset($_SESSION);
setcookie("lgn", "", time() - 360000, '/');
setcookie("pw", "", time() - 360000, '/');
session_destroy();
?>
<script type="text/javascript">
    window.location = "//<?=$_SERVER['HTTP_HOST']?>/";
</script>