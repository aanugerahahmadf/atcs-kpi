<?php

namespace App\Services;

use App\Models\Cctv;
use Illuminate\Support\Facades\File;

class CameraStreamService
{
	public static function hlsPathFor(Cctv $cctv): string
	{
		return public_path('live/cctv_'.$cctv->id.'.m3u8');
	}

	public static function hlsPublicUrl(Cctv $cctv): string
	{
		return 'live/cctv_'.$cctv->id.'.m3u8';
	}

	public function start(Cctv $cctv): void
	{
		$hlsDir = public_path('live');
		if (! File::exists($hlsDir)) {
			File::makeDirectory($hlsDir, 0755, true);
		}

		$hlsPath = self::hlsPathFor($cctv);
		// Build FFmpeg command for low-latency HLS
		$cmd = sprintf(
			'ffmpeg -rtsp_transport tcp -i %s -fflags nobuffer -flags -global_header -hls_time 1 -hls_list_size 5 -hls_flags delete_segments+append_list -reset_timestamps 1 -c:v copy -c:a aac -f hls %s > /dev/null 2>&1 & echo $!',
			escapeshellarg($cctv->rtsp_url),
			escapeshellarg($hlsPath)
		);

		$pid = shell_exec($cmd);
		$cctv->update([
			'stream_hls_path' => self::hlsPublicUrl($cctv),
			'status' => 'online',
			'last_seen_at' => now(),
		]);
	}

	public function stop(Cctv $cctv): void
	{
		// For production, track PIDs per camera for clean termination.
		// As a simple approach, delete HLS files to mark stop.
		$hlsPath = self::hlsPathFor($cctv);
		if (File::exists($hlsPath)) {
			@unlink($hlsPath);
		}
		$cctv->update(['status' => 'offline']);
	}
}