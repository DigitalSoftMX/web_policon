<?php

namespace App\Imports;

use App\Web\ExcelSale;
use DateTime;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class SalesImport implements ToCollection
{
    private $station;
    public function __construct($station)
    {
        $this->station = $station;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                switch ($this->station->number_station) {
                    case 6532:
                        // Aldia Cholula
                        if (is_int($row[2])) {
                            if (is_int($row[7]) or is_double($row[7])) {
                                $phpdate = ($row[7] - 25569) * 86400;
                                $date = gmdate("Y-m-d H:i:s", $phpdate);
                            } else {
                                $date = new DateTime($row[4]);
                                $date = $date->format('Y-m-d H:i:s');
                                // $date = DateTime::createFromFormat('Y/m/d H:i:s', $row[7])->format('Y-m-d H:i:s');
                            }
                            $this->registerVanoeCholula($row, $date);
                        }
                        break;
                    case 13771:
                        // Vanoe
                        if (is_int($row[2])) {
                            if (is_int($row[7]) or is_double($row[7])) {
                                $phpdate = ($row[7] - 25569) * 86400;
                                $date = gmdate("Y-m-d H:i:s", $phpdate);
                            } else {
                                $date = new DateTime($row[4]);
                                $date = $date->format('Y-m-d H:i:s');
                                // $date = DateTime::createFromFormat('Y/m/d H:i:s', $row[7])->format('Y-m-d H:i:s');
                            }
                            $this->registerVanoeCholula($row, $date);
                        }
                        break;
                    case 5286:
                        // Animas
                        if (stristr($row[0], '0000000')) {
                            if (is_int($row[4]) or is_double($row[4])) {
                                $phpdate = ($row[4] - 25569) * 86400;
                                $date = gmdate("Y-m-d H:i:s", $phpdate);
                            } else {
                                $date = new DateTime($row[4]);
                                $date = $date->format('Y-m-d H:i:s');
                                // $date = DateTime::createFromFormat('Y/m/d H:i:s', $row[4])->format('Y-m-d H:i:s');
                            }
                            $this->registerAnimasDorada($row, $date);
                        }
                        break;
                    case 5391:
                        // Aldia Dorada
                        if (stristr($row[0], '0000000')) {
                            if (is_int($row[4]) or is_double($row[4])) {
                                $phpdate = ($row[4] - 25569) * 86400;
                                $date = gmdate("Y-m-d H:i:s", $phpdate);
                            } else {
                                $date = new DateTime($row[4]);
                                $date = $date->format('Y-m-d H:i:s');
                                // $date = DateTime::createFromFormat('Y/m/d H:i:s', $row[4])->format('Y-m-d H:i:s');
                            }
                            $this->registerAnimasDorada($row, $date);
                        }
                        break;
                }
            } catch (Exception $e) {
            }
        }
    }
    // Registrando informacion de la estacion Ánimas y Dorada
    private function registerAnimasDorada($row, $date)
    {
        if (!(ExcelSale::where([['station_id', $this->station->id], ['ticket', $row[0], ['date', $date]]])->exists())) {
            if ((float) $row[9] >= 500)
                ExcelSale::create([
                    'station_id' => $this->station->id,
                    'ticket' => $row[0],
                    'date' => $date,
                    'product' => strtoupper($row[6]),
                    'liters' => $row[7],
                    'payment' => $row[9],
                    'payment_type' => $row[11]
                ]);
        }
    }
    // Regitrando informacion de la estacion Vanoe
    private function registerVanoeCholula($row, $date)
    {
        if (!(ExcelSale::where([['station_id', $this->station->id], ['ticket', $row[2], ['date', $date]]])->exists())) {
            if ((float) $row[12] >= 500)
                ExcelSale::create([
                    'station_id' => $this->station->id,
                    'ticket' => $row[2],
                    'date' => $date,
                    'product' => strtoupper($row[9]),
                    'liters' => $row[10],
                    'payment' => $row[12],
                    'payment_type' => $row[14]
                ]);
        }
    }
}
