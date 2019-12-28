<?php

namespace Tests\Unit;

use App\Models\Inquiry;
use Tests\TestCase;

class InquiryTest extends TestCase
{
    /** @test */
    public function regarding_is_聯絡我們_if_product_is_null()
    {
        $inquiry = factory(Inquiry::class)->make([
            'product' => null
        ]);

        $this->assertEquals('聯絡我們', $inquiry->regarding);
    }

    /** @test */
    public function regarding_is_詢問表單_if_product_is_not_null()
    {
        $inquiry = factory(Inquiry::class)->make([
            'product' => 'AProduct'
        ]);

        $this->assertEquals('詢問表單', $inquiry->regarding);

    }

    /** @test */
    public function can_know_processed_status()
    {
        $inquiry = factory(Inquiry::class)->make([
            'processed' => true
        ]);

        $this->assertEquals('已完成', $inquiry->processedStatus);

        $inquiry = factory(Inquiry::class)->make([
            'processed' => false
        ]);

        $this->assertEquals('未完成', $inquiry->processedStatus);
    }
}
