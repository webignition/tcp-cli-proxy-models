<?php

declare(strict_types=1);

namespace webignition\TcpCliProxyModels;

class Output
{
    private int $exitCode;
    private string $content;

    public function __construct(int $exitCode, string $content)
    {
        $this->content = $content;
        $this->exitCode = $exitCode;
    }

    public static function fromString(string $serialisedOutput): self
    {
        $parts = explode("\n", $serialisedOutput);
        $exitCode = (int) (array_pop($parts));

        return new Output(
            $exitCode,
            trim(implode("\n", $parts))
        );
    }

    public function getExitCode(): int
    {
        return $this->exitCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isSuccessful(): bool
    {
        return 0 === $this->exitCode;
    }

    public function __toString()
    {
        return $this->content . "\n" . (string) $this->exitCode;
    }
}
