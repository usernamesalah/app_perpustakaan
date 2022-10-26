<?php

namespace App\Exports;

use App\Models\Member;
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

class MembersExport implements FromView, WithEvents, WithColumnWidths, ShouldAutoSize, WithDrawings
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
            case 'Laporan Anggota Berdasarkan Jenis Keanggotaan':
                $report = DB::table('members')
                    ->selectRaw('count(members.id) as total, type.name as type')
                    ->rightJoin('type', 'members.type', '=', 'type.id')
                    ->whereRaw("members.created_at BETWEEN ? AND ?", [$this->tgl_awal." 00:00:00", $this->tgl_akhir." 23:59:59"])
                    ->groupBy('type.name')
                    ->get();
                $view = 'admin.report.excel.excel_1';
                break;
            case 'Laporan Anggota Berdasar Jenis Kelamin':
                $report = DB::table('members')
                    ->selectRaw('count(members.id) as total, gender.name as gender')
                    ->rightJoin('gender', 'members.gender', '=', 'gender.id')
                    ->whereRaw("members.created_at BETWEEN ? AND ?", [$this->tgl_awal." 00:00:00", $this->tgl_akhir." 23:59:59"])
                    ->groupBy('gender.name')
                    ->get();
                $view = 'admin.report.excel.excel_2';
                break;
            default:
                //
        }

        $this->rowCount += $report->count();

        $data = [
            'type'         => $this->type,
            'tgl_awal'     => Carbon::createFromFormat('Y-m-d', $this->tgl_awal)->format('d-m-Y'),
            'tgl_akhir'    => Carbon::createFromFormat('Y-m-d', $this->tgl_akhir)->format('d-m-Y'),
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
            'members'      => $report,
            'setting'      => Setting::first(),
        ];
        // echo view('admin.report.excel.excel_1', $data); die();
        return view($view, $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:C2';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(12)
                    ->setBold(true);

                $cellRange = 'A3:C3';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(11)
                    ->setBold(true);

                $cellRange = 'A4:C4';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(9)
                    ->setBold(true);

                $cellRange = 'A5:C5';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(8)
                    ->setBold(true);

                $cellRange = 'A1:C5';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $cellRange = 'A7:C'.$this->rowCount;
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A7:C'.$this->rowCount)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $cellRange = 'A'.($this->rowCount+1).':C'.($this->rowCount+8);
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
            'B' => 110,
            'C' => 15    
        ];
    }
}
