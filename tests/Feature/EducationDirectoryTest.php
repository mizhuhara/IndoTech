<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EducationDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_school_directory_uses_database_records(): void
    {
        School::create([
            'npsn' => '12345678',
            'name' => 'SMK Test Nusantara',
            'institution_type' => 'SMK IT',
            'city' => 'Bandung',
            'province' => 'Jawa Barat',
            'status' => 'Active',
            'tags' => ['RPL'],
            'total_students' => 100,
            'industry_partners' => 5,
        ]);

        $this->get(route('education.index'))
            ->assertOk()
            ->assertSee('SMK Test Nusantara');

        $this->get(route('education.show', '12345678'))
            ->assertOk()
            ->assertSee('SMK Test Nusantara')
            ->assertSee('RPL');
    }

    public function test_campus_directory_uses_database_records(): void
    {
        University::create([
            'npsn' => '87654321',
            'name' => 'Universitas Test',
            'type' => 'Negeri',
            'city' => 'Depok',
            'province' => 'Jawa Barat',
            'status' => 'Active',
            'tags' => ['Computer Science'],
            'total_students' => 1000,
            'total_faculties' => 10,
            'accreditation' => 'A',
            'founded' => 2000,
        ]);

        $this->get(route('campus.index'))
            ->assertOk()
            ->assertSee('Universitas Test');

        $this->get(route('campus.show', '87654321'))
            ->assertOk()
            ->assertSee('Universitas Test')
            ->assertSee('Computer Science');
    }

    public function test_inactive_institution_is_hidden(): void
    {
        School::create([
            'npsn' => '99999999',
            'name' => 'SMK Inactive',
            'status' => 'Inactive',
        ]);

        $this->get(route('education.index'))
            ->assertOk()
            ->assertDontSee('SMK Inactive');

        $this->get(route('education.show', '99999999'))->assertNotFound();
    }
}
