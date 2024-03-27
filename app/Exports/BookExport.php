<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class BookExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::all();
    }

    public function headings(): array
    {
        return [
            '#', // Nomor urutan
            'category_id',
            'utility_id',
            'book_title',
            'book_number',
            'location',
            'is_scan',
            'file_path',
            'file_path_url',
        ];
    }

    public function styles($sheet)
    {
        return [
            // Atur border untuk seluruh sel
            1 => ['font' => ['bold' => true]], // Atur teks pada baris pertama (header) menjadi tebal
            'A1:I1' => ['border' => ['bottom' => ['style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]], // Atur border bawah untuk baris pertama (header)
            'A2:I' . ($this->collection()->count() + 1) => ['border' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]], // Atur border untuk seluruh sel (termasuk header dan data)
        ];
    }
}
