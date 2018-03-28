<?php
IncludesFn::printHeader("Register", "customer-account-create grey");

$language = new Languages;

$bodyText = <<<EOF
<div class="wrap margin-top-clear">
					    
		    <div class="container col1-layout">
				<div class="main">
										<div class="col-main">
						<div class="messages">           
  </div>  						
<div class="customer-login">
        <div class="account-create">
        <div class="page-header">
            <h1>{$language->Translate('create_an_account')}</h1>
        </div>
                        <div class="messages">           
  </div>          <form id="form-validate" data-customer-form="register">
                <div>
                    <input name="form_key" type="hidden" value="6XcTkp4qTqxrd9nf">
                    <input type="hidden" name="success_url" value="">
                    <input type="hidden" name="error_url" value="">
                    <input type="hidden" name="customer_erp_code" value="">
                    <input type="hidden" name="post_premium" value="">
                    <input type="hidden" name="email_check_url" value="https://www.soniarykiel.com/en_us/util/form/isuniqueusername/">                                                                                                        
    <!--<div class="control-group prefix success">-->
        <!--<label for="prefix" class="control-label  required">Prefix<em>*</em></label>-->
        <!--<div class="controls">-->
                                                <!--<select name="prefix" id="prefix">-->
                                                            <!--<option value="1" id="prefix0">-->
                            <!--Miss                        </option>-->
                                                                                                    <!--<option value="2" id="prefix1">-->
                            <!--Mrs.                        </option>-->
                                                                                                    <!--<option value="3" id="prefix2">-->
                            <!--Mr.                        </option>-->
                                                                                                                            <!--</select>-->
            <!--<span class="help-inline"></span>-->
        <!--</div>-->
    <!--</div>-->
    <div class="control-group">
        <label for="firstname" class="control-label required">First Name<sup>*</sup></label>
        <div class="controls">
            <input type="text" id="firstname" placeholder="First Name" name="firstname" value="" title="First Name" maxlength="255" class="check-invalid-data required">
        	<span class="help-inline"></span>
        </div>
    </div>
   <div class="control-group">
        <label for="lastname" class="control-label required">Last Name<sup>*</sup></label>
		<div class="controls">
			<input type="text" id="lastname" placeholder="Last Name" name="lastname" value="" title="Last Name" maxlength="255" class="check-invalid-data required">
    		<span class="help-inline"></span>
    	</div>
    </div>
    
                                            
                    <div class="control-group">
                        <label for="email_address" class="control-label required">Email Address<sup>*</sup></label>
                        <div class="controls">
                            <input type="text" class="check-invalid-data required email" placeholder="Email Address" name="email" id="email_address" value="" title="Email Address">
                            <span class="help-inline"></span>
                        </div>
                        <label class="message-alert required">This email already exists! Try else!</label>
                    </div>
                                                                                                                            
                    <div class="control-group">
                        <label for="password" class="control-label required">Password<sup>*</sup></label>
                        <div class="controls">
                            <input type="password" class="check-invalid-data required" placeholder="Password" name="password" id="password" title="Password">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="confirmation" class="control-label required">Confirm Password<sup>*</sup></label>
                        <div class="controls">
                            <input type="password" class="check-invalid-data required" placeholder="Confirm Password" name="confirmation" title="Confirm Password" id="confirmation">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                                                        </div>
                                            <div class="control-group">
                    <label class="checkbox" for="is_subscribed">
                                                <input type="checkbox" name="is_subscribed" title="Sign Up for Newsletter" value="0" id="is_subscribed"> Sign Up for Newsletter                    </label>
                </div>
                        <div class="form-actions">
                <button type="button" class="btn btn-primary register-button">Submit</button>
            </div>
            <p class="required"><sup>*</sup>Required Fields</p>
                    </form>
    </div>
</div>
						<div class="visible-phone">
													</div>
					</div>
				</div>
			</div>
			
			
		</div>
EOF;

$bodyTextOld = <<<EOF
<div class="container-fluid register">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <h3>Личная информация</h3>
            <span class="header-blue">Фамилия</span> <input class="register-surname design-input" value="1" />
            <span class="header-blue">Имя</span> <input class="register-name design-input" value="1" />
            <span class="header-blue">Отчество</span> <input class="register-patronymic design-input" value="1" />
            <span class="header-blue">День рождения</span> <input class="register-birth design-input" value="1" />
            <span class="header-blue">Пол</span> <input class="register-gender design-input" value="1" />
        </div>
        <div class="col-md-3">
            <h3>Данные для связи</h3>
            <span class="header-blue">Почта</span> <input class="register-email design-input" value="1@" />
            <span class="header-blue">Телефон</span> <input class="register-phone design-input" value="1" />
        </div>
        <div class="col-md-3">
            <h3>Данные для входа</h3>
            <span class="header-blue">Логин</span> <input class="register-login design-input" />
            <span class="header-blue">Пароль</span> <input class="register-password design-input" type="password" />
            <span class="header-blue">Повторить пароль</span> <input class="register-repeat-password design-input"  type="password" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <button class="register-button">Регистрация</button>
        </div>
    </div>
</div>
EOF;
