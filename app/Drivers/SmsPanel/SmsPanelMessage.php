<?php


namespace App\Drivers\SmsPanel;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SmsPanelMessage
{
    protected string $user;
    protected array $lines;
    protected string $to;
    protected string|null $from = null;
    protected string $dryrun = 'no';

    public function __construct(array $lines = [])
    {
        $this->lines = $lines;
    }

    public function line($line): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    public function send(): mixed
    {
        if (!$this->to || !$this->lines) {
            throw new \Exception('SMS not correct.');
        }

        return resolve(SmsPanel::class)->send(
            message: join("\n", $this->lines),
            to: $this->to,
            from: $this->from,
        );
    }

    public function dryrun($dry = 'yes'): self
    {
        $this->dryrun = $dry;

        return $this;
    }
}
