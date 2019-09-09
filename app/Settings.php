<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    public $timestamps = true;

    const PRODUCTS_RATES = 'PRODUITS_TAUX';

    const PRICES_CRITERIA = array(

        'samedi'=> [
            'val'=> 5,
            'title' => 'Samedi',
        ],

        'aujourdhui'=> [
            'val'=> 5,
            'title' => 'Aujourd\'hui',
        ],
        'dimanche'=> [
            'val'=> 6,
            'title' => 'Dimanche',
        ],
        'jour_an'=> [
            'val'=> 1,
            'title' => 'jour de l\'an',
        ],
        'fete_paque'=> [
            'val'=> 22,
            'title' => 'Fête de paques',
        ],
        'fete_travail'=> [
            'val'=> 1,
            'title' => 'Fête du Travail',
        ],
        'victoire_allie'=> [
            'val'=> 8,
            'title' => 'Victoire des alliés',
        ],
        'ascension'=> [
            'val'=> 30,
            'title' => 'L\'ascension',
        ],
        'pentecote'=> [
            'val'=> 10,
            'title' => 'Pentecôte',
        ],
        'fete_national'=> [
            'val'=> 14,
            'title' => 'Fête national',
        ],
        'assomption'=> [
            'val'=> 15,
            'title' => 'Assomption',
        ],
        'toussaint'=> [
            'val'=> 1,
            'title' => 'La Toussaint',
        ],
        'armistice'=> [
            'val'=> 11,
            'title' => 'Armistice',
        ],
        'fete_noel'=> [
            'val'=> 25,
            'title' => 'Fête de noël',
        ]);

    public static function getPriceRates()
    {
        $today = Carbon::today();
        $jj = $today->format('Y-m-d'); // aujourd'hui
        $saturday = $today->weekday(5)->format('Y-m-d'); // samedi
        $sunday = $today->weekday(6)->format('Y-m-d'); // dimanche
        $newYearDay = $today->day(1)->month(1)->format('Y-m-d'); // jour de l'an
        $easterDay = $today->day(22)->month(4)->format('Y-m-d'); // fetes de paques
        $laborDay = $today->day(1)->month(5)->format('Y-m-d');// Fête du Travail
        $victoryAlliesDay = $today->day(8)->month(5)->format('Y-m-d');// Victoire des alliés
        $ascentDay = $today->day(30)->month(5)->format('Y-m-d');// Jeudi de l'Ascension
        $pentecostDay = $today->day(10)->month(6)->format('Y-m-d');// Lundi de Pentecôte
        $nationalHoliday = $today->day(14)->month(7)->format('Y-m-d');// fetes national
        $assumptionDay = $today->day(15)->month(8)->format('Y-m-d');// Assomption
        $allSaintDay = $today->day(1)->month(11)->format('Y-m-d');// La Toussaint
        $armisticeDay = $today->day(11)->month(11)->format('Y-m-d');//  Armistice
        $ChristmasDay = $today->day(25)->month(12)->format('Y-m-d'); // jour de noel

        $taux = config("produits.taux", 1);

        if (\Setting::has(Settings::PRODUCTS_RATES)) {
            switch ($jj) {

                case $saturday:
                    $taux = \Setting::get('PRODUITS_TAUX.samedi');
                    break;
                case $sunday:
                    $taux = \Setting::get('PRODUITS_TAUX.dimanche');
                    break;
                case $newYearDay:
                    $taux = \Setting::get('PRODUITS_TAUX.jour_an');
                    break;
                case $easterDay:
                    $taux = \Setting::get('PRODUITS_TAUX.fete_paque');
                    break;
                case $laborDay:
                    $taux = \Setting::get('PRODUITS_TAUX.fete_travail');
                    break;
                case $victoryAlliesDay:
                    $taux = \Setting::get('PRODUITS_TAUX.victoire_allie');
                    break;
                case $ascentDay:
                    $taux = \Setting::get('PRODUITS_TAUX.ascension');
                    break;
                case $pentecostDay:
                    $taux = \Setting::get('PRODUITS_TAUX.pentecote');
                    break;
                case $nationalHoliday:
                    $taux = \Setting::get('PRODUITS_TAUX.fete_national');
                    break;
                case $assumptionDay:
                    $taux = \Setting::get('PRODUITS_TAUX.assomption');
                    break;
                case $allSaintDay:
                    $taux = \Setting::get('PRODUITS_TAUX.toussaint');
                    break;
                case $armisticeDay:
                    $taux = \Setting::get('PRODUITS_TAUX.armistice');
                    break;
                case $ChristmasDay:
                    $taux = \Setting::get('PRODUITS_TAUX.fete_noel');
                    break;
                default:
                    $taux = \Setting::get('PRODUITS_TAUX.aujourdhui');
                    break;
            }

        }

        return $taux;
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','key');
    }

}
