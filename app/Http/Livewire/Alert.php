<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Alert extends Component
{
    public $listeners = [
        'onAlert'   =>  'displayAlert'
    ];

    public string $message = '';

    public string $type = 'success';

    public function displayAlert($params)
    {
        if( isset($params['type']) ) {
            $this->type = $params['type'];
        }
        $this->message = $params['message'];
    }

    public function render()
    {
        return view('livewire.alert');
    }
}
