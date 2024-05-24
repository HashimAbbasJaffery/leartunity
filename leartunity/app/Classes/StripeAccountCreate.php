<?php 

namespace App\Classes;
use Stripe\Stripe;
use Stripe\Account;


class StripeAccountCreate {
    public function create() {
        Stripe::setApiKey(env("STRIPE_SECRET"));


        // User information (replace with actual values)
        $userData = [
            'email' => 'user@example.com',
            'country' => 'US',
        ];
        
        try {
            // Create the Stripe Connect account
            $account = Account::create([
                'country' => 'US',
                'controller' => [
                  'losses' => ['payments' => 'application'],
                  'fees' => ['payer' => 'application'],
                  'stripe_dashboard' => ['type' => 'none'],
                  'requirement_collection' => 'application',
                ],
                'business_type' => 'company',
                'capabilities' => [
                  'card_payments' => ['requested' => true],
                  'transfers' => ['requested' => true],
                ],
                'external_account' => 'btok_us',
                'tos_acceptance' => [
                  'date' => 1547923073,
                  'ip' => '172.18.80.19',
                ],
              ]);
        
            // Store the account ID for further use
            $accountId = $account;
            $account = Account::update($account->id, [
                'business_profile' => [
                  'mcc' => '5045',
                  'url' => 'https://bestcookieco.com',
                ],
                'company' => [
                  'address' => [
                    'city' => 'Schenectady',
                    'line1' => '123 State St',
                    'postal_code' => '12345',
                    'state' => 'NY',
                  ],
                  'tax_id' => '000000000',
                  'name' => 'The Best Cookie Co',
                  'phone' => '8888675309',
                ],
            ]);
            $person = Account::createPerson($accountId->id, [
                'first_name' => 'Jenny',
                'last_name' => 'Rosen',
                'relationship' => [
                  'representative' => true,
                  'title' => 'CEO',
                ],
            ]);
            Account::updatePerson($accountId->id, $person->id, [
                
            'address' => [
                'city' => 'Schenectady',
                'line1' => '123 State St',
                'postal_code' => '12345',
                'state' => 'NY',
              ],
              'dob' => [
                'day' => 01,
                'month' => 01,
                'year' => 1902,
              ],
              'ssn_last_4' => '0000',
              'phone' => '8888675309',
              'email' => 'jenny@bestcookieco.com',
              'relationship' => ['executive' => true],
            ]);
        
            $accountPerson = Account::updatePerson($accountId->id, $person->id, [
                [
                    'first_name' => 'Kathleen',
                    'last_name' => 'Banks',
                    'email' => 'kathleen@bestcookieco.com',
                    'relationship' => [
                      'owner' => true,
                      'percent_ownership' => 80,
                    ],
                  ]
                ]);
            $testingAccount = Account::update($account->id, 
            ['company' => ['owners_provided' => true]]);
            
            return $accountId->id;
            // ... (Handle successful account creation)
        
        } catch (\Exception $e) {
            // Handle potential errors during account creation
            dd($e->getMessage());
        
            // ... (Handle error and provide feedback to the user)
        }
        
    }
}