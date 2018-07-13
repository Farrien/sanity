<div class="clearFix">
	<div class="clearFix">
		<div class="WhitePaper fixedStyle noShadow" style="margin-bottom: 0;">
			<div class="PageHeader">Обзор</div>
			<div class="floatContainer">
				<div class="fl bs50">
					<div class="littleSpace"></div>
					<div class="ContentOverlay nicePads For3Spoilers" style="background: #f2f2f2;">
						<?foreach ($performerFormList AS $v) {?>
						<div class="Spoiler inList">
							<div class="SpoilerHead">
								<div class="SpoilerTitle">
									<div class="h1"><?=$v['performer_name']?> <?=$v['performer_secondname']?></div>
									<div class="h2"><?=$v['performer_phone']?><br><?=time_elapsed('@' . $v['added_time'])?><?=$v['login']?></div>
								</div>
							</div>
							<div class="hiddenRes">
								<div class="TextPads">
									<div><?=$v['performer_mail']?></div>
									<div style="font-style: italic;">«<?=$v['request_message']?>»</div>
								</div>
							</div>
						</div>
						<?}?>
					</div>
				</div>
				<div class="fl bs30">
				</div>
			</div>
		</div>
	</div>
</div>