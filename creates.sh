php artisan make:migration create_marital_status_table --create=marital_status
php artisan make:migration create_addresses_table --create=addresses
php artisan make:migration create_cities_table --create=cities
php artisan make:migration create_states_table --create=states
php artisan make:migration create_user_references_table --create=user_references
php artisan make:migration create_references_table --create=references
php artisan make:migration create_user_loans_table --create=user_loans
php artisan make:migration create_loan_modalities_table --create=loan_modalities

php artisan make:model MaritalStatus
php artisan make:model Address
php artisan make:model City
php artisan make:model State
php artisan make:model UserReference
php artisan make:model Reference
php artisan make:model UserLoan
php artisan make:model LoanModality
