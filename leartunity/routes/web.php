<?php

use App\Classes\Points;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Authenticate;
use App\Interfaces\LinkedList;
use App\Mail\EmailVerification;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SearchController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Classes\CurrencyExchanger;
use Stripe\Stripe;
use function App\Helpers\exchange_rate;
use App\Models\Currency;
use Stripe\Account;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Testing Routes 
Route::get("test", function () {
    $stripe = Stripe::setApiKey(env("STRIPE_SECRET"));


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
    
    dd($accountId);
    // ... (Handle successful account creation)

} catch (\Exception $e) {
    // Handle potential errors during account creation
    dd($e->getMessage());

    // ... (Handle error and provide feedback to the user)
}

    // $user = User::first();
    // dd(exchange_rate("INR"));
    // // $exchanger = new CurrencyExchanger();
    // dd($exchanger->rate("inr"));
    // Mail::to("habbas2121@outlook.com")->send(new EmailVerification(User::find(1)));

    // dd("Sent");
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get("certificate", function() {
    $customPaper = array(0,0,1056,516);
    $name = "hashim";
    $duration = "1";
    $course_title = "The Data Science";
    $awarded_date = \Carbon\Carbon::now();
    $pdf = Pdf::loadView("certification", compact("name", "duration", "course_title", "awarded_date"))->setPaper($customPaper);
    $pdf = $pdf->stream();
    return $pdf;
});

Route::get("poly", function(Points $points) {
    // $course = Course::first();
    // $value = [
    //     [
    //         "name" => "Hashim Abbas",
    //         "status" => "true",
    //         "stars" => "4.3",
    //         "review" => "It was such an amazing course!"
    //     ]
    // ];
    // $course->reviews()->create([
    //     "reviews" => json_encode($value),
    //     "status" => true
    // ]);
    // $array = [
    //     "Welcome to this section. This is what you will learn!" => 1,
    //     "What is a Vector?" => 1,
    //     "Let's create some vectors" => 1,
    //     "Using the [] brackets" => 1,
    //     "Vectorized operations" => 0,
    //     "The power of vectorized operations" => 1,
    //     "Functions in R" => 1,
    //     "Packages in R" => 1,
    //     "Section Recap" => 1,
    //     "HOMEWORK: Financial Statement Analysis" => 1,
    //     "Fundamentals of R" => 1
    // ];
    // $section = Section::where("id", 3)->first();
    // $loop = 1;
    // foreach($array as $lessonName => $status) {
    //     $section->contents()->create([
    //         "title" => $lessonName,
    //         "status" => 1,
    //         "is_paid" => $status,
    //         "content" => "dummy.mp4",
    //         "duration" => 400,
    //         "sequence" => $loop, 
    //         "description" => "[Mastering R Basics]: Learn the fundamental concepts and techniques of the R programming language, essential for data analysis and statistical modeling."
    //     ]);
    //     $loop++;
    // }
    // dd("Created!");
    // $points->add(User::find(auth()->id()), 50);
    // dd("it must be created");
});

Route::get("withdraw", function() {
    \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
    \Stripe\Transfer::create([
        "amount" => 1000,
        "currency" => "usd",
        "destination"=> "4242424242424242",
    ]);
});

Route::get("serviceTest", function(LinkedList $list) {
    $section = Section::find(13);
    dd($list->get_last($section));
});

Route::group([ 'middleware' => ['web', "guest"] ], function() {
    Route::get("login", [SessionController::class, "index"]);
    Route::post("login", [SessionController::class, "create"])
        ->name("login");
    Route::get("register", [SessionController::class, "register"])->name("register");
    Route::post("register", [UserController::class, "store"])->name("register");
});
Route::group([ "middleware" => "auth" ], function() {
    Route::get("logout", [SessionController::class, "logout"])->name("logout");
});

Route::get('/', [HomeController::class, "index"])->name("home");
Route::get("/course/{course:slug}", [CourseController::class, "get"])->name("course");

Route::get("content/{content:id}", [ContentController::class, "get"])->name("getContent");

Route::get("courses", [CourseController::class, "getCourses"])->name("courseList");
Route::post("get/courses/{status?}", [CourseController::class, "getData"])->name("getCourses");

Route::get("ajaxCourses", [CourseController::class, "ajax"]);

Route::get("/profile/{id}", [ProfileController::class, "index"]);

Route::post("/preview", function() {
    return Str::markdown(request()->get("value"), [
        "html_input" => 'strip'
    ]);
});

