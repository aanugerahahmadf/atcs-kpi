<?php

namespace App\Console\Commands;

use App\Events\CctvStatusUpdated;
use App\Models\Cctv;
use Illuminate\Console\Command;

class CctvCheckStatusCommand extends Command
{
	protected $signature = 'cctv:check-status {--limit=100}';
	protected $description = 'Check CCTV availability and update status';

	public function handle(): int
	{
		$limit = (int) $this->option('limit');
		Cctv::query()->limit($limit)->get()->each(function (Cctv $cctv) {
			$host = $this->extractHost($cctv->rtsp_url);
			$status = $this->isHostReachable($host) ? 'online' : 'offline';
			if ($cctv->status !== $status) {
				$cctv->forceFill(['status' => $status, 'last_seen_at' => now()])->save();
				broadcast(new CctvStatusUpdated($cctv));
			}
		});
		return self::SUCCESS;
	}

	private function extractHost(string $rtsp): ?string
	{
		$parts = parse_url($rtsp);
		return $parts['host'] ?? null;
	}

	private function isHostReachable(?string $host): bool
	{
		if (! $host) return false;
		$cmd = sprintf('ping -c 1 -W 1 %s > /dev/null 2>&1 && echo ok || echo fail', escapeshellarg($host));
		$out = trim(shell_exec($cmd) ?? 'fail');
		return $out === 'ok';
	}
}