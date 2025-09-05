<?php
namespace AdminController;

use AdminModel\ContactMessages;

class ContactController {
    public function messages() {
        $contactModel = new ContactMessages();
        $messages = $contactModel->getAllMessages();
        include_once __DIR__.'/../views/pages/messages.php';
    }


}
?>