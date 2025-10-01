<div class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] p-6">
	<div class="max-w-5xl mx-auto">
		<div class="mb-4">
			<a href="{{ url()->previous() }}" class="text-sm underline underline-offset-4">Kembali</a>
		</div>
		<div class="bg-white dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] p-4">
			<div class="flex items-center justify-between mb-4">
				<h2 class="text-xl font-semibold">Live CCTV: {{ $cctv->name ?? 'CCTV #'.$cctv->id }}</h2>
				<span class="px-3 py-1 rounded-full text-xs {{ $cctv->status === 'online' ? 'bg-green-100 text-green-700' : ($cctv->status === 'maintenance' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">{{ ucfirst($cctv->status) }}</span>
			</div>

			<div class="aspect-video bg-black rounded-lg overflow-hidden">
				<video id="hls-video" class="w-full h-full" controls playsinline></video>
			</div>

			<div class="mt-3 text-xs text-gray-600 dark:text-gray-300">
				@if ($cctv->stream_hls_path)
					Sumber: {{ $cctv->stream_hls_path }}
				@else
					Stream HLS belum tersedia. RTSP: {{ $cctv->rtsp_url }}
				@endif
			</div>
		</div>
	</div>

	@vite('resources/js/app.js')
	<script type="module">
		import Hls from 'hls.js';
		const video = document.getElementById('hls-video');
		const src = @json($cctv->stream_hls_path ? asset($cctv->stream_hls_path) : null);
		if (src) {
			if (Hls.isSupported()) {
				const hls = new Hls({ liveDurationInfinity: true });
				hls.loadSource(src);
				hls.attachMedia(video);
				hls.on(Hls.Events.MANIFEST_PARSED, function () {
					video.play();
				});
			} else if (video.canPlayType('application/vnd.apple.mpegurl')) {
				video.src = src;
				video.addEventListener('loadedmetadata', function () {
					video.play();
				});
			}
		}
	</script>
</div>
