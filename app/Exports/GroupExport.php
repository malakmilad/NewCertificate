<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GroupExport implements FromArray, WithMapping, WithHeadings, WithColumnWidths
{
    public function array():array
    {
        return [];
    }
    public function map($row): array
    {
        return [
            $row['student_name'],
            $row['email'],
            $row['uuid'],
            $row['phone'],
            $row['course_name'],
        ];
    }
    public function headings(): array
    {
        return [
            "Student Name",
            "Email",
            "National ID OR Passport ID",
            "Phone",
            "Course Name",
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 25,
            'D' => 50,
            'E' => 50,
        ];
    }

}
