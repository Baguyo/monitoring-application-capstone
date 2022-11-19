<?php

namespace Tests\Feature;

use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use App\Models\YearLevel;
use Database\Factories\StudentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminStudentCrudTest extends TestCase
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

        $response = $this->get('/admin/student');

        $response->assertSeeText('ADMIN | Students');
    }

    public function test_admin_one_student(){

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser);

        $student = $this->create_student_test();

        $response = $this->get('/admin/student');

        $response->assertSeeText($student->guardian);
        $this->assertDatabaseHas('students',[
            'address' => $student->address
        ]);
    }

    public function test_admin_section_creation(){
        
        $yL = YearLevel::factory()->create_for_test()->create();
        $section = Section::factory()->create([
            'year_level_id' => $yL->id
        ]);


        $params = [
            'name' => 'dodoy',
            'email' => 'dodoy@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'guardian' => 'marites',
            'contact_number' => 639303646430,
            'level'=>'1',
            'address' => 'san pedro',
            'section' => $section->id,
            
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->post('admin/student', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), "New student {$params['name']} was successfully added");

        $this->assertDatabaseHas('students', [  
            'guardian' => $params['guardian'],
            'address' => $params['address'],
        ]);
    }

    public function test_admin_section_creation_error(){

        $yL = YearLevel::factory()->create_for_test()->create();
        $section = Section::factory()->create([
            'year_level_id' => $yL->id
        ]);


        $params = [
            'name' => '',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
            'guardian' => 'marites',
            'contact_number' => 639303646430,
            'level'=>'1',
            'address' => 'san pedro',
            'section' => $section->id,
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->post('admin/student', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        
        $error_message = session('errors')->getMessages();

        $this->assertEquals($error_message['name'][0], 'The name field is required.');
        $this->assertEquals($error_message['email'][0], 'The email field is required.');
    }

    public function test_admin_section_updation(){
        $student = $this->create_student_test();

        $this->assertDatabaseHas('students',[
            'id' => $student->id
        ]);

        $params = [
            'name' => $student->user->name,
            'email' => $student->user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'guardian' => 'marites2',
            'contact_number' => 639303646430,
            'level'=>$student->section->yearLevel->id,
            'address' => $student->address,
            'section' => $student->section_id,
        ];

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->put("admin/student/{$student->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), "Student {$params['name']} was successfully updated");
        $this->assertDatabaseMissing('students', [
            'guardian' => $student->guardian,
        ]);
    }

    public function test_admin_section_delete(){
        $student = $this->create_student_test();

        $adminUser = $this->signInAsAdmin();
        $this->actingAs($adminUser)
            ->delete("admin/student/{$student->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals( session('status'), "Student {$student->user->name} was successfully deleted" );

        // $this->assertDatabaseMissing('sections',[
        //     'level' => $yL->level
        // ]);

        $this->assertSoftDeleted('students', [
            'guardian' => $student->guardian
        ]);

    }


    /**
     * @return Student model
     */
    public function create_student_test(){
        

        $user = User::factory()->create();

        $yL = YearLevel::factory()->create_for_test()->create();

        $section = Section::factory()->create([
            'year_level_id' => $yL->id,
        ]);
        
        $student = Student::factory()->create([
            'user_id'=> $user->id,
            'section_id'=> $section->id
        ]);
        return $student;
        


    }

    
}
