<?php

namespace Services\languages;

use App\Services\languages\Languages;
use PHPUnit\Framework\TestCase;

class LanguagesTest extends TestCase
{

    public function testRemoveAccents()
    {
        $case = [
            '' => '',
            'Chè Trần' => 'che tran',
            'a á à ả ã ạ' => 'a a a a a a',
            'â ấ ầ ẩ ẫ ậ' => 'a a a a a a',
            'ô ố ồ ổ ỗ ộ' => 'o o o o o o',
            'ơ ớ ờ ở ỡ ợ' => 'o o o o o o',
            'Nguyễn Trần Thị Thảo Nguyên Ngọc' => 'nguyen tran thi thao nguyen ngoc',
            'Đức Đ' => 'duc d'
        ];

        foreach ($case as $k => $v) {
            $this->assertEquals($v, Languages::RemoveAccents($k), "Case $k:");
        }
    }
}
