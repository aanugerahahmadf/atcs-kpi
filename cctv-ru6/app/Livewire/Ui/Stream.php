<?php

namespace App\Livewire\Ui;

use App\Models\Cctv;
use Livewire\Attributes\Url;
use Livewire\Component;

class Stream extends Component
{
	public Cctv $cctv;

	public function mount(Cctv $cctv): void
	{
		$this->cctv = $cctv;
	}

	public function render()
	{
		return view('livewire.ui.stream');
	}
}
