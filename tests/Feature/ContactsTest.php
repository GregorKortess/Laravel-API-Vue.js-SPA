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
        $this->post('/api/contacts',$this->data());

        $contact = Contact::first();

        $this->assertEquals('Test name', $contact->name);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('09/03/1998', $contact->birthday);
        $this->assertEquals('ABC string', $contact->company);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['name','email','birthday','company'])
            ->each(function($field) {
                $response = $this->post('/api/contacts', array_merge($this->data(), [$field => '']));


                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Contact::all());
            });
    }


    private function data()
    {
        return [
            'name' => 'Test name',
            'email' => 'test@test.com',
            'birthday' => '09/03/1998',
            'company' => 'ABC string',
        ];
    }
}
