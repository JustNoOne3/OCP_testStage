<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Establishment;
use App\Models\Geocode;

class Certificate extends Component
{
    public static function qr_encrypt($value){
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "FkSeGoYe6KI8OAd";
        
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($value, $ciphering,
                    $encryption_key, $options, $encryption_iv);
        
        return $encryption;
    }
    
    public function mount(){

        if (!session()->has('est_id') || session()->get('est_id') <= 0) {
            abort(404);
        }
        // dd(session()->get('est_id'));
        $record = Establishment::query()->where('est_id', session()->get('est_id'))->first();
        // session()->put('est_id', 0); // uncomment to access cert when refreshed
        $this->est_reg = env('APP_URL') . 'verify' . '/' . Certificate::qr_encrypt($record->est_id);
        $this->est_name = strtoupper($record->est_name);

        $this->region = Geocode::query()->where('geo_id', $record->region_id)->value('geo_name');
        $this->province = Geocode::query()->where('geo_id', $record->province_id)->value('geo_name');
        $city = Geocode::query()->where('geo_id', $record->city_id)->value('geo_name');
        $barangay = Geocode::query()->where('geo_id', $record->barangay_id)->value('geo_name');
        $this->est_address = $record->est_street." "."Brgy. ".$barangay.","." ".$city.","." ".$this->province;
        $this->numWork = $record->est_numworkTotal;
        $this->regDate = $record->est_certIssuance;

        $dateParts = explode('-', $record->est_certIssuance);

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
    public function render()
    {
        return view('livewire.certificate');
    }
    
    public function homeDash()
    {
        return redirect('user');
    }
}
