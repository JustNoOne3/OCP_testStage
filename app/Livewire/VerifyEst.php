<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Establishment;
use App\Models\Geocode;

class VerifyEst extends Component
{
    public $record;
    public $rec_id;
    
    public static function qr_decrypt($value){
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = "FkSeGoYe6KI8OAd";
        
        // Use openssl_encrypt() function to encrypt the data
        $decryption=openssl_decrypt ($value, $ciphering, 
            $decryption_key, $options, $decryption_iv);
        
        return $decryption;
    }

    public function mount($record){
        $record_id = VerifyEst::qr_decrypt($record);
        $est_data = Establishment::query()->where('est_id', $record_id)->first();
        $this->rec_id = $est_data;

        if($this->rec_id){
            $this->est_reg = env('APP_URL') . 'verify' . '/' . Certificate::qr_encrypt($est_data->est_id);
            $this->est_name = strtoupper($est_data->est_name);

            $this->region = Geocode::query()->where('geo_id', $est_data->region_id)->value('geo_name');
            $this->province = Geocode::query()->where('geo_id', $est_data->province_id)->value('geo_name');
            $city = Geocode::query()->where('geo_id', $est_data->city_id)->value('geo_name');
            $barangay = Geocode::query()->where('geo_id', $est_data->barangay_id)->value('geo_name');
            $this->est_address = $est_data->est_street." "."Brgy. ".$barangay.","." ".$city.","." ".$this->province;
            $this->numWork = $est_data->est_numworkTotal;
            $this->regDate = $est_data->est_certIssuance;

            $dateParts = explode('-', $est_data->est_certIssuance);

            $this->year = $dateParts[0];
            $month = $dateParts[1];
            $this->day = $dateParts[2];

            switch ($month) {
                case '01':
                    $this->month = 'January';
                    break;
                case '02':
                    $this->month = 'February';
                    break;
                case '03':
                    $this->month = 'March';
                    break;
                case '04':
                    $this->month = 'April';
                    break;
                case '05':
                    $this->month = 'May';
                    break;
                case '06':
                    $this->month = 'June';
                    break;
                case '07':
                    $this->month = 'July';
                    break;
                case '08':
                    $this->month = 'August';
                    break;
                case '09':
                    $this->month = 'September';
                    break;
                case '10':
                    $this->month = 'October';
                    break;
                case '11':
                    $this->month = 'November';
                    break;
                case '12':
                    $this->month = 'December';
                    break;
                default:
                    $this->month = 'Invalid';
            }
        }
    }

    public function render()
    {
        if($this->rec_id){
            return view('livewire.verify-est');
        }else{
            return view('livewire.verify-failed');
        }
        
    }
}
