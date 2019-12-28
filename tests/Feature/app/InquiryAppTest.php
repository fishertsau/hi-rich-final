<?php

namespace Tests\Feature;

use Mail;
use Tests\TestCase;
use App\Models\Inquiry;
use App\Models\WebConfig;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InquiryAppTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
    }

    private function creteNewInquiry($input)
    {
        return $this->post('inquiries', $input);
    }

    private function params($override = [])
    {
        return array_merge([
            'company_name' => 'CompanyName',
            'contact' => 'contactPerson',
            'address' => 'Address',
            'tel' => '22226666',
            'fax' => '22228888',
            'email' => 'john@example.com',
            'material' => 'Material',
            'purpose' => 'Purpose',
            'spec' => 'Specification',
            'estimated_qty' => 'EstimatedQuantity',
            'viscosity' => 'Viscosity',
            'surface_treatment' => 'SurfaceTreatment',
            'packing' => 'Packing',
            'print_out' => 'PrintOut',
        ], $override);
    }

    /** @test */
    public function can_visit_inquiry_input_page()
    {
        $this->markTestSkipped('This test is not required for this project.');
        $response = $this->get('/inquiries');

        $response->assertSuccessful()
            ->assertSee('公司名稱')
            ->assertSee('出標方式');
    }

    /** @test */
    public function can_create_a_new_inquiry()
    {
        $this->markTestSkipped('This test is not required for this project.');

        $this->create(WebConfig::class,
            ['mail_receivers' => 'jane@example.com,jack@example.com']);

        $response = $this->creteNewInquiry($this->params());

        $inquiry = Inquiry::first();
        $response->assertRedirect('/inquiry-ok');

        $this->assertEquals('CompanyName', $inquiry->company_name);
        $this->assertEquals('contactPerson', $inquiry->contact);
        $this->assertEquals('Address', $inquiry->address);
        $this->assertEquals('22226666', $inquiry->tel);
        $this->assertEquals('22228888', $inquiry->fax);
        $this->assertEquals('john@example.com', $inquiry->email);
        $this->assertEquals('Material', $inquiry->material);
        $this->assertEquals('Purpose', $inquiry->purpose);
        $this->assertEquals('Specification', $inquiry->spec);
        $this->assertEquals('EstimatedQuantity', $inquiry->estimated_qty);
        $this->assertEquals('Viscosity', $inquiry->viscosity);
        $this->assertEquals('SurfaceTreatment', $inquiry->surface_treatment);
        $this->assertEquals('Packing', $inquiry->packing);
        $this->assertEquals('PrintOut', $inquiry->print_out);
        $this->assertFalse($inquiry->processed);

        //todo: this should be tested
//        Mail::assertSent(UserInquiryEmail::class, function ($mail) use ($inquiry) {
//            return
//                $mail->hasTo('jane@example.com')
//                &&
//                $mail->hasTo('jack@example.com')
//                &&
//                $mail->inquiry->id == $inquiry->id;
//        });
    }

    /** @test */
    public function can_see_inquiry_ok_page()
    {
        $this->markTestSkipped('This test is not required for this project.');

        $response = $this->get('/inquiry-ok');

        $response->assertSuccessful()
            ->assertSee('詢價項目');
    }

    /** @test */
    public function company_name_is_required_to_create_an_new_inquiry()
    {
        $this->markTestSkipped('This test is not required for this project.');

        $this->withExceptionHandling();

        $response = $this->creteNewInquiry($this->params(['company_name' => '']));

        $this->assertValidationError($response, 'company_name');
    }

    /** @test */
    public function contact_name_is_required_to_create_an_new_inquiry()
    {
        $this->markTestSkipped('This test is not required for this project.');


        $this->withExceptionHandling();

        $response = $this->creteNewInquiry($this->params(['contact' => '']));

        $this->assertValidationError($response, 'contact');
    }

    /** @test */
    public function address_is_required_to_create_an_new_inquiry()
    {
        $this->markTestSkipped('This test is not required for this project.');

        $this->withExceptionHandling();

        $response = $this->creteNewInquiry($this->params(['address' => '']));

        $this->assertValidationError($response, 'address');
    }

    /** @test */
    public function tel_is_required_to_create_an_new_inquiry()
    {
        $this->markTestSkipped('This test is not required for this project.');

        $this->withExceptionHandling();

        $response = $this->creteNewInquiry($this->params(['tel' => '']));

        $this->assertValidationError($response, 'tel');
    }


    /** @test */
    public function fax_is_optional_to_create_an_new_inquiry()
    {
        $this->markTestSkipped('This test is not required for this project.');

        $response = $this->creteNewInquiry($this->params(['fax' => '']));

        $response->assertRedirect('/inquiry-ok');
    }

    /** @test */
    public function email_is_required_to_create_an_new_inquiry()
    {
        $this->markTestSkipped('This test is not required for this project.');

        $this->withExceptionHandling();

        $response = $this->creteNewInquiry($this->params(['email' => '']));

        $this->assertValidationError($response, 'email');
    }
}
