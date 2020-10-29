<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrPermissions = [
            'show dashboard',
            'manage user',
            'create user',
            'edit user',
            'delete user',
            'create language',
            'manage system settings',
            'manage role',
            'create role',
            'edit role',
            'delete role',
            'manage permission',
            'create permission',
            'edit permission',
            'delete permission',
            'manage company settings',
            'manage expense',
            'create expense',
            'edit expense',
            'delete expense',
            'manage invoice',
            'create invoice',
            'edit invoice',
            'delete invoice',
            'show invoice',
            'convert invoice',
            'create payment invoice',
            'delete payment invoice',
            'send invoice',
            'delete invoice product',
            'manage product & service',
            'create product & service',
            'edit product & service',
            'delete product & service',
            'manage constant tax',
            'create constant tax',
            'edit constant tax',
            'delete constant tax',
            'manage constant category',
            'create constant category',
            'edit constant category',
            'delete constant category',
            'manage constant unit',
            'create constant unit',
            'edit constant unit',
            'delete constant unit',
            'manage customer',
            'create customer',
            'edit customer',
            'delete customer',
            'show customer',
            'manage vender',
            'create vender',
            'edit vender',
            'delete vender',
            'show vender',
            'manage bank account',
            'create bank account',
            'edit bank account',
            'delete bank account',
            'manage transfer',
            'create transfer',
            'edit transfer',
            'delete transfer',
            'manage constant payment method',
            'create constant payment method',
            'edit constant payment method',
            'delete constant payment method',
            'manage transaction',
            'manage revenue',
            'create revenue',
            'edit revenue',
            'delete revenue',
            'manage bill',
            'create bill',
            'edit bill',
            'delete bill',
            'show bill',
            'manage payment',
            'create payment',
            'edit payment',
            'delete payment',
            'delete bill product',
            'send bill',
            'create payment bill',
            'delete payment bill',
            'income report',
            'expense report',
            'income vs expense report',
            'tax report',
            'loss & profit report',
            'manage customer payment',
            'manage customer transaction',
            'manage customer invoice',
            'vender manage bill',
            'manage vender bill',
            'manage vender payment',
            'manage vender transaction',
            'manage credit note',
            'create credit note',
            'edit credit note',
            'delete credit note',
            'manage debit note',
            'create debit note',
            'edit debit note',
            'delete debit note',
            'duplicate invoice',
            'duplicate bill',
            'manage proposal',
            'create proposal',
            'edit proposal',
            'delete proposal',
            'duplicate proposal',
            'send proposal',
            'show proposal',
            'delete proposal product',
            'manage customer proposal',
            'manage goal',
            'create goal',
            'edit goal',
            'delete goal',
            'manage assets',
            'create assets',
            'edit assets',
            'delete assets',
            'statement report',
            'invoice report',
            'bill report',
            'manage constant custom field',
            'create constant custom field',
            'edit constant custom field',
            'delete constant custom field',
        ];

        foreach($arrPermissions as $ap)
        {
            Permission::create(['name' => $ap]);
        }


        // customer
        $customerRole       = Role::create(
            [
                'name' => 'customer',
                'created_by' => 0,
            ]
        );
        $customerPermission = [
            'manage customer payment',
            'manage customer transaction',
            'manage customer invoice',
            'show invoice',
            'show proposal',
            'manage customer proposal',
            'show customer',
        ];

        foreach($customerPermission as $ap)
        {
            $permission = Permission::findByName($ap);
            $customerRole->givePermissionTo($permission);
        }

        // vender
        $venderRole       = Role::create(
            [
                'name' => 'vender',
                'created_by' => 0,
            ]
        );
        $venderPermission = [
            'vender manage bill',
            'manage vender bill',
            'manage vender payment',
            'manage vender transaction',
            'show bill',
            'show vender',
        ];

        foreach($venderPermission as $ap)
        {
            $permission = Permission::findByName($ap);
            $venderRole->givePermissionTo($permission);
        }


        // company

        $companyRole = Role::create(
            [
                'name' => 'company',
                'created_by' => 0,
            ]
        );

        $companyPermissions = [
            'show dashboard',
            'manage user',
            'create user',
            'edit user',
            'delete user',
            'create language',
            'manage role',
            'create role',
            'edit role',
            'delete role',
            'manage permission',
            'create permission',
            'edit permission',
            'delete permission',
            'manage company settings',
            'manage system settings',
            'manage expense',
            'create expense',
            'edit expense',
            'delete expense',
            'manage invoice',
            'create invoice',
            'edit invoice',
            'delete invoice',
            'show invoice',
            'convert invoice',
            'manage product & service',
            'create product & service',
            'delete product & service',
            'edit product & service',
            'manage constant tax',
            'create constant tax',
            'edit constant tax',
            'delete constant tax',
            'manage constant category',
            'create constant category',
            'edit constant category',
            'delete constant category',
            'manage constant unit',
            'create constant unit',
            'edit constant unit',
            'delete constant unit',
            'manage customer',
            'create customer',
            'edit customer',
            'delete customer',
            'show customer',
            'manage vender',
            'create vender',
            'edit vender',
            'delete vender',
            'show vender',
            'manage bank account',
            'create bank account',
            'edit bank account',
            'delete bank account',
            'manage transfer',
            'create transfer',
            'edit transfer',
            'delete transfer',
            'manage constant payment method',
            'create constant payment method',
            'edit constant payment method',
            'delete constant payment method',
            'manage revenue',
            'create revenue',
            'edit revenue',
            'delete revenue',
            'manage bill',
            'create bill',
            'edit bill',
            'delete bill',
            'show bill',
            'manage payment',
            'create payment',
            'edit payment',
            'delete payment',
            'delete invoice product',
            'delete bill product',
            'send invoice',
            'create payment invoice',
            'delete payment invoice',
            'send bill',
            'create payment bill',
            'delete payment bill',
            'income report',
            'expense report',
            'income vs expense report',
            'tax report',
            'loss & profit report',
            'manage transaction',
            'manage credit note',
            'create credit note',
            'edit credit note',
            'delete credit note',
            'manage debit note',
            'create debit note',
            'edit debit note',
            'delete debit note',
            'duplicate invoice',
            'duplicate bill',
            'manage proposal',
            'create proposal',
            'edit proposal',
            'delete proposal',
            'duplicate proposal',
            'send proposal',
            'show proposal',
            'delete proposal product',
            'manage goal',
            'create goal',
            'edit goal',
            'delete goal',
            'manage assets',
            'create assets',
            'edit assets',
            'delete assets',
            'statement report',
            'invoice report',
            'bill report',
            'manage constant custom field',
            'create constant custom field',
            'edit constant custom field',
            'delete constant custom field',
        ];

        foreach($companyPermissions as $ap)
        {
            $permission = Permission::findByName($ap);
            $companyRole->givePermissionTo($permission);
        }
        $company = User::create(
            [
                'name' => 'company',
                'email' => 'company@example.com',
                'password' => Hash::make('1234'),
                'type' => 'company',
                'lang' => 'en',
                'avatar' => '',
                'created_by' => 0,
            ]
        );
        $company->assignRole($companyRole);

        // accountant
        $accountantRole       = Role::create(
            [
                'name' => 'accountant',
                'created_by' => $company->id,
            ]
        );
        $accountantPermission = [
            'show dashboard',
            'manage expense',
            'create expense',
            'edit expense',
            'delete expense',
            'manage invoice',
            'create invoice',
            'edit invoice',
            'delete invoice',
            'show invoice',
            'convert invoice',
            'manage product & service',
            'create product & service',
            'delete product & service',
            'edit product & service',
            'manage constant tax',
            'create constant tax',
            'edit constant tax',
            'delete constant tax',
            'manage constant category',
            'create constant category',
            'edit constant category',
            'delete constant category',
            'manage constant unit',
            'create constant unit',
            'edit constant unit',
            'delete constant unit',
            'manage customer',
            'create customer',
            'edit customer',
            'delete customer',
            'show customer',
            'manage vender',
            'create vender',
            'edit vender',
            'delete vender',
            'show vender',
            'manage bank account',
            'create bank account',
            'edit bank account',
            'delete bank account',
            'manage transfer',
            'create transfer',
            'edit transfer',
            'delete transfer',
            'manage constant payment method',
            'create constant payment method',
            'edit constant payment method',
            'delete constant payment method',
            'manage revenue',
            'create revenue',
            'edit revenue',
            'delete revenue',
            'manage bill',
            'create bill',
            'edit bill',
            'delete bill',
            'show bill',
            'manage payment',
            'create payment',
            'edit payment',
            'delete payment',
            'delete invoice product',
            'delete bill product',
            'send invoice',
            'create payment invoice',
            'delete payment invoice',
            'send bill',
            'create payment bill',
            'delete payment bill',
            'income report',
            'expense report',
            'income vs expense report',
            'tax report',
            'loss & profit report',
            'manage transaction',
            'manage credit note',
            'create credit note',
            'edit credit note',
            'delete credit note',
            'manage debit note',
            'create debit note',
            'edit debit note',
            'delete debit note',
            'manage proposal',
            'create proposal',
            'edit proposal',
            'delete proposal',
            'duplicate proposal',
            'send proposal',
            'show proposal',
            'delete proposal product',
            'manage goal',
            'create goal',
            'edit goal',
            'delete goal',
            'manage assets',
            'create assets',
            'edit assets',
            'delete assets',
            'statement report',
            'invoice report',
            'bill report',
            'manage constant custom field',
            'create constant custom field',
            'edit constant custom field',
            'delete constant custom field',
        ];

        foreach($accountantPermission as $ap)
        {
            $permission = Permission::findByName($ap);
            $accountantRole->givePermissionTo($permission);
        }

        $accountant = User::create(
            [
                'name' => 'accountant',
                'email' => 'accountant@example.com',
                'password' => Hash::make('1234'),
                'type' => 'accountant',
                'lang' => 'en',
                'avatar' => '',
                'created_by' => $company->id,
            ]
        );
        $accountant->assignRole($accountantRole);

        \App\BankAccount::create(
            [
                'holder_name' => 'Cash',
                'bank_name' => '',
                'account_number' => '-',
                'opening_balance' => '0.00',
                'contact_number' => '-',
                'bank_address' => '-',
                'created_by' => $company->id,
            ]
        );

    }
}
