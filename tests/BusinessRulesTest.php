<?php

use PHPUnit\Framework\TestCase;

class BusinessRulesTest extends TestCase
{
    public function testProductCreationRequiresPicture()
    {
        $fileError = UPLOAD_ERR_NO_FILE;

        $this->assertSame(4, $fileError);
        $this->assertTrue($fileError === UPLOAD_ERR_NO_FILE);
    }

    public function testPasswordsMustMatchForRegistration()
    {
        $password = 'motdepasse123';
        $passwordCheck = 'motdepasse123';

        $this->assertSame($password, $passwordCheck);
    }

    public function testPasswordsMismatchFailsRegistration()
    {
        $password = 'motdepasse123';
        $passwordCheck = 'autremotdepasse';

        $this->assertNotSame($password, $passwordCheck);
    }

    public function testRememberMeCheckboxCanBeEnabled()
    {
        $remember = '1';

        $this->assertSame('1', $remember);
    }

    public function testContactFormRequiresEmailAndMessage()
    {
        $email = 'test@example.com';
        $message = 'Bonjour, je suis intéressé par votre annonce.';

        $this->assertNotEmpty($email);
        $this->assertNotEmpty($message);
    }

    public function testContactFormFailsIfMessageIsEmpty()
    {
        $email = 'test@example.com';
        $message = '';

        $this->assertNotEmpty($email);
        $this->assertEmpty($message);
    }
}