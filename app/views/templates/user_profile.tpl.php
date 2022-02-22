<main class="content">
	<div class="block page-right_block">
		<?php $this->session->set_flashdata('message', "sdfsdfd"); ?>
		<h4 style="color: green"><?php echo $this->session->flashdata('succes_mesage'); ?></h4>
		<h4 style="color: red"><?php echo $this->session->flashdata('error_mesage'); ?></h4>
		<br/>
		<div class="user-form" id="profil_change_form" action="#">
			<div class="form-field mb-2">
				<label class="form-label" for="form1">Имя</label>
				<input class="form-input" id="form1" type="text" placeholder="Ваше имя" name="first_name" value="<?=$user->first_name?>">
			</div>
			<div class="form-field mb-2">
				<label class="form-label" for="form1">Имя пользователя</label>
				<input class="form-input" id="form1" type="text" placeholder="Имя пользователя" name="username" value="<?=$user->username?>">
			</div>
			<div class="form-field mb-2">
				<label class="form-label" for="form2">Email</label>
				<input class="form-input" id="form2" type="email" placeholder="Ваш email адрес" name="email" value="<?=$user->email?>">
			</div>
			<div class="form-field mb-2">
				<label class="form-label" for="form3">Сменить пароль</label>
				<input style="margin-bottom: 10px" class="form-input" name="old_password" id="form3" type="text" placeholder="Старый пароль">
				<input class="form-input" id="form3" type="text" name="new_password" placeholder="Новый пароль">
			</div>
			<div class="form-field mb-2">
				<div class="form-label">Подписка на персональную email‑рассылку</div>
				<label class="toggler tglr-checked" for="form6">
					<input class="form-input" id="form6" type="checkbox">
					<span class="toggler__runner"></span>
				</label>
			</div>
			<div class="form-field">
				<div class="form-label">Push-уведомления</div>
				<label class="toggler" for="form5">
					<input class="form-input" id="form5" type="checkbox">
					<span class="toggler__runner"></span>
				</label>
			</div>
			<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
			<div class="mt-2">
				<button class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>

	<script>

	$('.page-right_block #profil_change_form button').on('click', function() {

		event.preventDefault();

		var data = {};

		data['first_name'] = $(this).parent().parent().find('input[name=first_name]').val();
		data['username'] = $(this).parent().parent().find('input[name=username]').val();
		data['email'] = $(this).parent().parent().find('input[name=email]').val();
		data['old_password'] = $(this).parent().parent().find('input[name=old_password]').val();
		data['new_password'] = $(this).parent().parent().find('input[name=new_password]').val();
		data['csrf_token'] = $(this).parent().parent().find('input[name=csrf_token]').val();

		$.ajax({
			type: "POST",
			url: "/user/change_profile",
			data: data,
			success: function (response) {
				response = JSON.parse(response);
				if(response.success == 1) {
					location.reload();
				}
			}
		});

	});

	</script>

</main>