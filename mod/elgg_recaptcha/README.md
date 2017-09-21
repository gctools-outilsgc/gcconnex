# Elgg Recaptcha
Protect forms with Googles Recaptcha

This plugin provides recaptcha verification that is configurable for specific actions.
Actions can be selected through plugin settings.  The form for the action will have a
recaptcha inserted in the .elgg-foot div if it exists, or just above the last submit input.

Caveat: This only works for a form/action pair that follow the standard Elgg pattern using elgg_view_form()

In addition to the standalone usage, this plugin provides a simple view for programmatically inserting
a captcha, and a function for validating the response.

## Installation

Unzip/clone to the mod directory of your Elgg installation.

Sign up for google recaptcha and generate a public/private key pair at https://www.google.com/recaptcha/admin/create

Enable the plugin, enter the keys in the settings, select default rendering settings.


## Advanced Usage

A recaptcha can be inserted into any markup with a view

    echo elgg_view('input/recaptcha');

No parameters are necessary, if none are passed the recaptcha will render with the default
options stored in the plugin settings.  Parameters explicitly passed override defaults.

Optional parameters for the view are:

    theme: The visual design of the recaptcha ('light' | 'dark')
    size: The size of the recaptcha ('normal' | 'compact')
    type: Type of challenge to perform ('image' | 'audio')
    form: jquery selector of a form to position the recaptcha in eg. '.elgg-form-register'


To validate an action use the function

    \Beck24\ReCaptcha\validate_recaptcha();

This function simply returns boolean whether the captcha response is valid.  Usage may look
something like this

    // In our action file or action hook
    if (!\Beck24\ReCaptcha\validate_recaptcha()) {
        // invalid recaptcha
        elgg_make_sticky_form('my/form');
        register_error(elgg_echo('elgg_recaptcha:message:fail'));
        forward(REFERER);
    }
    
    // we passed, proceed with the action


