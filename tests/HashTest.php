<?php

use PHPUnit\Framework\TestCase;
use App\Utility\Hash;

class HashTest extends TestCase
{
    public function testGenerateSaltReturnsAString()
    {
        $salt = Hash::generateSalt(32);

        $this->assertIsString($salt);
        $this->assertNotEmpty($salt);
    }

    public function testGenerateHashReturnsAString()
    {
        $salt = Hash::generateSalt(32);
        $hash = Hash::generate('motdepasse', $salt);

        $this->assertIsString($hash);
        $this->assertNotEmpty($hash);
    }

    public function testGenerateHashIsStableWithSameInput()
    {
        $salt = Hash::generateSalt(32);

        $hash1 = Hash::generate('motdepasse', $salt);
        $hash2 = Hash::generate('motdepasse', $salt);

        $this->assertSame($hash1, $hash2);
    }
}