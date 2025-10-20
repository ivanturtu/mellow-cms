<?php

namespace App\Livewire\Admin;

trait ModalTrait
{
    public $showModal = false;
    public $modalType = '';

    public function openModal($type = 'default')
    {
        $this->modalType = $type;
        $this->showModal = true;
        $this->dispatch('modal-opened', type: $type);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->modalType = '';
        $this->dispatch('modal-closed');
        $this->dispatch('close-modal');
    }

    public function toggleModal($type = 'default')
    {
        if ($this->showModal) {
            $this->closeModal();
        } else {
            $this->openModal($type);
        }
    }

    public function resetModal()
    {
        $this->showModal = false;
        $this->modalType = '';
    }
}
