<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuisineCountry;

class CuisineCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cuisines = [ 
            'Ainu', 'Albanian', 'Argentine', 'Andhra', 'American', 'Anglo-Indian', 'Arab', 'Armenian', 'Assyrian', 'Awadhi', 'Azerbaijani',
            'Balochi', 'Belarusian', 'Bangladeshi', 'Bengali', 'Berber', 'Brazilian', 'British', 'Buddhist', 'Bulgarian', 'Cajun', 'Cantonese',
            'Caribbean', 'Chechen', 'Chinese', 'Circassian', 'Crimean Tatar', 'Cypriot', 'Czech', 'Danish', 'Dutch', 'Egyptian',
            'English', 'Ethiopian', 'Eritrean', 'Estonian', 'French', 'Filipino', 'Georgian', 'German', 'Goan', 'Greek',
            'Gujarati', 'Hyderabad', 'Indian', 'Indonesian', 'Inuit', 'Irish', 'Italian', 'Jamaican', 'Japanese', 'Jewish',
            'Kazakh', 'Keralite', 'Korean', 'Kurdish', 'Laotian', 'Lebanese', 'Latvian', 'Lithuanian', 'Louisiana Creole', 'Maharashtrian',
            'Mangalorean', 'Malay', 'Mediterranean', 'Mennonite', 'Mexican', 'Mordovian', 'Mughal', 'Native American', 'Nepalese',
            'New Mexican', 'Odia', 'Parsi', 'Pashtun', 'Polish', 'Pakistani', 'Peranakan', 'Persian', 'Peruvian', 'Portuguese', 'Punjabi',
            'Québécois', 'Rajasthani', 'Romanian', 'Russian', 'Sami', 'Serbian', 'Sindhi', 'Slovak', 'Slovenian' , 'Somali', 'South Indian',
            'Soviet', 'Spanish', 'Sri Lankan', 'Taiwanese', 'Tatar', 'Texan', 'Thai', 'Turkish', 'Tamil', 'Udupi', 'Ukrainian', 'Vietnamese',
            'Yamal', 'Zambian', 'Zanzibari',
        ];

        foreach($cuisines as $cuisine) {
            CuisineCountry::create([
                'name' => $cuisine,
            ]);
        }
    }
}
