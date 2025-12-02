<?php

namespace App\Filament\Pages\Supplier;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterSupplier extends Register
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getCompanyNameFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getCompanyNameFormComponent(): \Filament\Forms\Components\Component
    {
        return TextInput::make('company_name')
            ->label('اسم الشركة')
            ->required()
            ->maxLength(255);
    }

    protected function getPhoneFormComponent(): \Filament\Forms\Components\Component
    {
        return TextInput::make('phone')
            ->label('رقم الهاتف')
            ->tel()
            ->required()
            ->maxLength(20);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Extract supplier-specific data
        $companyName = $data['company_name'];
        $phone = $data['phone'];
        
        // Remove supplier-specific data from user data
        unset($data['company_name']);
        unset($data['passwordConfirmation']);
        
        // Set user type to supplier
        $data['type'] = 'supplier';
        $data['is_active'] = true;
        
        // Create user
        $user = User::create($data);
        
        // Assign supplier role
        $user->assignRole('supplier');
        
        // Create supplier record
        Supplier::create([
            'user_id' => $user->id,
            'company_name' => $companyName,
            'phone' => $phone,
            'verification_status' => 'pending',
            'is_active' => true,
        ]);
        
        return $user;
    }
}

