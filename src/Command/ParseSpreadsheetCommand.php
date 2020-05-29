<?php


namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ParseSpreadsheetCommand extends Command
{
    protected static $defaultName = 'covid:parse-spreadsheet';

    const RAW_DATA_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=1668664387&single=true&output=csv';
    const DEATH_RECOVERED_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=47720805&single=true&output=csv';
    const DATA_BY_REGION_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=771389376&single=true&output=csv';
    const DATA_SOURCES_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=144952910&single=true&output=csv';
    const DAILY_BY_STATE_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=1141696962&single=true&output=csv';
    const TESTS_BY_STATE_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=435219370&single=true&output=csv';
    const CASES_TIME_SERIES_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=1634950520&single=true&output=csv';
    const ICMR_DATA_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=1767946274&single=true&output=csv';
    const BANNER_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=593757113&single=true&output=csv';
    const FAQ_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=236693978&single=true&output=csv';
    const TRAVEL_HISTORY_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=1154769427&single=true&output=csv';
    const STATE_CODES_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=64535442&single=true&output=csv';
    const RESOURCES_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=2136283984&single=true&output=csv';
    const NOTIFICATION_SHEET = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQD01UVxJ0NB9LGp0yrY42Kz___dovoEdmr3zI09WXkOIks6WCq6BiQmjN9On34E1vDQrLbPx0DFpX4/pub?gid=542252044&single=true&output=csv';

    const OTHERS = [
        self::TRAVEL_HISTORY_SHEET,
        self::STATE_CODES_SHEET,
        self::DEATH_RECOVERED_SHEET,
    ];


    const DATA_SETS = [
        [
            'output_file' => 'data.json',
            'title' => 'Main data set',
            'set' => [
                'tested' => self::ICMR_DATA_SHEET,
                'cases_time_series' => self::CASES_TIME_SERIES_SHEET,
                'statewise' => self::DATA_BY_REGION_SHEET,
            ]
        ],
        [
            'output_file' => 'raw_data.json',
            'title' => 'Raw data set',
            'set' => [
                'raw_data' => self::RAW_DATA_SHEET,
            ]
        ],
        [
            'output_file' => 'sources_list.json',
            'title' => 'Sources data set',
            'set' => [
                'sources_list' => self::DATA_SOURCES_SHEET,
            ]
        ],
        [
            'output_file' => 'state_test_data.json',
            'title' => 'State test data',
            'set' => [
                'states_tested_data' => self::TESTS_BY_STATE_SHEET,
            ]
        ],
        [
            'output_file' => 'states_daily.json',
            'title' => 'Daily states data',
            'set' => [
                'states_daily' => self::DAILY_BY_STATE_SHEET,
            ]
        ],
        [
            'output_file' => 'website_data.json',
            'title' => 'Website data',
            'set' => [
                'factoids' => self::BANNER_SHEET,
                'faq' => self::FAQ_SHEET,
            ]
        ],
        [
            'output_file' => 'resources/resources.json',
            'title' => 'Resources data',
            'set' => [
                'resources' => self::RESOURCES_SHEET,
            ]
        ],
        [
            'output_file' => 'updatelog/log.json',
            'title' => 'Notification data',
            'set' => [
                'logs' => self::NOTIFICATION_SHEET,
            ]
        ],
    ];

    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        foreach (self::DATA_SETS as $data_set) {
            print "{$data_set['title']}\n";
            $this->process($data_set['output_file'], $data_set['set'], in_array('logs', array_keys($data_set['set'])));
        }

        print "Data by district\n";
        $this->aggregate_by_state_and_district('state_district_wise.json');
        print "Data by location map\n";
        $this->data_for_map_visualization('data_for_map.json');

        return 0;
    }

    private function process($output_file, $data_set, $flat = false)
    {
        $data = [];
        foreach ($data_set as $key => $source_url) {
            $remote_data = $this->get_parse_csv($source_url);
            if (!$flat) {
                $data[$key] = $remote_data;
            } else {

                $data = array_map(function ($row) {
                    $timestamp = strtotime(str_replace("/", "-", $row['timestamp']));
                    $row['timestamp'] = $timestamp;
                    return $row;
                }, $remote_data);
            }
        }
        file_put_contents($this->path . "/public/api/{$output_file}",
            json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }

    private function data_for_map_visualization($output_file)
    {

        $all_data = file_get_contents($this->path . "/public/api/data.json");
        $all_data = json_decode($all_data, true);
        $all_data_by_state = $this->group_by('state', $all_data['statewise']);
        $total = current($all_data_by_state['Total']);
        $tested = current($all_data['tested']);
        $total = [
            'tested' => intval($tested['totalindividualstested']),
            'confirmed' => intval($total['confirmed']),
            'recovered' => intval($total['recovered']),
            'deaths' => intval($total['deaths']),
            'active' => intval($total['active']),
            "lastUpdatedTime" => date('F d Y h:iA', strtotime(str_replace("/", "-", $total['lastupdatedtime']))),
            "deltaConfirmed" => intval($total['deltaconfirmed']),
            "deltaRecovered" => intval($total['deltarecovered']),
            "deltaDeaths" => intval($total['deltadeaths']),
            "nolongerInEt" => intval($total['nolongerinet']),
        ];

        $state_data = file_get_contents($this->path . "/public/api/states_daily.json");
        $state_data = json_decode($state_data, true);
        $state_by_date = $this->group_by('date', $state_data['states_daily']);

        $data = [];
        foreach ($state_by_date as $date => $records) {
            $timestamp = strtotime($date);
            $regional = [];
            $states = [
                'aa' => 'Addis Abeba',
                'af' => 'Afar',
                'am' => 'Amhara',
                'bg' => 'Beneshangul Gumuz',
                'dd' => 'Dire Dawa',
                'ga' => 'Gambela',
                'hr' => 'Hareri',
                'or' => 'Oromia',
                'so' => 'Somali',
                'sn' => 'SNNP',
                'tg' => 'Tigray',
            ];
            foreach ($states as $state_code => $state_name) {
                $location_data = [];
                $location_data['loc'] = $state_name;
                $location_data['confirmedCases'] = 0;
                $location_data['discharged'] = 0;
                $location_data['deaths'] = 0;
                $add = false;
                foreach ($records as $record) {
                    if (empty(intval($record[$state_code]))) {
                        continue;
                    }

                    if ($record['status'] === 'Confirmed') {
                        $location_data['confirmedCases'] += intval($record[$state_code]);
                        $add = true;
                    }
                    if ($record['status'] === 'Recovered') {
                        $location_data['discharged'] += intval($record[$state_code]);
                        $add = true;
                    }
                    if ($record['status'] === 'Deceased') {
                        $location_data['deaths'] += intval($record[$state_code]);
                        $add = true;
                    }
                }
                if ($add) {
                    $regional[] = $location_data;
                }
            }


            $data[] = [
                "day" => date("Y-m-d", $timestamp),
                'regional' => $regional
            ];

        }


        file_put_contents($this->path . "/public/api/{$output_file}",
            json_encode([
                'success' => true,
                'data' => $data,
                'total' => $total
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

    }

    private function aggregate_by_state_and_district($output_file)
    {
        $data = file_get_contents($this->path . "/public/api/raw_data.json");
        $raw_data = json_decode($data, true);
        $by_state_data = $this->group_by('detectedstate', $raw_data['raw_data']);

        $result = [];

        foreach ($by_state_data as $state_name => $s_records) {
            $by_district_data = $this->group_by('detecteddistrict', $s_records);
            foreach ($by_district_data as $district_name => $d_records) {
                foreach ($d_records as $d_record) {
                    if (!isset($result[$state_name]['districtData'][$district_name]['lastupdatedtime'])) {
                        $result[$state_name]['districtData'][$district_name]['lastupdatedtime'] = "";
                    }

                    if (!isset($result[$state_name]['districtData'][$district_name]['confirmed'])) {
                        $result[$state_name]['districtData'][$district_name]['confirmed'] = 0;
                    }
                    $result[$state_name]['districtData'][$district_name]['confirmed']++;

                    if (!isset($result[$state_name]['districtData'][$district_name]['delta']['confirmed'])) {
                        $result[$state_name]['districtData'][$district_name]['delta']['confirmed'] = 0;
                    }
                    if (date('d-m-Y', strtotime($d_record['dateannounced'])) == date('d-m-Y', strtotime("now"))) {
                        $result[$state_name]['districtData'][$district_name]['delta']['confirmed']++;
                    }
                }
            }
        }

        file_put_contents($this->path . "/public/api/{$output_file}",
            json_encode($result, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }

    /**
     * Extracts the csv from a raw file
     *
     * @param $file_url
     *
     * @return array
     */
    private function get_parse_csv($file_url)
    {
        $csv = explode("\n", file_get_contents($file_url));
        $index = str_getcsv(array_shift($csv));
        $json_data_keys = array_map(function ($inx) {
            return strtolower(preg_replace('/\s+/', '', $inx));
        }, $index);

        $data = array_map(function ($e) use ($json_data_keys) {
            $line = str_getcsv($e);
            if (count(array_unique($line)) > 1) {
                return array_combine($json_data_keys, $line);
            }
            return false;
        }, $csv);

        return array_values(array_filter($data));


    }

    /**
     * Function that groups an array of associative arrays by some key.
     *
     * @param {String} $key Property to sort by.
     * @param {Array} $data Array that stores multiple associative arrays.
     *
     * @return array
     */
    private function group_by($key, $data)
    {

        $result = [];

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;

    }
}
