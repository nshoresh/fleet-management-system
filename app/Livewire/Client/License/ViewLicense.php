<?php

namespace App\Livewire\Client\License;

use Livewire\Component;
use App\Models\License;

class ViewLicense extends Component
{
    // ✅ This property will hold the License model instance
    public License $license;

    // ✅ Mount method runs when the component is initialized
    public function mount(License $license)
    {
        $this->license = $license;
    }
    public function render()
    {
        return view('livewire.client.license.view-license');
    }
}
