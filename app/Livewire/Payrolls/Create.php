<?php

namespace App\Livewire\Payrolls;

use App\Models\Payroll;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class Create extends  ModalComponent implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public ?Payroll $payroll = null;

    public static function modalMaxWidth(): string
    {
        return '6xl';
    }
    public static function closeModalOnEscape(): bool
    {
        return false;
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
    public static function closeModalOnEscapeIsForceful(): bool
    {
        return false;
    }

    public function mount(?int $id = null): void
    {
        $this->payroll = $id ? Payroll::with(['karyawan'])->find($id) : null;

        if (!$this->payroll && $id) {
            abort(404, 'Payrolls not found');
        }

        $this->data = $this->getPayrollData();
        $this->form->fill($this->data);
    }

    private function getPayrollData(): array
    {
        return [
            'karyawan_id' => $this->payroll?->karyawan_id ?? null,
        ];
    }

    public function render():View
    {
        return view('livewire.payrolls.create');
    }
}
