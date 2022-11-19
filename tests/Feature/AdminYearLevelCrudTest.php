<?php

namespace Tests\Feature;

use App\Models\YearLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminYearLevelCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_dashboard()
    {
        $adminUser = $this->signInAsAdmin();

        $this->actingAs($adminUser);

        $response = $this->get('/admin_dashboard');

        $response->assertSeeText('ADMIN DASH BOARD')->assertStatus(200);
    }

    public function test_admin_no_year_level(){
        $adminUser = $this->signInAsAdmin();

        $this->actingAs($adminUser);

        $response = $this->get('/admin/year');

        $response->assertDontSeeText('11');
    }

    public function test_admin_one_year_level(){

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser);

        $yL = YearLevel::factory()->create(
            [
                'level'=> 11,
            ]
        );

        $response = $this->get('/admin/year');

        $response->assertSeeText(11);
    }

    public function test_admin_year_level_creation(){

        $params = [
            'level' => 10
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->post('admin/year', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), "Grade level {$params['level']} was successfully added ");

        $this->assertDatabaseHas('year_levels', [
            'level' => $params['level'],
        ]);
    }

    public function test_admin_year_level_creation_error(){

        $params = [
            'level' => ""
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->post('admin/year', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        
        $error_message = session('errors')->getMessages();

        $this->assertEquals($error_message['level'][0], 'The level field is required.');
    }

    public function test_admin_year_level_updation(){
        $yL = YearLevel::factory()->create_for_test()->create();

        $this->assertDatabaseHas('year_levels',[
            'level' => 11,
        ]);

        $params = [
            'level' => 12
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->put("admin/year/{$yL->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), "Grade level {$params['level']} was successfully updated ");
        $this->assertDatabaseMissing('year_levels', [
            'level' => 11,
        ]);
    }

    public function test_admin_year_level_delete(){
        $yL = YearLevel::factory()->create_for_test()->create();

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->delete("admin/year/{$yL->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals( session('status'), 'Grade level was successfully deleted ' );

        // $this->assertDatabaseMissing('year_levels',[
        //     'level' => $yL->level
        // ]);

        $this->assertSoftDeleted('year_levels', [
            'level' => $yL->level
        ]);

    }
}
