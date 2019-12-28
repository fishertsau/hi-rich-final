<?php

namespace Tests\Feature;

use App\Mail\UserContactEmail;
use Mail;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactAppTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
    }

    private function createNewContact($input)
    {
        return $this->post('contact', $input);
    }


    private function params($override = [])
    {
        return array_merge([
            'contact' => 'contactPerson',
            'email' => 'john@example.com',
            'tel' => '22226666',
            'message' => 'MessageContent'
        ], $override);
    }


    /** @test */
    public function can_visit_contactUs_input_page()
    {
        $response = $this->get('/contact');

        $response->assertSuccessful();
    }


    /** @test */
    public function can_create_a_contact()
    {
        $this->create(WebConfig::class,
            ['mail_receivers' => 'jane@example.com,jack@example.com']);

        $response = $this->createNewContact($this->params());

        $contact = Contact::first();
        $response->assertRedirect('/contact-ok');

        $this->assertEquals('contactPerson', $contact->contact);
        $this->assertEquals('john@example.com', $contact->email);
        $this->assertEquals('22226666', $contact->tel);
        $this->assertEquals('MessageContent', $contact->message);
        $this->assertFalse($contact->processed);

        // todo: remove this?
//        Mail::assertSent(UserContactEmail::class, function ($mail) use ($contact) {
//            return
//                $mail->hasTo('jane@example.com')
//                &&
//                $mail->hasTo('jack@example.com')
//                &&
//                $mail->contact->id == $contact->id;
//        });
    }

    /** @test */
    public function can_see_contact_ok_page()
    {
        $response = $this->get('/contact-ok');

        $response->assertSuccessful()
            ->assertSee('聯絡我們');
    }


    /** @test */
    public function contact_is_required_to_create_a_new_contact()
    {
        $this->withExceptionHandling();

        $response = $this->createNewContact($this->params(['contact' => '']));

        $this->assertValidationError($response, 'contact');
    }

    /** @test */
    public function email_is_required_to_create_a_new_contact()
    {
        $this->withExceptionHandling();

        $response = $this->createNewContact($this->params(['email' => '']));

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    public function message_is_required_to_create_a_new_contact()
    {
        $this->withExceptionHandling();

        $response = $this->createNewContact($this->params(['message' => '']));

        $this->assertValidationError($response, 'message');
    }
}
