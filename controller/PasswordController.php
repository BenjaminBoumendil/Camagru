<?php

class PasswordController extends PasswordEntity
{
    /*
    * Generate passwordResetHash and send it by mail
    */
    private function sendPasswordResetHash($email, $username)
    {

    }

    /*
    * Set new password
    */
    private function setNewPassword($username, $password)
    {

    }

    /*
    * Return form to reset password
    */
    public function getResetForm()
    {
        $form = "";
        return $form;
    }

    /*
    * Check if $url is a valide url for password reset
    * return true in success otherwise false
    */
    public function isPasswordResetUrl($url)
    {
        return false;
    }

    /*
    * Generate and send password code or reset password with it
    */
    public function resetPassword()
    {
        if (!isset($_POST['resetCode']) && isset($_POST['email']))
        {
            $this->sendPasswordResetHash($_POST['email'], $_POST['username']);
        }
        elseif (isset($_POST['resetCode']) && isset($_POST['username']) && isset($_POST['password']))
        {
            $this->setNewPassword($_POST['username'], $_POST['password']);
        }
    }
}

?>
