<?php

namespace App\Livewire\Ui;

use App\Models\Building;
use App\Models\Room;
use App\Models\Cctv;
use Livewire\Component;

class Dashboard extends Component
{
	public function render()
	{
		return view('livewire.ui.dashboard', [
			'buildingCount' => Building::count(),
			'roomCount' => Room::count(),
			'cctvOnline' => Cctv::where('status','online')->count(),
			'cctvOffline' => Cctv::where('status','offline')->count(),
			'cctvMaintenance' => Cctv::where('status','maintenance')->count(),
		]);
	}
}
