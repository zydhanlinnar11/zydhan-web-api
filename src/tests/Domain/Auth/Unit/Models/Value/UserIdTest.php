<?php

use Domain\Auth\Models\Value\UserId;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UserIdTest extends TestCase
{
    public function testBisaDiinstansiasi()
    {
        $this->assertInstanceOf(UserId::class, new UserId(Uuid::uuid4()));
    }

    public function testTidakBisaDiinstansiasiJikaBukanUuid()
    {
        $this->expectException(\Exception::class);
        new UserId(Str::random(6));
    }
}
