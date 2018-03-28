<?php
IncludesFn::printHeader("Log In", "customer-account-login grey", $seo);

$language = new Languages;

$bodyText = <<<EOF
<div class="wrap margin-top-clear">
					    
		    <div class="container col1-layout">
				<div class="main">
										<div class="col-main">
						<div class="messages">           
  </div>  						<div class="customer-login">
        <div class="account-login">
        <div class="page-header">
            <h1>{$language->Translate('log_in')}</h1>
        </div>
        <div class="login-content">
            <form id="login-form" class="left-column column" data-customer-form="login" autocomplete="off" novalidate="novalidate">
                <h2>{$language->Translate('already_register')}?</h2>
                <div class="control-group success">
                    <label class="control-label" for="email">{$language->Translate('contact_email')}<sup>*</sup></label>
                    <div class="controls">
                        <input type="text" id="email" name="login[username]" class="input-large login-input" placeholder="{$language->Translate('contact_email')}" value="">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group password-parent success">
                    <label class="control-label" for="password"><span class="text">{$language->Translate('password')}</span><sup>*</sup></label>
                    <div class="controls">
                        <input type="password" id="password" name="login[password]" class="input-large password-input" placeholder="{$language->Translate('password')}">
                        <span class="help-inline"></span>
                    </div>
                </div>
                                <p class="required"><sup>*</sup>{$language->Translate('required_fields')}</p>
                <div class="messages">           
  </div>                  <div class="form-actions">
                    <button type="button" class="btn btn-login btn-primary">{$language->Translate('log_in')}</button>
                    <button type="button" class="btn btn-restore-pass btn-primary hidden">{$language->Translate('already_register')}</button>
                    <a title="Forgot Your Password?" class="normal-link forgout-pass">{$language->Translate('already_register')}?</a>
                    
                    <div class="reset-password-info">{$language->Translate('mail_send_check')}</div>
                </div>
            
                            </form>
            <div class="right-column column">
                <h2>{$language->Translate('no_account')}?</h2>
                <p>{$language->Translate('create_an_account')}:</p>
                <ul>
                    {$language->Translate('create_an_account_li')}
                </ul>
                <a href="/sign-up/" class="btn btn-secondary">{$language->Translate('create_an_account_text')}</a>
            </div>
        </div>
    </div>
</div>
						<div class="visible-phone">
													</div>
					</div>
				</div>
			</div>
			
			
		</div>
EOF;
