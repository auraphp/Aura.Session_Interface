<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 */
namespace Aura\Session_Interface;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * These are contract tests, not behaviour tests: the package ships only
 * interfaces, so there is no logic to exercise. Instead we lock down the
 * public surface (interface names, method lists, and return types) so that an
 * accidental rename or signature change — which would be a silent BC break for
 * every consumer — fails loudly here.
 */
class InterfaceContractTest extends TestCase
{
    /**
     * The exact contract: interface => [method => expected return type].
     */
    private const CONTRACT = [
        SessionInterface::class => [
            'start' => 'bool',
            'resume' => 'bool',
            'regenerateId' => 'bool',
        ],
        SegmentInterface::class => [
            'get' => 'mixed',
            'set' => 'void',
        ],
        ManageableSegmentInterface::class => [
            'getSegment' => 'mixed',
            'clear' => 'void',
            'remove' => 'void',
        ],
        FlashSegmentInterface::class => [
            'setFlash' => 'void',
            'getFlash' => 'mixed',
            'getFlashAll' => 'array',
            'clearFlash' => 'void',
            'getFlashNext' => 'mixed',
            'getFlashNextAll' => 'array',
            'setFlashNow' => 'void',
            'clearFlashNow' => 'void',
            'keepFlash' => 'void',
        ],
    ];

    public function testEachContractInterfaceExistsAndIsAnInterface(): void
    {
        foreach (array_keys(self::CONTRACT) as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                "{$interface} should exist and be an interface"
            );
        }
    }

    #[DataProvider('provideInterfaces')]
    public function testInterfaceDeclaresExactlyItsContractMethods(
        string $interface,
        array $methods
    ): void {
        $actual = get_class_methods($interface);
        sort($actual);
        $expected = array_keys($methods);
        sort($expected);

        $this->assertSame(
            $expected,
            $actual,
            "{$interface} must declare exactly its contract methods"
        );
    }

    #[DataProvider('provideMethods')]
    public function testMethodReturnType(
        string $interface,
        string $method,
        string $expectedReturnType
    ): void {
        $reflection = new ReflectionMethod($interface, $method);
        $returnType = $reflection->getReturnType();

        $this->assertNotNull(
            $returnType,
            "{$interface}::{$method}() must declare a return type"
        );
        $this->assertSame(
            $expectedReturnType,
            (string) $returnType,
            "{$interface}::{$method}() must return {$expectedReturnType}"
        );
    }

    public function testInterfacesAreImplementableTogether(): void
    {
        // An object may satisfy every interface at once; proving the contracts
        // are mutually compatible (no clashing signatures).
        $segment = new class implements
            SegmentInterface,
            ManageableSegmentInterface,
            FlashSegmentInterface
        {
            private array $data = [];
            public function get(string $key, mixed $alt = null): mixed { return $this->data[$key] ?? $alt; }
            public function set(string $key, mixed $val): void { $this->data[$key] = $val; }
            public function getSegment(): mixed { return $this->data; }
            public function clear(): void { $this->data = []; }
            public function remove(?string $key = null): void { $key === null ? $this->data = [] : $this->data[$key] = null; }
            public function setFlash(string $key, mixed $val): void {}
            public function getFlash(string $key, mixed $alt = null): mixed { return $alt; }
            public function getFlashAll(): array { return []; }
            public function clearFlash(): void {}
            public function getFlashNext(string $key, mixed $alt = null): mixed { return $alt; }
            public function getFlashNextAll(): array { return []; }
            public function setFlashNow(string $key, mixed $val): void {}
            public function clearFlashNow(): void {}
            public function keepFlash(): void {}
        };

        $this->assertInstanceOf(SegmentInterface::class, $segment);
        $this->assertInstanceOf(ManageableSegmentInterface::class, $segment);
        $this->assertInstanceOf(FlashSegmentInterface::class, $segment);

        $segment->set('foo', 'bar');
        $this->assertSame('bar', $segment->get('foo'));
        $this->assertSame('fallback', $segment->get('missing', 'fallback'));

        $session = new class implements SessionInterface {
            public function start(): bool { return true; }
            public function resume(): bool { return false; }
            public function regenerateId(): bool { return true; }
        };
        $this->assertInstanceOf(SessionInterface::class, $session);
    }

    public static function provideInterfaces(): array
    {
        $cases = [];
        foreach (self::CONTRACT as $interface => $methods) {
            $cases[$interface] = [$interface, $methods];
        }
        return $cases;
    }

    public static function provideMethods(): array
    {
        $cases = [];
        foreach (self::CONTRACT as $interface => $methods) {
            foreach ($methods as $method => $returnType) {
                $cases["{$interface}::{$method}"] = [$interface, $method, $returnType];
            }
        }
        return $cases;
    }
}
