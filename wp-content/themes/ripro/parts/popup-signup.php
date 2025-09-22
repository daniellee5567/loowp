<?php
  $logo_regular = _cao( 'site_logo');
  $disable_reg = _cao('close_register');
?>
<div id="popup-signup" class="popup-signup fade" style="display: none;">
    <div class="register-login-modal" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img class="popup-logo" src="<?php echo esc_url( _cao( 'site_logo') ); ?>" data-dark="<?php echo esc_url(_cao( 'site_logo')); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#login" data-toggle="login">登录</a>
                        </li>
                        
                        <li><a href="#signup" data-toggle="signup">注册</a>
                        </li>
                        
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="login">
                            <div class="signup-form-container text-center">
                                <form class="mb-0">
                                    <?php _the_open_oauth_login_btn();?>
                                    <?php if (_cao('is_close_wplogin')) { ?>
                                        <a href="#" class="forget-password">仅开放社交账号登录</a>
                                    <?php }else{ ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="username" placeholder="*用户名或邮箱">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" placeholder="*密码">
                                        </div>
                                        <button type="button" class="go-login btn btn--primary btn--block"><i class="fa fa-bullseye"></i> 安全登录</button> 
                                        <!-- <a href="#" class="forget-password">忘记密码?</a> -->
                                    <?php } ?>
                                </form>
                                <!-- form  end -->
                            </div>
                            <!-- .signup-form end -->
                        </div>
                        <div class="tab-pane fade in" id="signup">
                            <form class="mb-0">
                                <?php _the_open_oauth_login_btn();?>
                                <?php if (_cao('is_close_wpreg')) { ?>
                                    <a href="#" class="forget-password">仅开放社交账号注册</a>
                                <?php }else{ ?>
                                <?php if(!$disable_reg){ ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="user_name" placeholder="输入英文用户名">
                                    </div>
                                    <!-- .form-group end -->
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="user_email" placeholder="绑定邮箱">
                                        <label class="white-mail">(仅支持:<?php echo _cao('white_emails'); ?>)</label>
                                    </div>
                                    <!-- .form-group end -->
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="user_pass" placeholder="密码最小长度为6">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="user_pass2" placeholder="再次输入密码">
                                    </div>
                                    <?php if (_cao('invite_register')) : ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="invite_number" placeholder="请输入注册邀请码(*)"></div><div class="form-group">
                                        <a href="<?php echo _cao('invite_card_url'); ?>" target="_blank">获取注册邀请码</a><br><span  style="color:#FF0000">说明：邀请码在注册后以等额积分的方式存入个人账号的余额里面。</span>
						            </div>
					                <?php endif; ?>
                                    <?php if (_cao('is_email_reg_cap')) : ?>
                                    <div class="form-group">
                                        <div class="input-group">
                                          <input type="text" class="form-control" name="captcha" placeholder="邮箱验证码">
                                          <span class="input-group-btn">
                                            <button class="go-captcha_email btn btn--secondary" type="button">发送验证码</button>
                                          </span>
                                        </div>
                                    </div>
                                    
                                    <?php endif; ?>
                                    <button type="button" class="go-register btn btn--primary btn--block"><i class="fa fa-bullseye"></i> 立即注册</button>
                                
                                <?php }else{ ?>
                                    <a href="/zhuce" class="forget-password121" target="_blank"><i class="fa fa-bullseye"></i>点击查看如何注册？</a>
                                <?php } ?>
                                <?php } ?>
                                
                            </form>
                            <!-- form  end -->
                        </div>
                    </div>
                    <a target="_blank" href="<?php echo esc_url( home_url( '/login?action=lostpassword' ) ); ?>" class="rest-password">忘记密码？</a>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
