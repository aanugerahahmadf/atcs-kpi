<?php

namespace App\Livewire\Ui;

use App\Models\Building;
use App\Models\Room;
use App\Models\Cctv;
use Livewire\Attributes\Url;
use Livewire\Component;

class Location extends Component
{
	#[Url]
	public string $q = '';
	#[Url]
	public ?int $buildingId = null;
	#[Url]
	public ?int $roomId = null;

	public function render()
	{
		$buildings = Building::query()
			->when($this->q, fn($q) => $q->where('name','like','%'.$this->q.'%'))
			->get();
		$rooms = collect();
		$cctvs = collect();
		if ($this->buildingId) {
			$rooms = Room::where('building_id',$this->buildingId)->get();
		}
		if ($this->roomId) {
			$cctvs = Cctv::where('room_id',$this->roomId)->get();
		}
		return view('livewire.ui.location', compact('buildings','rooms','cctvs'));
	}
}
