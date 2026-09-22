<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Test\TestCase\Trait;

use Avolle\KnxProject\Trait\ProjectPasswordTrait;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProjectPasswordTraitTest extends TestCase
{
    use ProjectPasswordTrait;

    /**
     * Test hashPassword method.
     *
     * @return void
     */
    #[Test]
    public function testHashPassword(): void
    {
        $password = 'password';
        $expected = 'SOxqBoHje05OwMf59o3x6RvdFg/AJ2V2rDC4yFC20Lo=';
        $actual = $this->hashPassword($password);
        $this->assertEquals($expected, $actual);

        $password = 'some other password';
        $expected = '7IYFBvhLg6JzjDx5ZvKrnE/p0kXW+9yIQp7tuH+Dzro=';
        $actual = $this->hashPassword($password);
        $this->assertEquals($expected, $actual);
    }
}
