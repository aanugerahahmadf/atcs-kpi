<div class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] p-0">
	<div class="flex">
		<div id="map" class="w-full h-screen"></div>
		<div class="absolute top-4 right-4 z-[1000] bg-white dark:bg-[#161615] rounded-lg p-3 shadow">
			<div class="flex items-center gap-2">
				<button wire:click="toggleStatus('online')" class="w-4 h-4 rounded-full bg-green-500 {{ in_array('online',$status) ? '' : 'opacity-30' }}"></button>
				<button wire:click="toggleStatus('offline')" class="w-4 h-4 rounded-full bg-red-500 {{ in_array('offline',$status) ? '' : 'opacity-30' }}"></button>
				<button wire:click="toggleStatus('maintenance')" class="w-4 h-4 rounded-full bg-yellow-400 {{ in_array('maintenance',$status) ? '' : 'opacity-30' }}"></button>
			</div>
		</div>
		<div class="absolute top-4 left-4 z-[1000] bg-white dark:bg-[#161615] rounded-lg p-2 shadow">
			<select class="text-sm" wire:model.live="buildingId">
				<option value="">Semua Gedung</option>
				@foreach ($buildings as $b)
					<option value="{{ $b->id }}">{{ $b->name }}</option>
				@endforeach
			</select>
		</div>
	</div>

	@vite(['resources/css/app.css','resources/js/app.js'])
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
	<script>
		document.addEventListener('livewire:init', () => {
			const center = [-6.3895, 108.4040];
			const map = L.map('map', { center, zoom: 15 });
			const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '&copy; OpenStreetMap'
			});
			const sat = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
				subdomains:['mt0','mt1','mt2','mt3']
			});
			osm.addTo(map);
			L.control.layers({ 'OpenStreetMap': osm, 'Satellite': sat }).addTo(map);

			let cctvMarkers = [];
			function clearMarkers(){ cctvMarkers.forEach(m => map.removeLayer(m)); cctvMarkers = []; }
			function colorForStatus(s){ return s==='online'?'green':(s==='maintenance'?'orange':'red'); }

			Livewire.on('refreshMap', () => {
				clearMarkers();
				const dataset = @json($cctvs);
				dataset.forEach(c => {
					if (!c.latitude || !c.longitude) return;
					const marker = L.circleMarker([parseFloat(c.latitude), parseFloat(c.longitude)], { radius: 7, color: colorForStatus(c.status) }).addTo(map);
					marker.bindPopup(`<div style='min-width:200px'>
						<strong>${c.name ?? 'CCTV #'+c.id}</strong><br/>
						Status: ${c.status}<br/>
						<a href='${@json(route('ui.stream',['cctv'=>0])) . ''.replace('/0','')}/${c.id}' class='inline-block mt-2 px-3 py-1 bg-black text-white rounded-sm'>Live Stream</a>
					</div>`);
					cctvMarkers.push(marker);
				});
			});

			Livewire.on('refreshMap');

			if (window.Echo) {
				window.Echo.channel('cctv.status').listen('.CctvStatusUpdated', (e) => {
					Livewire.dispatch('refreshMap');
				});
			}
		});
	</script>
</div>
