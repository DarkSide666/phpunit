<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\MockObject;

use function md5;
use function mt_rand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\IgnorePhpunitDeprecations;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use PHPUnit\TestFixture\MockObject\ExtendableClass;
use PHPUnit\TestFixture\MockObject\InterfaceWithReturnTypeDeclaration;

#[CoversClass(MockBuilder::class)]
#[Group('test-doubles')]
#[Group('test-doubles/creation')]
#[Group('test-doubles/mock-object')]
#[Medium]
final class MockBuilderTest extends TestCase
{
    #[TestDox('setMockClassName() can be used to configure the name of the mock object class')]
    public function testCanCreateMockObjectWithSpecifiedClassName(): void
    {
        $className = 'random_' . md5((string) mt_rand());

        $double = $this->getMockBuilder(InterfaceWithReturnTypeDeclaration::class)
            ->setMockClassName($className)
            ->getMock();

        $this->assertSame($className, $double::class);
    }

    #[IgnorePhpunitDeprecations]
    #[TestDox('onlyMethods() can be used to configure which methods should be doubled')]
    public function testCreatesPartialMockObjectForExtendableClass(): void
    {
        $mock = $this->getMockBuilder(ExtendableClass::class)
            ->onlyMethods(['doSomethingElse'])
            ->getMock();

        $mock->expects($this->once())->method('doSomethingElse')->willReturn(true);

        $this->assertTrue($mock->doSomething());
    }
}
