<?php

namespace App\Livewire\Ui;

use App\Models\Building;
use App\Models\Cctv;
use App\Models\Room;
use Livewire\Attributes\Url;
use Livewire\Component;

class Maps extends Component
{
	#[Url]
	public array $status = ['online', 'offline', 'maintenance'];
	#[Url]
	public ?int $buildingId = null;
	#[Url]
	public ?int $roomId = null;

	public function toggleStatus(string $s): void
	{
		if (in_array($s, $this->status, true)) {
			$this->status = array_values(array_filter($this->status, fn ($v) => $v !== $s));
		} else {
			$this->status[] = $s;
		}
	}

	public function render()
	{
		$buildings = Building::query()->select('id','name','latitude','longitude')->get();
		$cctvs = Cctv::query()
			->when($this->buildingId, fn ($q) => $q->where('building_id', $this->buildingId))
			->when($this->roomId, fn ($q) => $q->where('room_id', $this->roomId))
			->whereIn('status', $this->status)
			->select('id','name','latitude','longitude','status','building_id','room_id')
			->get();

		return view('livewire.ui.maps', [
			'buildings' => $buildings,
			'cctvs' => $cctvs,
		]);
	}
}
