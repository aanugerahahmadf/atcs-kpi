<?php

namespace App\Livewire\Ui;

use App\Models\Cctv;
use App\Services\CameraStreamService;
use Livewire\Attributes\Url;
use Livewire\Component;

class Stream extends Component
{
	public Cctv $cctv;

    public function mount(Cctv $cctv, CameraStreamService $service): void
	{
		$this->cctv = $cctv;
        if (! $this->cctv->stream_hls_path) {
            $service->start($this->cctv);
            $this->cctv->refresh();
        }
	}

	public function render()
	{
		return view('livewire.ui.stream');
	}
}
