<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Book;
use App\Models\BookDetail;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Location;
use App\Models\Category;
use App\Models\Source;
use App\Models\Status;
use Cviebrock\EloquentSluggable\Services\SlugService;
use DB;

class BookImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // echo json_encode($rows); die;

        $this->author    = Author::pluck('id', 'name')->toArray();
        $this->category  = Category::pluck('id', 'kode')->toArray();
        $this->publisher = Publisher::pluck('id', 'name')->toArray();
        $this->location  = Location::pluck('id', 'name')->toArray();
        $this->source    = Source::pluck('id', 'name')->toArray();

        foreach ($rows as $row)
        {
            $book = array();
            if ($row['isbn'] != '') {
                $book = Book::where('isbn', $row['isbn'])->first();
            }

            if (!$book) {

                $data = [
                    'title'             => $row['judul_utama'],
                    'synopsis'          => $row['anak_judul'],
                    'isbn'              => $row['isbn'],
                    'year_publication'  => $row['tahun'],
                    'jumlah_halaman'    => $row['halaman'],
                    'berat'             => 0,
                    'book_main_image'   => '',
                    'slug'              => SlugService::createSlug(Book::class, 'slug', $row['judul_utama'])
                ];

                if (key_exists($row['pengarang'], $this->author)) {
                    $data['author_id'] = $this->author[$row['pengarang']];
                }
                elseif ($row['pengarang'] != '') {
                    $author = Author::create([
                        'name' => $row['pengarang'],
                    ]);
                    $data['author_id'] = $author->id;
                    $this->author = Author::pluck('id', 'name')->toArray();
                }

                if (key_exists($row['kategori_kelas_ddc'], $this->category)) {
                    $data['category_id'] = $this->category[$row['kategori_kelas_ddc']];
                }
                else {
                    $category = Category::create([
                        'kode'  => $row['kategori_kelas_ddc'],
                        'name'  => $row['kategori_kelas_ddc'],
                        'slug'  => SlugService::createSlug(Category::class, 'slug', $row['kategori_kelas_ddc']),
                    ]);
                    $data['category_id'] = $category->id;
                    $this->category = Category::pluck('id', 'kode')->toArray();
                }

                if  (key_exists($row['penerbit'], $this->publisher)) {
                    $data['publisher_id'] = $this->publisher[$row['penerbit']];
                }
                elseif ($row['penerbit'] != '') {
                    $publisher = Publisher::create([
                        'name' => $row['penerbit'],
                    ]);
                    $data['publisher_id'] = $publisher->id;
                    $this->publisher = Publisher::pluck('id', 'name')->toArray();
                }

                $dimensi = strtoupper($row['dimensi']);
                $dimensi = strtoupper($dimensi);
                $idx     = strpos($dimensi, 'CM');
                $dimensi = substr_replace($dimensi, '', $idx);

                // $dimensi = str_replace('CM', '', $dimensi);
                $dimensi = trim($dimensi);
                $strpos  = strpos($dimensi, 'X');
                if ($strpos)
                {
                    $dimensi = explode("X",$dimensi);
                    $panjang = str_replace(',', '.', $dimensi[0]);
                    $lebar   = str_replace(',', '.', $dimensi[1]);
                }
                else {
                    $panjang = str_replace(',', '.', $dimensi);
                    $lebar   = 0;
                }

                $data['panjang'] = !empty(trim($panjang)) ? trim($panjang) : 0;
                $data['lebar']   = !empty(trim($lebar)) ? trim($lebar) : 0;

                $book = Book::create($data);
            }

            $exemplar = BookDetail::where('code', $row['barcode'])->first();

            if (!$exemplar) {
                $data = [
                    'book_id'     => $book->id,
                    'position'    => $row['posisi_rak_no_punggung'],
                    'price'       => $row['harga'],
                    'status_id'   => 1,
                    'code'        => $row['barcode'],
                ];

                if (key_exists($row['lokasi'], $this->location)) {
                    $data['location_id'] = $this->location[$row['lokasi']];
                }
                elseif ($row['lokasi'] != '') {
                    $location = Location::create([
                        'name' => $row['lokasi'],
                    ]);
                    $data['location_id'] = $location->id;
                    $this->location = Location::pluck('id', 'name')->toArray();
                }

                if (key_exists($row['status'], $this->source)) {
                    $data['source_id'] = $this->source[$row['status']];
                }
                elseif($row['status'] != '') {
                    $source = Source::create([
                        'name' => $row['status'],
                    ]);
                    $data['source_id'] = $source->id;
                    $this->source = Source::pluck('id', 'name')->toArray();
                }

                BookDetail::create($data);

            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
