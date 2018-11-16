<div class="PageHeader">Публикация новой фотографии</div>
<div class="WhiteBlock VerticalSpaces">
	<div>
		<form id="bigd-construction-form">
			<input type="hidden" name="" value="0">
			<div class="data-box-choose-photo">
				<div id="flag-thumb-preview" class="data-thumbnail-preview" style="background-image: url('/res/ui/no-photo-big.png');"></div>
				<div class="FileForm" p-action="setPreview('#flag-thumb-preview', this);" p-name="p_file" p-accept="image/jpeg,image/png"></div>
			</div>
			<div class="data-box-field">
				<div class="input-placeholder">Месяц</div>
				<input type="text" name="p_month" placeholder="по умолчанию - <?=date('n')?>">
			</div>
			<div class="data-box-field">
				<div class="input-placeholder">Год</div>
				<input type="text" name="p_year" placeholder="по умолчанию - <?=date('Y')?>">
			</div>
		</form>
	</div>
	
	<div class="field-space"></div>

	<div class="data-box-field">
		<a class="ui-mypanel-link" href="?act=bigd/construction" onclick="return send_new();">Добавить</a>
	</div>
</div>

<div class="PageHeader">Список фотографий</div>
<div class="WhiteBlock VerticalSpaces">

	<?$crntYear = '';
	$crntMon = '';
	foreach ($construction_pics AS $v) {?>
	
	<?if ($crntMon != $v['month'] && $crntMon != '') echo '</div>';?>
	
	<?if ($crntYear != $v['year']) {
	$crntYear = $v['year'];?><div class="construction-time-head"><?=$v['year']?></div><?}
	if ($crntMon != $v['month']) {
	$crntMon = $v['month'];?>
	
	<div class="construction-time-head"><?=GetMonthName($v['month'])?></div>
	<div class="items-listing">
	
	<?}?>
	
		<div class="listing-item">
			<div class="construction-details">
				<div class="construction-details-wrap">
					<div class="c-d-image" style="background-image: url('/images/construction-progress/<?=$v['thumbnail_path']?>');"></div>
					<div class="right-side-controls">
						<div>
							<a href="/images/construction-progress/<?=$v['photo_path']?>" target="_blank">Открыть в полном размере</a>
							<a href="?act=bigd/construction/remove/<?=$v['id']?>" class="red-sense" onclick="return removePost(this);">Удалить</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	<?}?>

	</div>
</div>

<script>
function upload_new(id, input) {
	var file = input.files[0];
	if (!file) {
		console.log('No file selected.');
		return false;
	}
	console.log(file);
	var formData = new FormData();
	formData.append('pic', file, file.fileName);
	formData.append('item_id', id);
	var ajax = new XMLHttpRequest();
	ajax.open('POST', '?act=bigd/construction/add');
//	ajax.setRequestHeader('Content-Type', 'multipart/form-data; charset=utf-8; boundary=' + Math.random().toString().substr(2));
	ajax.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	ajax.setRequestHeader("X-File-Name", file.name);
	ajax.setRequestHeader("X-File-Size", file.size);
	ajax.setRequestHeader("X-File-Type", file.type);
	ajax.timeout = 3140;
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			console.log(ajax.responseText);
		//	location.href = '?act=bigd/construction';
		}
	};
	ajax.send(formData);
}

function send_new() {
	let mw = '?act=bigd/construction/post';
	mr.SendForm(mw, '#bigd-construction-form', function(r) {
		location.href = '?act=bigd/construction';
	//	console.log(r);
	});
	return false;
}

function setPreview(preview_container, input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
			mr.Dom(preview_container).Object.style.backgroundImage = 'url(' + e.target.result + ')';
		}
		
		reader.readAsDataURL(input.files[0]);
	}
}

function removePost(el) {
	mr.Query(el.getAttribute('href'), {}, function(r) {
		location.href = '?act=bigd/construction';
	});
	return false;
}
</script>