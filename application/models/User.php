<?php

class Application_Model_User extends Zend_Db_Table implements Zend_Auth_Adapter_Interface {
    protected $_name = 'user';
    public $email;
    public $password;
    public $id;
    
    /**
	* Sprawdza, czy istnieje użytkownik o tym emailu z tym hasłem
	* @param string $email
	* @param string $password
	* @return array|bool zwraca tablicę jeśli udało się znaleźć użytkownika oraz false, w przeciwnym wypadku
	* @deprecated
	*/
    public function check($email, $password)
    {
        $query = "SELECT * FROM user WHERE email LIKE '$email' AND password LIKE MD5(CONCAT('$password', salt))";
        
        return $this->getAdapter()->query($query)->fetch();
    }

    public function authenticate()
    {
        $user = $this->select()
            ->where('email = ?', $this->email)
            ->where('password = md5(CONCAT(?, salt))', $this->password)
            ->query()
            ->fetch();

        if (($user)) {
            // Uwierzytelnianie powiodło się, informujemy o sukcesie.
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $user['id']);
        }

        // Uwierzytelnianie nie powiodło się.
        // Zwracamy odpowiedni status, a jako tożsamość podajemy
        // wartość null.
        return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null);
    }
}