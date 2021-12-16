<?php

namespace App\Imports;

use App\Web\ExcelSale;
use App\Web\Period;
use DateTime;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class SalesImport implements ToCollection
{
    private $station, $period;
    public function __construct($station)
    {
        $this->station = $station;
        $this->period = Period::all()->last();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (stristr($row[0], '0000000')) {
                if (is_int($row[4]) or is_double($row[4])) {
                    $phpdate = ($row[4] - 25569) * 86400;
                    $date = gmdate("Y-m-d H:i:s", $phpdate);
                } else {
                    $date = new DateTime($row[4]);
                    $date = $date->format('Y-m-d H:i:s');
                }
                if ($this->period and !$this->period->finish) {
                    $saleBd = ExcelSale::where([['station_id', $this->station->id], ['ticket', $row[0], ['date', $date]]])->exists();
                    if (!$saleBd) {
                        $sale = ExcelSale::create([
                            'station_id' => $this->station->id, 'ticket' => $row[0],
                            'date' => $date, 'product' => strtoupper($row[6]),
                            'liters' => $row[7], 'payment' => $row[9],
                        ]);
                        if (
                            $sale->payment < 500 or $sale->product == 'DIESEL' or
                            $sale->date < $this->period->date_start or $sale->date > $this->period->date_end
                        )
                            $sale->delete();
                    }
                }
            }
        }
    }
}
