<?php

namespace Tests\Feature;

use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_contact_can_be_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/api/contacts',[
            'name' => 'Test name',
            'email' => 'test@test.com',
            'birthday' => '09/03/1998',
            'company' => 'ABC string',
        ]);

        $contact = Contact::first();

        $this->assertEquals('Test name', $contact->name);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('09/03/1998', $contact->birthday);
        $this->assertEquals('ABC string', $contact->company);
    }


    /** @test */
    public function a_name_is_required()
    {
        $response = $this->post('/api/contacts', [
            'email' => 'test@test.com',
            'birthday' => '09/03/1998',
            'company' => 'ABC string',
        ]);


        $response->assertSessionHasErrors('name');
        $this->assertCount(0,Contact::all());

    }


    /** @test */
    public function a_email_is_required()
    {
        $response = $this->post('/api/contacts', [
            'name' => 'Test name',
            'birthday' => '09/03/1998',
            'company' => 'ABC string',
        ]);


        $response->assertSessionHasErrors('email');
        $this->assertCount(0,Contact::all());

    }
}
