<?php

namespace Tests\Feature;

use App\Models\Section;
use App\Models\YearLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminSectionCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_admin_dashboard()
    // {
    //     $adminUser = $this->signInAsAdmin();

    //     $this->actingAs($adminUser);

    //     $response = $this->get('/admin_dashboard');

    //     $response->assertSeeText('ADMIN DASH BOARD')->assertStatus(200);
    // }

    public function test_admin_no_section(){
        $adminUser = $this->signInAsAdmin();

        $this->actingAs($adminUser);

        $response = $this->get('/admin/section');

        $response->assertDontSeeText('11');
    }

    public function test_admin_one_section(){

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser);

        $yL = YearLevel::factory()->create_for_test()->create();

        $section = Section::factory()->create([
            'year_level_id' => $yL->id,
        ]);

        $response = $this->get('/admin/section');

        $response->assertSeeText($section->name);
        $this->assertDatabaseHas('sections',[
            'name' => $section->name
        ]);
    }

    public function test_admin_section_creation(){

        $yL = YearLevel::factory()->create_for_test()->create();


        $params = [
            'section' => "magsaysay",
            'level' => $yL->id,
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->post('admin/section', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), "Section {$params['section']} was successfully created");

        $this->assertDatabaseHas('sections', [  
            'year_level_id' => $params['level'],
            'name' => $params['section'],
        ]);
    }

    public function test_admin_section_creation_error(){

        $params = [
            'level' => "",
            'section'=> ''
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->post('admin/section', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        
        $error_message = session('errors')->getMessages();

        $this->assertEquals($error_message['level'][0], 'The level field is required.');
        $this->assertEquals($error_message['section'][0], 'The section field is required.');
    }

    public function test_admin_section_updation(){
        $yL = YearLevel::factory()->create_for_test()->create();
        $section = Section::factory()->create(
            [
                'year_level_id' => $yL->id
            ]
            );

        $this->assertDatabaseHas('sections',[
            'id'=>$section->id
        ]);

        $params = [
            'level' => $yL->id,
            'section'=> 'Rizal'
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->put("admin/section/{$section->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), "Section {$params['section']} was successfully updated");
        $this->assertDatabaseMissing('sections', [
            'name' => $section->name,
        ]);
    }

    public function test_admin_section_delete(){
        $yL = YearLevel::factory()->create_for_test()->create();
        $section = Section::factory()->create(
            [
                'year_level_id' => $yL->id
            ]
            );

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->delete("admin/section/{$section->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals( session('status'), "Section {$section->name} was successfully deleted" );

        // $this->assertDatabaseMissing('sections',[
        //     'level' => $yL->level
        // ]);

        $this->assertSoftDeleted('sections', [
            'name' => $section->name
        ]);

    }

    
}
