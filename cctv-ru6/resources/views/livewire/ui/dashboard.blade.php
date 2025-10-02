<div class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] p-6">
	<div class="max-w-6xl mx-auto">
		<h1 class="text-2xl font-bold mb-4">Dashboard</h1>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			<div class="bg-white dark:bg-[#161615] rounded-lg p-4 shadow">
				<div class="text-sm text-gray-500">Total Gedung</div>
				<div class="text-3xl font-semibold">{{ $buildingCount }}</div>
			</div>
			<div class="bg-white dark:bg-[#161615] rounded-lg p-4 shadow">
				<div class="text-sm text-gray-500">Total Ruangan</div>
				<div class="text-3xl font-semibold">{{ $roomCount }}</div>
			</div>
			<div class="bg-white dark:bg-[#161615] rounded-lg p-4 shadow">
				<div class="text-sm text-gray-500">CCTV Online</div>
				<div class="text-3xl font-semibold text-green-600">{{ $cctvOnline }}</div>
			</div>
			<div class="bg-white dark:bg-[#161615] rounded-lg p-4 shadow">
				<div class="text-sm text-gray-500">CCTV Offline</div>
				<div class="text-3xl font-semibold text-red-600">{{ $cctvOffline }}</div>
			</div>
			<div class="bg-white dark:bg-[#161615] rounded-lg p-4 shadow">
				<div class="text-sm text-gray-500">CCTV Maintenance</div>
				<div class="text-3xl font-semibold text-yellow-600">{{ $cctvMaintenance }}</div>
			</div>
		</div>
		<div class="mt-6 flex gap-2">
			<a href="{{ route('export.cctvs') }}" class="px-4 py-2 bg-black text-white rounded-sm">Export CCTV</a>
		</div>
	</div>
</div>
