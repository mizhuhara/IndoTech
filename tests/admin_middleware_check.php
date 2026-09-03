<?php
// Self-check: admin routes wrapped with 'admin' middleware. Run: php tests/admin_middleware_check.php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$router = app('router');
$r = $router->getRoutes()->getByName('admin.schools.index');
assert($r !== null, 'admin.schools.index route missing');
$mw = $r->gatherMiddleware();
assert(in_array('admin', $mw, true), "admin middleware missing on admin.schools.index, got: ".implode(',', $mw));

// non-admin route must NOT have admin middleware
$l = $router->getRoutes()->getByName('career.index');
$lmw = $l->gatherMiddleware();
assert(!in_array('admin', $lmw, true), 'admin middleware leaked to career.index');

echo "OK: admin routes protected, non-admin clean\n";
