<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Book;
use App\Models\Setting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;
use DB;

class BooksExport implements FromView, WithEvents, WithColumnWidths, ShouldAutoSize, WithDrawings
{
    public function __construct($tgl_awal, $tgl_akhir, $type) 
    {
        $this->rowCount  = 8;
        $this->tgl_awal  = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
        $this->type      = $type;
    }

    public function view(): View
    {
        switch ($this->type) {
            case 'Laporan Buku Berdasar Sumber Perolehan':
                $report = DB::table('books')
                    ->selectRaw('source.name as sumber, count(books.id) as total_judul, count(book_details.id) as total_exemplar')
                    ->leftJoin('book_details', 'book_details.book_id', '=', 'books.id')
                    ->rightJoin('source', 'source.id', '=', 'book_details.source_id')
                    ->whereRaw("book_details.created_at BETWEEN ? AND ?", [$this->tgl_awal." 00:00:00", $this->tgl_akhir." 23:59:59"])
                    ->groupBy('source.name');
                $view = 'admin.report.excel.excel_3';
                break;
            case 'Laporan Buku Berdasar Klasifikasi':
                $report = DB::table('books')
                    ->selectRaw('category.name as category, count(books.id) as total_judul, count(book_details.id) as total_exemplar')
                    ->leftJoin('book_details', 'book_details.book_id', '=', 'books.id')
                    ->rightJoin('category', 'category.id', '=', 'books.category_id')
                    ->whereRaw("book_details.created_at BETWEEN ? AND ?", [$this->tgl_awal." 00:00:00", $this->tgl_akhir." 23:59:59"])
                    ->groupBy('category.name');
                $view = 'admin.report.excel.excel_4';
                break;
            default:
                //
        }

        if (Auth::user()->location_id != '') {
            $report = $report->where('book_details.location_id', Auth::user()->location_id);
        }

        $report = $report->get();

        $this->rowCount += $report->count();

        $data = [
            'type'         => $this->type,
            'tgl_awal'     => Carbon::createFromFormat('Y-m-d', $this->tgl_awal)->format('d-m-Y'),
            'tgl_akhir'    => Carbon::createFromFormat('Y-m-d', $this->tgl_akhir)->format('d-m-Y'),
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
            'books'        => $report,
            'setting'      => Setting::first(),
        ];
        // echo view('admin.report.excel.excel_1', $data); die();
        return view($view, $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:D2';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(12)
                    ->setBold(true);

                $cellRange = 'A3:D3';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(11)
                    ->setBold(true);

                $cellRange = 'A4:D4';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(9)
                    ->setBold(true);

                $cellRange = 'A5:D5';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(8)
                    ->setBold(true);

                $cellRange = 'A1:D5';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $cellRange = 'A7:D'.$this->rowCount;
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A7:D'.$this->rowCount)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $cellRange = 'A'.($this->rowCount+1).':D'.($this->rowCount+8);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(8)
                    ->setBold(true);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/ARSIPUSDA.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('B2');

        return $drawing;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,    
            'B' => 85,
            'C' => 20,
            'D' => 20
        ];
    }
}
