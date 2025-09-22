<?php 
global $current_user;
$CaoUser = new CaoUser($current_user->ID);
$wp_create_nonce = wp_create_nonce('caoclick-' . $current_user->ID);
?>

<div class="form-holder has-shadow">
	<div class="row">
		<div class="col-lg-6">
			<div class="info d-flex align-items-center">
				<div class="content">
					<div class="logo">
						<img src="<?php echo _get_user_avatar_url('qq')?>">
						<h1>欢迎回来，<?php echo $current_user->nickname;?>！</h1>
					</div>
					<p>请完善邮箱信息，以便修改密码和接收订单信息</p>
				</div>
			</div>
		</div>

		<div class="col-lg-6 bg-white">
			<div class="form d-flex align-items-center">
				<div class="content">
					<form class="mb-0">
						<div class="form-group">
							<input type="email" name="user_email" id="user_email" placeholder="请输入常用邮箱" value="" class="input-material">
							<input type="hidden" name="email" id="email" value="">
						</div>
						<?php if (_cao('is_user_bang_email')): ?>
						<div class="form-group">
							<input type="text" name="captcha" id="captcha" value="" placeholder="输入邮箱验证码" class="input-material">
							<input type="hidden" name="edit_email_cap" id="edit_email_cap" value="">
							<button class="btn edit_email_cap" type="button">发送</button>
                    	</div>
						<?php endif; ?>
						<button type="button" etap="submit_info" class="button">保存</button>
					</form>
				</div>
			</div>
		</div>
		
	</div>
</div>

<script>
	$(".edit_email_cap").on("click",function(){
		var a = $("input[name='user_email']").val();
		$("input[name='email']").val(a);
	});
	$('[etap="submit_info"]').on('click', function(){
		var b = $("input[name='captcha']").val();
		$("input[name='edit_email_cap']").val(b);
	});
</script>