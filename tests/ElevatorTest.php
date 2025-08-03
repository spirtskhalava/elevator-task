<?php
declare(strict_types=1);

namespace Elevator\Tests;

use PHPUnit\Framework\TestCase;
use Elevator\{A, B, C, D, E, F, Elevator};

final class ElevatorTest extends TestCase
{
    public function testTotalPeopleWithConfigurations(array $cameraCounts, int $expectedTotal, string $message): void
    {
        $elevator = new Elevator();

        foreach ($cameraCounts as $index => $count) {
            switch ($index) {
                case 0: $elevator->addCamera(new A($count)); break;
                case 1: $elevator->addCamera(new B($count)); break;
                case 2: $elevator->addCamera(new E($count)); break;
                case 3: $elevator->addCamera(new F($count)); break;
                case 4: $elevator->addCamera(new D($count)); break;
            }
        }

        $this->assertSame($expectedTotal, $elevator->getTotalPeople(), $message);
    }

    public static function cameraConfigurationProvider(): array
    {
        return [
            [[5], 0, 'A only'],
            [[3], 0, 'Only A, not impact'],
            [[2, 4], 4, 'F counted, A ignored'],
            [[1, 3], 3, 'B counted if A >= 1'],
            [[0, 3], 0, 'B ignored if A < 1'],
            [[3, 0, 0, 0, 2], 2, 'D counted if A >= 3'],
            [[2, 0, 0, 0, 2], 0, 'D ignored if A < 3'],
            [[2, 2, 5], 5, 'E counted if A >= 1 and B >= 2'],
            [[1, 1, 5], 0, 'E ignored if B < 2'],
            [[2, 2, 5, 2], 7, 'E and F are counted'],
        ];
    }
}
