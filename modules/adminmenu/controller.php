<?php
class adminmenuControllerPrt extends controllerPrt {
    public function sendMailToDevelopers() {
        $res = new responsePrt();
        $data = reqPrt::get('post');
        $fields = array(
            'name' => new fieldPrt('name', langPrt::_('Your name field is required.'), '', '', 'Your name', 0, array(), 'notEmpty'),
            'website' => new fieldPrt('website', langPrt::_('Your website field is required.'), '', '', 'Your website', 0, array(), 'notEmpty'),
            'email' => new fieldPrt('email', langPrt::_('Your e-mail field is required.'), '', '', 'Your e-mail', 0, array(), 'notEmpty, email'),
            'subject' => new fieldPrt('subject', langPrt::_('Subject field is required.'), '', '', 'Subject', 0, array(), 'notEmpty'),
            'category' => new fieldPrt('category', langPrt::_('You must select a valid category.'), '', '', 'Category', 0, array(), 'notEmpty'),
            'message' => new fieldPrt('message', langPrt::_('Message field is required.'), '', '', 'Message', 0, array(), 'notEmpty'),
        );
		
        foreach($fields as $f) {
            $f->setValue($data[$f->name]);
            $errors = validatorPrt::validate($f);
            if(!empty($errors)) {
                $res->addError($errors);
            }
        }
		
        if(!$res->error) {
            $msg = 'Message from: '. get_bloginfo('name').', Host: '. $_SERVER['HTTP_HOST']. '<br />';
            foreach($fields as $f) {
                $msg .= '<b>'. $f->label. '</b>: '. nl2br($f->value). '<br />';
            }
			$headers[] = 'From: '. $fields['name']->value. ' <'. $fields['email']->value. '>';
            wp_mail('ukrainecmk@ukr.net, simon@readyshoppingcart.com, support@readyecommerce.zendesk.com', 'Ready Ecommerce Contact Dev', $msg, $headers);
            $res->addMessage(langPrt::_('Done'));
        }
        $res->ajaxExec();
    }
}

