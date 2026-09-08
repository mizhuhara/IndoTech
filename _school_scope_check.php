<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\School;
use App\Models\User;

$pass = 0; $fail = 0;
function check($label, $cond) { global $pass, $fail; if ($cond) { $pass++; echo "PASS  $label\n"; } else { $fail++; echo "FAIL  $label\n"; } }

// Setup: user school + sekolah miliknya
$owner = User::firstOrCreate(
    ['email' => 'ownertest@example.com'],
    ['name' => 'Owner Test', 'password' => bcrypt('password123'), 'role' => 'school', 'status' => 'active']
);
$own = School::firstOrCreate(
    ['npsn' => 'OWN00001'],
    ['user_id' => $owner->id, 'name' => 'Sekolah Owner', 'institution_type' => 'SMK IT', 'status' => 'Active']
);
$other = School::firstOrCreate(
    ['npsn' => 'OTH00001'],
    ['name' => 'Sekolah Lain', 'institution_type' => 'SMK IT', 'status' => 'Active', 'user_id' => null]
);

auth()->login($owner);

// visibleSchools: role school HANYA miliknya
$ids = (new ReflectionMethod(\App\Http\Controllers\AdminSchoolController::class, 'visibleSchools'))
    ->invoke(app(\App\Http\Controllers\AdminSchoolController::class))->pluck('id')->all();
check('school hanya lihat miliknya', in_array($own->id, $ids) && ! in_array($other->id, $ids));

// findVisibleSchool: akses milik sendiri OK
try {
    app(\App\Http\Controllers\AdminSchoolController::class)->show($own->id);
    check('bisa lihat sekolah sendiri', true);
} catch (\Throwable $e) { check('bisa lihat sekolah sendiri', false); }

// findVisibleSchool: akses punya orang lain -> 404
try {
    app(\App\Http\Controllers\AdminSchoolController::class)->show($other->id);
    check('tolak lihat sekolah orang lain', false);
} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    check('tolak lihat sekolah orang lain', true);
}

// Cleanup
$own->delete(); $other->delete(); $owner->delete();

echo "\n$pass pass, $fail fail\n";