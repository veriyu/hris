<?php

namespace App\Filament\Auth;

use Filament\Schemas\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                $this->getEmployeeNumberFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getEmployeeNumberFormComponent(): Component
    {
        return TextInput::make('employee_number')
            ->label('Employee Number / Email (Admin)')
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['employee_number'], FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_number';
        
        return [
            $login_type => $data['employee_number'],
            'password'  => $data['password'],
        ];
    }
    
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.employee_number' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
}
