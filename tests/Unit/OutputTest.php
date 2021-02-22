<?php

declare(strict_types=1);

namespace webignition\TcpCliProxyModels\Tests\Unit;

use PHPUnit\Framework\TestCase;
use webignition\TcpCliProxyModels\Output;

class OutputTest extends TestCase
{
    /**
     * @dataProvider getExitCodeDataProvider
     */
    public function testGetExitCode(Output $output, int $expectedExitCode): void
    {
        self::assertSame($expectedExitCode, $output->getExitCode());
    }

    /**
     * @return array[]
     */
    public function getExitCodeDataProvider(): array
    {
        return [
            '0' => [
                'output' => new Output(0, ''),
                'expectedExitCode' => 0,
            ],
            '1' => [
                'output' => new Output(1, ''),
                'expectedExitCode' => 1,
            ],
            '2' => [
                'output' => new Output(2, ''),
                'expectedExitCode' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getContentDataProvider
     */
    public function testGetContent(Output $output, string $expectedContent): void
    {
        self::assertSame($expectedContent, $output->getContent());
    }

    /**
     * @return array[]
     */
    public function getContentDataProvider(): array
    {
        return [
            'empty' => [
                'output' => new Output(0, ''),
                'expectedContent' => '',
            ],
            'single line' => [
                'output' => new Output(0, 'content'),
                'expectedContent' => 'content',
            ],
            'multiple lines' => [
                'output' => new Output(0, "line1\nline2\n\nline4"),
                'expectedContent' => "line1\nline2\n\nline4",
            ],
        ];
    }

    /**
     * @dataProvider isSuccessfulDataProvider
     */
    public function testIsSuccessful(Output $output, bool $expectedIsSuccessful): void
    {
        self::assertSame($expectedIsSuccessful, $output->isSuccessful());
    }

    /**
     * @return array[]
     */
    public function isSuccessfulDataProvider(): array
    {
        return [
            'success' => [
                'output' => new Output(0, ''),
                'expectedIsSuccessful' => true,
            ],
            'failure 1' => [
                'output' => new Output(1, ''),
                'expectedIsSuccessful' => false,
            ],
            'failure 2' => [
                'output' => new Output(2, ''),
                'expectedIsSuccessful' => false,
            ],
        ];
    }

    /**
     * @dataProvider toStringDataProvider
     */
    public function testToString(Output $output, string $expectedString): void
    {
        self::assertSame($expectedString, $output->__toString());
    }

    /**
     * @return array[]
     */
    public function toStringDataProvider(): array
    {
        return [
            'empty, success' => [
                'output' => new Output(0, ''),
                'expectedString' => "\n" . '0',
            ],
            'empty, failure 1' => [
                'output' => new Output(1, ''),
                'expectedString' => "\n" . '1',
            ],
            'empty, failure 2' => [
                'output' => new Output(2, ''),
                'expectedString' => "\n" . '2',
            ],
            'single line, success' => [
                'output' => new Output(0, 'content'),
                'expectedString' => 'content' . "\n" . '0',
            ],
            'multiple lines, success' => [
                'output' => new Output(0, "line1\nline2\n\nline4"),
                'expectedContent' => "line1\nline2\n\nline4\n0",
            ],
        ];
    }

    /**
     * @dataProvider fromStringDataProvider
     */
    public function testFromString(string $serialisedOutput, Output $expectedOutput): void
    {
        self::assertEquals($expectedOutput, Output::fromString($serialisedOutput));
    }

    /**
     * @return array[]
     */
    public function fromStringDataProvider(): array
    {
        return [
            'empty, success' => [
                'serialisedOutput' => "\n" . '0',
                'expectedOutput' => new Output(0, ''),
            ],
            'empty, failure 1' => [
                'serialisedOutput' => "\n" . '1',
                'expectedOutput' => new Output(1, ''),
            ],
            'empty, failure 2' => [
                'serialisedOutput' => "\n" . '2',
                'expectedOutput' => new Output(2, ''),
            ],
            'single line, success' => [
                'serialisedOutput' => 'content' . "\n" . '0',
                'expectedOutput' => new Output(0, 'content'),
            ],
            'multiple lines, success' => [
                'expectedContent' => "line1\nline2\n\nline4\n0",
                'expectedOutput' => new Output(0, "line1\nline2\n\nline4"),
            ],
        ];
    }
}
