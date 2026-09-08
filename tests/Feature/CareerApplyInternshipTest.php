<?php

namespace Tests\Feature;

use App\Models\Internship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CareerApplyInternshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_internship_apply_form()
    {
        $internship = Internship::factory()->create();

        $response = $this->get(route('career.apply', $internship->id));

        $response->assertStatus(200);
        $response->assertViewIs('career.apply');
        $response->assertViewHas('job');
    }

    public function test_apply_form_displays_internship_details()
    {
        $internship = Internship::factory()->create([
            'title' => 'Backend Developer Internship',
            'company' => 'Tech Corp',
            'location' => 'Jakarta',
        ]);

        $response = $this->get(route('career.apply', $internship->id));

        $response->assertSee('Backend Developer Internship');
        $response->assertSee('Tech Corp');
        $response->assertSee('Jakarta');
    }

    public function test_can_submit_internship_application()
    {
        $internship = Internship::factory()->create();

        $response = $this->post(route('career.apply.store', $internship->id), [
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+62 812-3456-7890',
            'linkedin' => 'https://linkedin.com/in/johndoe',
            'portfolio' => 'https://github.com/johndoe',
            'cover_letter' => 'This is my cover letter for this internship position. I am very interested in this opportunity.',
            'resume' => \Illuminate\Http\UploadedFile::fake()->create('resume.pdf', 100),
        ]);

        $response->assertRedirect(route('career.index', ['type' => $internship->category]));
        $response->assertSessionHas('apply_success');
    }

    public function test_internship_apply_with_missing_required_fields()
    {
        $internship = Internship::factory()->create();

        $response = $this->post(route('career.apply.store', $internship->id), [
            'full_name' => 'John Doe',
            // missing other required fields
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email', 'phone', 'cover_letter', 'resume']);
    }
}
