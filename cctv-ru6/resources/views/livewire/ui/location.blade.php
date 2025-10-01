<div class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] p-6">
	<div class="max-w-6xl mx-auto">
		<div class="flex items-center justify-between mb-4">
			<h1 class="text-2xl font-bold">Location</h1>
			<input type="text" wire:model.live="q" placeholder="Cari nama gedung..." class="px-3 py-2 rounded border" />
		</div>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			@foreach ($buildings as $b)
				<div class="bg-white dark:bg-[#161615] rounded-lg p-4 shadow">
					<div class="font-semibold mb-2">{{ $b->name }}</div>
					<div class="text-xs mb-2">{{ $b->address }}</div>
					<button class="px-3 py-1 bg-black text-white rounded-sm" wire:click="$set('buildingId', {{ $b->id }})">Rooms</button>
				</div>
			@endforeach
		</div>

		@if ($rooms->count())
			<h2 class="text-xl font-semibold mt-8 mb-3">Rooms</h2>
			<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
				@foreach ($rooms as $r)
					<div class="bg-white dark:bg-[#161615] rounded-lg p-4 shadow">
						<div class="font-semibold mb-2">{{ $r->name }}</div>
						<button class="px-3 py-1 bg-black text-white rounded-sm" wire:click="$set('roomId', {{ $r->id }})">CCTV</button>
					</div>
				@endforeach
			</div>
		@endif

		@if ($cctvs->count())
			<h2 class="text-xl font-semibold mt-8 mb-3">CCTV</h2>
			<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
				@foreach ($cctvs as $c)
					<div class="bg-white dark:bg-[#161615] rounded-lg p-4 shadow">
						<div class="font-semibold mb-2">{{ $c->name ?? 'CCTV #'.$c->id }}</div>
						<div class="text-xs mb-2">Status: <span class="{{ $c->status === 'online' ? 'text-green-600' : ($c->status === 'maintenance' ? 'text-yellow-600' : 'text-red-600') }}">{{ $c->status }}</span></div>
						<a href="{{ route('ui.stream', ['cctv' => $c->id]) }}" class="px-3 py-1 bg-black text-white rounded-sm">Live CCTV</a>
					</div>
				@endforeach
			</div>
		@endif
	</div>
</div>
