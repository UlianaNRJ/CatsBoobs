<div id="upload_dialog">
	<div id="loading"></div>
	<div id="status"></div>
	<form id="upload_form" class="c" action="{$this->getSecureWebUrl('common/index-post')}" style="overflow: hidden;" method="post"  enctype="multipart/form-data">
		<input type="hidden" value="1048576" name="MAX_FILE_SIZE">
		<div class="ib" id="cats">
			<div class="title">Котики</div>
			<button>Загрузить файл</button>
			<input type="file" name="files[cats]" value="" accept="image/jpeg,image/png,image/gif">
			<div class="note">Максимальный размер файла: 1 Мб</div>
			<div class="name"></div>
			<div class="size"></div>

			<div class="error"></div>
		</div>
		<div class="ib" id="boobs">
			<div class="title">Сиськи</div>
			<button>Загрузить файл</button>
			<input type="file" name="files[boobs]" value="" accept="image/jpeg,image/png,image/gif">
			<div class="note">Максимальный размер файла: 1 Мб</div>
			<div class="name"></div>
			<div class="size"></div>
			<div class="error"></div>
		</div>
	</form>
</div>