<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Community;
use App\Models\Company;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContentAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_school_user_only_sees_own_school_and_cannot_create(): void
    {
        $schoolUser = User::factory()->create(['role' => 'school', 'status' => 'active']);
        $own = $this->school(['user_id' => $schoolUser->id, 'name' => 'Own School', 'npsn' => '11111111']);
        $other = $this->school(['name' => 'Other School', 'npsn' => '22222222']);

        $this->actingAs($schoolUser)
            ->get(route('admin.schools.index'))
            ->assertOk()
            ->assertSee($own->name)
            ->assertDontSee($other->name);

        $this->actingAs($schoolUser)
            ->get(route('admin.schools.show', $other->id))
            ->assertNotFound();

        $this->actingAs($schoolUser)
            ->get(route('admin.schools.create'))
            ->assertForbidden();
    }

    public function test_company_user_only_sees_own_company(): void
    {
        $companyUser = User::factory()->create(['role' => 'company', 'status' => 'active']);
        $own = Company::create([
            'user_id' => $companyUser->id,
            'name' => 'Own Company',
            'type' => 'Swasta',
            'industry' => 'Technology',
            'status' => 'Active',
        ]);
        $other = Company::create([
            'name' => 'Other Company',
            'type' => 'Swasta',
            'industry' => 'Finance',
            'status' => 'Active',
        ]);

        $this->actingAs($companyUser)
            ->get(route('admin.company.index'))
            ->assertOk()
            ->assertSee($own->name)
            ->assertDontSee($other->name);

        $this->actingAs($companyUser)
            ->get(route('admin.company.edit', $other->id))
            ->assertNotFound();
    }

    public function test_company_user_cannot_create_company_via_direct_post(): void
    {
        $companyUser = User::factory()->create(['role' => 'company', 'status' => 'active']);

        $this->actingAs($companyUser)->post(route('admin.company.store'), [
            'name' => 'PT Baru',
            'type' => 'Swasta',
            'industry' => 'Technology',
            'status' => 'Active',
        ])->assertForbidden();

        $this->assertDatabaseMissing('companies', ['name' => 'PT Baru']);
    }

    public function test_school_article_editor_only_sees_own_articles(): void
    {
        $schoolUser = User::factory()->create(['role' => 'school', 'status' => 'active']);
        $own = Article::create([
            'user_id' => $schoolUser->id,
            'title' => 'Own Article',
            'category' => 'Technology',
            'status' => 'published',
        ]);
        $other = Article::create([
            'title' => 'Other Article',
            'category' => 'Technology',
            'status' => 'published',
        ]);

        $this->actingAs($schoolUser)
            ->get(route('admin.articles.index'))
            ->assertOk()
            ->assertSee($own->title)
            ->assertDontSee($other->title);

        $this->actingAs($schoolUser)
            ->get(route('admin.articles.edit', $other->id))
            ->assertNotFound();
    }

    public function test_admin_can_create_and_delete_article(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.articles.store'), [
            'title' => 'Artikel Baru',
            'category' => 'Technology',
            'excerpt' => 'Ringkasan artikel.',
            'content' => 'Isi artikel.',
            'image_caption' => 'Ilustrasi arsitektur cloud modern',
            'tags' => 'Laravel, PHP',
            'status' => 'published',
        ])->assertRedirect(route('admin.articles.index'));

        $article = Article::where('title', 'Artikel Baru')->firstOrFail();
        $this->assertSame(['Laravel', 'PHP'], $article->tags);
        $this->assertSame('artikel-baru', $article->slug);
        $this->assertSame('Ilustrasi arsitektur cloud modern', $article->image_caption);

        $this->actingAs($admin)->put(route('admin.articles.update', $article->id), [
            'title' => 'Artikel Baru Diedit',
            'category' => 'Technology',
            'excerpt' => 'Ringkasan diedit.',
            'content' => 'Isi diedit.',
            'image_caption' => 'Caption gambar yang diperbarui',
            'status' => 'published',
        ])->assertRedirect(route('admin.articles.index'));

        $article->refresh();
        $this->assertSame('Caption gambar yang diperbarui', $article->image_caption);

        $this->actingAs($admin)
            ->delete(route('admin.articles.destroy', $article->id))
            ->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_admin_can_update_and_delete_community(): void
    {
        $admin = $this->admin();
        $community = Community::create([
            'name' => 'Community Lama',
            'category' => 'Technology',
            'members' => 10,
            'status' => 'active',
        ]);

        $this->actingAs($admin)->put(route('admin.community.update', $community->id), [
            'name' => 'Community Baru',
            'category' => 'Design',
            'description' => 'Komunitas baru.',
            'website' => 'https://example.com',
            'email' => 'hello@example.com',
            'status' => 'inactive',
        ])->assertRedirect(route('admin.community.index'));

        $this->assertDatabaseHas('communities', [
            'id' => $community->id,
            'name' => 'Community Baru',
            'category' => 'Design',
            'status' => 'inactive',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.community.destroy', $community->id))
            ->assertRedirect(route('admin.community.index'));

        $this->assertDatabaseMissing('communities', ['id' => $community->id]);
    }

    public function test_admin_can_create_update_and_delete_school(): void
    {
        $admin = $this->admin();
        $payload = [
            'npsn' => '33333333',
            'name' => 'SMK Baru',
            'institution_type' => 'SMK IT',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'location' => 'Jakarta Selatan',
            'status' => 'Active',
        ];

        $this->actingAs($admin)
            ->post(route('admin.schools.store'), $payload)
            ->assertRedirect(route('admin.schools.index'));

        $school = School::where('npsn', '33333333')->firstOrFail();

        $this->actingAs($admin)->put(route('admin.schools.update', $school->id), [
            ...$payload,
            'name' => 'SMK Baru Diperbarui',
        ])->assertRedirect(route('admin.schools.index'));

        $this->assertDatabaseHas('schools', [
            'id' => $school->id,
            'name' => 'SMK Baru Diperbarui',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.schools.destroy', $school->id))
            ->assertRedirect(route('admin.schools.index'));

        $this->assertDatabaseMissing('schools', ['id' => $school->id]);
    }

    public function test_admin_can_create_and_delete_company(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.company.store'), [
            'name' => 'PT Baru',
            'type' => 'Swasta',
            'industry' => 'Technology',
            'city' => 'Bandung',
            'province' => 'Jawa Barat',
            'status' => 'Active',
        ])->assertRedirect(route('admin.company.index'));

        $company = Company::where('name', 'PT Baru')->firstOrFail();
        $this->assertSame('Bandung, Jawa Barat', $company->location);

        $this->actingAs($admin)
            ->delete(route('admin.company.destroy', $company->id))
            ->assertRedirect(route('admin.company.index'));

        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    private function admin(): User
    {
        return User::factory()->create([
            'email' => User::ADMIN_EMAIL,
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }

    private function school(array $attributes = []): School
    {
        return School::create(array_merge([
            'name' => 'School',
            'npsn' => '99999999',
            'institution_type' => 'SMK IT',
            'location' => 'Jakarta',
            'status' => 'Active',
        ], $attributes));
    }
}
