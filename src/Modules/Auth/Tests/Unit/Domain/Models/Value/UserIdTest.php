<?php

use Illuminate\Support\Str;
use Modules\Auth\Domain\Models\Value\UserId;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserIdTest extends TestCase
{
    public function testBisaDiinstansiasi()
    {
        $this->assertInstanceOf(UserId::class, new UserId(Uuid::uuid4()));
    }

    public function testGenerateJikaParameterNull()
    {
        $userId = new UserId();

        $this->assertInstanceOf(UserId::class, new UserId(Uuid::uuid4()));
        $this->assertNotNull($userId->getId());
    }

    public function testTidakBisaDiinstansiasiJikaBukanUuid()
    {
        $this->expectException(\Exception::class);
        new UserId(Str::random(6));
    }
}
