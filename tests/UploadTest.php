<?php

use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{
    public function testAllowedExtensionsContainsJpg()
    {
        $allowedExtensions = ['jpeg', 'jpg', 'png'];

        $this->assertContains('jpg', $allowedExtensions);
    }

    public function testAllowedExtensionsContainsPng()
    {
        $allowedExtensions = ['jpeg', 'jpg', 'png'];

        $this->assertContains('png', $allowedExtensions);
    }

    public function testDisallowedExtensionsDoesNotContainExe()
    {
        $allowedExtensions = ['jpeg', 'jpg', 'png'];

        $this->assertNotContains('exe', $allowedExtensions);
    }
}