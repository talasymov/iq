<?php
IncludesFn::printHeader("Sign Up", "customer-account-create grey", $seo);

$language = new Languages;

$bodyText = <<<EOF
<div class="wrap">
					    
		    <div class="container col1-layout">
				<div class="main">
										<div class="col-main">
						<div class="messages">           
  </div>  						
<div class="customer-login">
        <div class="account-create">
        <div class="page-header">
            <h1>{$language->Translate('create_an_account_register')}</h1>
        </div>
                        <div class="messages">           
  </div>          <form id="form-validate" data-customer-form="register">
                <div>
                    <input name="form_key" type="hidden" value="IUsgeTYYXVLgyfWu">
                    <input type="hidden" name="success_url" value="">
                    <input type="hidden" name="error_url" value="">
                    <input type="hidden" name="customer_erp_code" value="">
                    <input type="hidden" name="post_premium" value="">
                    <!--<input type="hidden" name="email_check_url" value="https://www.soniarykiel.com/en_us/util/form/isuniqueusername/">                                                                                                        -->
    <div class="control-group prefix">
        <label for="prefix" class="control-label  required">{$language->Translate('prefix')}<em>*</em></label>
        <div class="controls">
                                                <select name="prefix" id="prefix">
                                                            <option value="Miss" id="prefix0">
                            Miss                        </option>
                                                                                                    <option value="Mrs" id="prefix1">
                            Mrs.                        </option>
                                                                                                    <option value="Mr" id="prefix2">
                            Mr.                        </option>
                                                                                                                            </select>
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label for="firstname" class="control-label required">{$language->Translate('first_name')}<sup>*</sup></label>
        <div class="controls">
            <input type="text" id="firstname" required placeholder="{$language->Translate('first_name')}" name="firstname" value="" title="First Name" maxlength="255" class="required">
        	<span class="help-inline"></span>
        </div>
    </div>
   <div class="control-group">
        <label for="lastname" class="control-label required">{$language->Translate('last_name')}<sup>*</sup></label>
		<div class="controls">
			<input type="text" id="lastname" placeholder="{$language->Translate('last_name')}" name="lastname" value="" title="Last Name" maxlength="255" class="required">
    		<span class="help-inline"></span>
    	</div>
    </div>
    
                                            
                    <div class="control-group">
                        <label for="email_address" class="control-label required">{$language->Translate('e-mail')}<sup>*</sup></label>
                        <div class="controls">
                            <input type="text" class="required email" placeholder="{$language->Translate('e-mail')}" name="email" id="email_address" value="" title="Email Address">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                                                                                                                            
                    <div class="control-group">
                        <label for="password" class="control-label required">{$language->Translate('password')}<sup>*</sup></label>
                        <div class="controls">
                            <input type="password" class="required" placeholder="{$language->Translate('password')}" name="password" id="password" title="Password">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="confirmation" class="control-label required">{$language->Translate('confirm_password')}<sup>*</sup></label>
                        <div class="controls">
                            <input type="password" class="required" placeholder="{$language->Translate('confirm_password')}" name="confirmation" title="Confirm Password" id="confirmation">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                                                        </div>
                                            <div class="control-group">
                    <label class="checkbox" for="is_subscribed">
                                                <input type="checkbox" name="is_subscribed" title="{$language->Translate('sign_up_newsletter')}" value="0" id="is_subscribed"> {$language->Translate('sign_up_newsletter')}                    </label>
                </div>
                        <div class="form-actions">
                <button type="button" class="btn btn-primary register-button">{$language->Translate('submit_sign_up')}</button>
            </div>
            <p class="required"><sup>*</sup>{$language->Translate('required_fields')}</p>
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
