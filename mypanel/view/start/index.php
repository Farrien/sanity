<?# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');?>

<div class="uip-Background" style="background-image: url('/./res/ui/rIH860Hxws4.jpg');">
	<div class="uip-AppsList">
	
	<?$i = 0;
	$first_letter = '';
	foreach ($apps as $v) {
		$fcompare = mb_substr($v['app_name'], 0, 1);
		if ($first_letter != $fcompare) {
			$first_letter = $fcompare;
			echo '<h1>' . $first_letter . '</h1>';
		}
		if ($i == 0) echo '<div class="uip-AppsRow">';
		echo PHP_EOL;?>
		
		<a href="?act=<?=$v['fFlag']?>">
			<div class="uip-AppShortcut <?if(!$v['fFlag']) echo 'disabled';?>">
				<div class="uip-AppIcon" style="background-image: url('/./res/<?=$v['app_icon_img']?>');"></div>
				<div class="uip-AppName"><?=$v['app_name']?></div>
			</div>
		</a>
		
		<?$i++;
		if ($i == 4) {echo '</div>'; $i = 0;}
	}?>
	
	</div>
	<div class="RecentApps">
		
	</div>
</div>