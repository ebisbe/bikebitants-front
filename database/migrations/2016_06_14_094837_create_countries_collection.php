<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCountriesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
        });

        DB::collection('countries')->insert($this->data);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('countries');
    }

    protected $data = [
        ['_id' => "AF", 'name' => 'Afghanistan', 'active' => 0],
        ['_id' => "AX", 'name' => 'Åland Islands', 'active' => 0],
        ['_id' => "AL", 'name' => 'Albania', 'active' => 0],
        ['_id' => "DZ", 'name' => 'Algeria', 'active' => 0],
        ['_id' => "AS", 'name' => 'American Samoa', 'active' => 0],
        ['_id' => "AD", 'name' => 'Andorra', 'active' => 0],
        ['_id' => "AO", 'name' => 'Angola', 'active' => 0],
        ['_id' => "AI", 'name' => 'Anguilla', 'active' => 0],
        ['_id' => "AQ", 'name' => 'Antarctica', 'active' => 0],
        ['_id' => "AG", 'name' => 'Antigua and Barbuda', 'active' => 0],
        ['_id' => "AR", 'name' => 'Argentina', 'active' => 0],
        ['_id' => "AM", 'name' => 'Armenia', 'active' => 0],
        ['_id' => "AW", 'name' => 'Aruba', 'active' => 0],
        ['_id' => "AU", 'name' => 'Australia', 'active' => 0],
        ['_id' => "AT", 'name' => 'Austria', 'active' => 0],
        ['_id' => "AZ", 'name' => 'Azerbaijan', 'active' => 0],
        ['_id' => "BS", 'name' => 'Bahamas', 'active' => 0],
        ['_id' => "BH", 'name' => 'Bahrain', 'active' => 0],
        ['_id' => "BD", 'name' => 'Bangladesh', 'active' => 0],
        ['_id' => "BB", 'name' => 'Barbados', 'active' => 0],
        ['_id' => "BY", 'name' => 'Belarus', 'active' => 0],
        ['_id' => "BE", 'name' => 'Belgium', 'active' => 0],
        ['_id' => "BZ", 'name' => 'Belize', 'active' => 0],
        ['_id' => "BJ", 'name' => 'Benin', 'active' => 0],
        ['_id' => "BM", 'name' => 'Bermuda', 'active' => 0],
        ['_id' => "BT", 'name' => 'Bhutan', 'active' => 0],
        ['_id' => "BO", 'name' => 'Bolivia, Plurinational State of', 'active' => 0],
        ['_id' => "BQ", 'name' => 'Bonaire, Sint Eustatius and Saba', 'active' => 0],
        ['_id' => "BA", 'name' => 'Bosnia and Herzegovina', 'active' => 0],
        ['_id' => "BW", 'name' => 'Botswana', 'active' => 0],
        ['_id' => "BV", 'name' => 'Bouvet Island', 'active' => 0],
        ['_id' => "BR", 'name' => 'Brazil', 'active' => 0],
        ['_id' => "IO", 'name' => 'British Indian Ocean Territory', 'active' => 0],
        ['_id' => "BN", 'name' => 'Brunei Darussalam', 'active' => 0],
        ['_id' => "BG", 'name' => 'Bulgaria', 'active' => 0],
        ['_id' => "BF", 'name' => 'Burkina Faso', 'active' => 0],
        ['_id' => "BI", 'name' => 'Burundi', 'active' => 0],
        ['_id' => "KH", 'name' => 'Cambodia', 'active' => 0],
        ['_id' => "CM", 'name' => 'Cameroon', 'active' => 0],
        ['_id' => "CA", 'name' => 'Canada', 'active' => 0],
        ['_id' => "CV", 'name' => 'Cape Verde', 'active' => 0],
        ['_id' => "KY", 'name' => 'Cayman Islands', 'active' => 0],
        ['_id' => "CF", 'name' => 'Central African Republic', 'active' => 0],
        ['_id' => "TD", 'name' => 'Chad', 'active' => 0],
        ['_id' => "CL", 'name' => 'Chile', 'active' => 0],
        ['_id' => "CN", 'name' => 'China', 'active' => 0],
        ['_id' => "CX", 'name' => 'Christmas Island', 'active' => 0],
        ['_id' => "CC", 'name' => 'Cocos (Keeling) Islands', 'active' => 0],
        ['_id' => "CO", 'name' => 'Colombia', 'active' => 0],
        ['_id' => "KM", 'name' => 'Comoros', 'active' => 0],
        ['_id' => "CG", 'name' => 'Congo', 'active' => 0],
        ['_id' => "CD", 'name' => 'Congo, the Democratic Republic of the', 'active' => 0],
        ['_id' => "CK", 'name' => 'Cook Islands', 'active' => 0],
        ['_id' => "CR", 'name' => 'Costa Rica', 'active' => 0],
        ['_id' => "CI", 'name' => 'Côte d\'Ivoire', 'active' => 0],
        ['_id' => "HR", 'name' => 'Croatia', 'active' => 0],
        ['_id' => "CU", 'name' => 'Cuba', 'active' => 0],
        ['_id' => "CW", 'name' => 'Curaçao', 'active' => 0],
        ['_id' => "CY", 'name' => 'Cyprus', 'active' => 0],
        ['_id' => "CZ", 'name' => 'Czech Republic', 'active' => 0],
        ['_id' => "DK", 'name' => 'Denmark', 'active' => 0],
        ['_id' => "DJ", 'name' => 'Djibouti', 'active' => 0],
        ['_id' => "DM", 'name' => 'Dominica', 'active' => 0],
        ['_id' => "DO", 'name' => 'Dominican Republic', 'active' => 0],
        ['_id' => "EC", 'name' => 'Ecuador', 'active' => 0],
        ['_id' => "EG", 'name' => 'Egypt', 'active' => 0],
        ['_id' => "SV", 'name' => 'El Salvador', 'active' => 0],
        ['_id' => "GQ", 'name' => 'Equatorial Guinea', 'active' => 0],
        ['_id' => "ER", 'name' => 'Eritrea', 'active' => 0],
        ['_id' => "EE", 'name' => 'Estonia', 'active' => 0],
        ['_id' => "ET", 'name' => 'Ethiopia', 'active' => 0],
        ['_id' => "FK", 'name' => 'Falkland Islands (Malvinas', 'active' => 0],
        ['_id' => "FO", 'name' => 'Faroe Islands', 'active' => 0],
        ['_id' => "FJ", 'name' => 'Fiji', 'active' => 0],
        ['_id' => "FI", 'name' => 'Finland', 'active' => 0],
        ['_id' => "FR", 'name' => 'France', 'active' => 0],
        ['_id' => "GF", 'name' => 'French Guiana', 'active' => 0],
        ['_id' => "PF", 'name' => 'French Polynesia', 'active' => 0],
        ['_id' => "TF", 'name' => 'French Southern Territories', 'active' => 0],
        ['_id' => "GA", 'name' => 'Gabon', 'active' => 0],
        ['_id' => "GM", 'name' => 'Gambia', 'active' => 0],
        ['_id' => "GE", 'name' => 'Georgia', 'active' => 0],
        ['_id' => "DE", 'name' => 'Germany', 'active' => 0],
        ['_id' => "GH", 'name' => 'Ghana', 'active' => 0],
        ['_id' => "GI", 'name' => 'Gibraltar', 'active' => 0],
        ['_id' => "GR", 'name' => 'Greece', 'active' => 0],
        ['_id' => "GL", 'name' => 'Greenland', 'active' => 0],
        ['_id' => "GD", 'name' => 'Grenada', 'active' => 0],
        ['_id' => "GP", 'name' => 'Guadeloupe', 'active' => 0],
        ['_id' => "GU", 'name' => 'Guam', 'active' => 0],
        ['_id' => "GT", 'name' => 'Guatemala', 'active' => 0],
        ['_id' => "GG", 'name' => 'Guernsey', 'active' => 0],
        ['_id' => "GN", 'name' => 'Guinea', 'active' => 0],
        ['_id' => "GW", 'name' => 'Guinea-Bissau', 'active' => 0],
        ['_id' => "GY", 'name' => 'Guyana', 'active' => 0],
        ['_id' => "HT", 'name' => 'Haiti', 'active' => 0],
        ['_id' => "HM", 'name' => 'Heard Island and McDonald Islands', 'active' => 0],
        ['_id' => "VA", 'name' => 'Holy See (Vatican City State', 'active' => 0],
        ['_id' => "HN", 'name' => 'Honduras', 'active' => 0],
        ['_id' => "HK", 'name' => 'Hong Kong', 'active' => 0],
        ['_id' => "HU", 'name' => 'Hungary', 'active' => 0],
        ['_id' => "IS", 'name' => 'Iceland', 'active' => 0],
        ['_id' => "IN", 'name' => 'India', 'active' => 0],
        ['_id' => "ID", 'name' => 'Indonesia', 'active' => 0],
        ['_id' => "IR", 'name' => 'Iran, Islamic Republic of', 'active' => 0],
        ['_id' => "IQ", 'name' => 'Iraq', 'active' => 0],
        ['_id' => "IE", 'name' => 'Ireland', 'active' => 0],
        ['_id' => "IM", 'name' => 'Isle of Man', 'active' => 0],
        ['_id' => "IL", 'name' => 'Israel', 'active' => 0],
        ['_id' => "IT", 'name' => 'Italy', 'active' => 0],
        ['_id' => "JM", 'name' => 'Jamaica', 'active' => 0],
        ['_id' => "JP", 'name' => 'Japan', 'active' => 0],
        ['_id' => "JE", 'name' => 'Jersey', 'active' => 0],
        ['_id' => "JO", 'name' => 'Jordan', 'active' => 0],
        ['_id' => "KZ", 'name' => 'Kazakhstan', 'active' => 0],
        ['_id' => "KE", 'name' => 'Kenya', 'active' => 0],
        ['_id' => "KI", 'name' => 'Kiribati', 'active' => 0],
        ['_id' => "KP", 'name' => 'Korea, Democratic People\'s Republic of</', 'active' => 0],
        ['_id' => "KR", 'name' => 'Korea, Republic of', 'active' => 0],
        ['_id' => "KW", 'name' => 'Kuwait', 'active' => 0],
        ['_id' => "KG", 'name' => 'Kyrgyzstan', 'active' => 0],
        ['_id' => "LA", 'name' => 'Lao People\'s Democratic Republic<', 'active' => 0],
        ['_id' => "LV", 'name' => 'Latvia', 'active' => 0],
        ['_id' => "LB", 'name' => 'Lebanon', 'active' => 0],
        ['_id' => "LS", 'name' => 'Lesotho', 'active' => 0],
        ['_id' => "LR", 'name' => 'Liberia', 'active' => 0],
        ['_id' => "LY", 'name' => 'Libya', 'active' => 0],
        ['_id' => "LI", 'name' => 'Liechtenstein', 'active' => 0],
        ['_id' => "LT", 'name' => 'Lithuania', 'active' => 0],
        ['_id' => "LU", 'name' => 'Luxembourg', 'active' => 0],
        ['_id' => "MO", 'name' => 'Macao', 'active' => 0],
        ['_id' => "MK", 'name' => 'Macedonia, the former Yugoslav Republic of', 'active' => 0],
        ['_id' => "MG", 'name' => 'Madagascar', 'active' => 0],
        ['_id' => "MW", 'name' => 'Malawi', 'active' => 0],
        ['_id' => "MY", 'name' => 'Malaysia', 'active' => 0],
        ['_id' => "MV", 'name' => 'Maldives', 'active' => 0],
        ['_id' => "ML", 'name' => 'Mali', 'active' => 0],
        ['_id' => "MT", 'name' => 'Malta', 'active' => 0],
        ['_id' => "MH", 'name' => 'Marshall Islands', 'active' => 0],
        ['_id' => "MQ", 'name' => 'Martinique', 'active' => 0],
        ['_id' => "MR", 'name' => 'Mauritania', 'active' => 0],
        ['_id' => "MU", 'name' => 'Mauritius', 'active' => 0],
        ['_id' => "YT", 'name' => 'Mayotte', 'active' => 0],
        ['_id' => "MX", 'name' => 'Mexico', 'active' => 0],
        ['_id' => "FM", 'name' => 'Micronesia, Federated States of', 'active' => 0],
        ['_id' => "MD", 'name' => 'Moldova, Republic of', 'active' => 0],
        ['_id' => "MC", 'name' => 'Monaco', 'active' => 0],
        ['_id' => "MN", 'name' => 'Mongolia', 'active' => 0],
        ['_id' => "ME", 'name' => 'Montenegro', 'active' => 0],
        ['_id' => "MS", 'name' => 'Montserrat', 'active' => 0],
        ['_id' => "MA", 'name' => 'Morocco', 'active' => 0],
        ['_id' => "MZ", 'name' => 'Mozambique', 'active' => 0],
        ['_id' => "MM", 'name' => 'Myanmar', 'active' => 0],
        ['_id' => "NA", 'name' => 'Namibia', 'active' => 0],
        ['_id' => "NR", 'name' => 'Nauru', 'active' => 0],
        ['_id' => "NP", 'name' => 'Nepal', 'active' => 0],
        ['_id' => "NL", 'name' => 'Netherlands', 'active' => 0],
        ['_id' => "NC", 'name' => 'New Caledonia', 'active' => 0],
        ['_id' => "NZ", 'name' => 'New Zealand', 'active' => 0],
        ['_id' => "NI", 'name' => 'Nicaragua', 'active' => 0],
        ['_id' => "NE", 'name' => 'Niger', 'active' => 0],
        ['_id' => "NG", 'name' => 'Nigeria', 'active' => 0],
        ['_id' => "NU", 'name' => 'Niue', 'active' => 0],
        ['_id' => "NF", 'name' => 'Norfolk Island', 'active' => 0],
        ['_id' => "MP", 'name' => 'Northern Mariana Islands', 'active' => 0],
        ['_id' => "NO", 'name' => 'Norway', 'active' => 0],
        ['_id' => "OM", 'name' => 'Oman', 'active' => 0],
        ['_id' => "PK", 'name' => 'Pakistan', 'active' => 0],
        ['_id' => "PW", 'name' => 'Palau', 'active' => 0],
        ['_id' => "PS", 'name' => 'Palestinian Territory, Occupied', 'active' => 0],
        ['_id' => "PA", 'name' => 'Panama', 'active' => 0],
        ['_id' => "PG", 'name' => 'Papua New Guinea', 'active' => 0],
        ['_id' => "PY", 'name' => 'Paraguay', 'active' => 0],
        ['_id' => "PE", 'name' => 'Peru', 'active' => 0],
        ['_id' => "PH", 'name' => 'Philippines', 'active' => 0],
        ['_id' => "PN", 'name' => 'Pitcairn', 'active' => 0],
        ['_id' => "PL", 'name' => 'Poland', 'active' => 0],
        ['_id' => "PT", 'name' => 'Portugal', 'active' => 0],
        ['_id' => "PR", 'name' => 'Puerto Rico', 'active' => 0],
        ['_id' => "QA", 'name' => 'Qatar', 'active' => 0],
        ['_id' => "RE", 'name' => 'Réunion', 'active' => 0],
        ['_id' => "RO", 'name' => 'Romania', 'active' => 0],
        ['_id' => "RU", 'name' => 'Russian Federation', 'active' => 0],
        ['_id' => "RW", 'name' => 'Rwanda', 'active' => 0],
        ['_id' => "BL", 'name' => 'Saint Barthélemy', 'active' => 0],
        ['_id' => "SH", 'name' => 'Saint Helena, Ascension and Tristan da Cunha', 'active' => 0],
        ['_id' => "KN", 'name' => 'Saint Kitts and Nevis', 'active' => 0],
        ['_id' => "LC", 'name' => 'Saint Lucia', 'active' => 0],
        ['_id' => "MF", 'name' => 'Saint Martin (French part', 'active' => 0],
        ['_id' => "PM", 'name' => 'Saint Pierre and Miquelon', 'active' => 0],
        ['_id' => "VC", 'name' => 'Saint Vincent and the Grenadines', 'active' => 0],
        ['_id' => "WS", 'name' => 'Samoa', 'active' => 0],
        ['_id' => "SM", 'name' => 'San Marino', 'active' => 0],
        ['_id' => "ST", 'name' => 'Sao Tome and Principe', 'active' => 0],
        ['_id' => "SA", 'name' => 'Saudi Arabia', 'active' => 0],
        ['_id' => "SN", 'name' => 'Senegal', 'active' => 0],
        ['_id' => "RS", 'name' => 'Serbia', 'active' => 0],
        ['_id' => "SC", 'name' => 'Seychelles', 'active' => 0],
        ['_id' => "SL", 'name' => 'Sierra Leone', 'active' => 0],
        ['_id' => "SG", 'name' => 'Singapore', 'active' => 0],
        ['_id' => "SX", 'name' => 'Sint Maarten (Dutch part', 'active' => 0],
        ['_id' => "SK", 'name' => 'Slovakia', 'active' => 0],
        ['_id' => "SI", 'name' => 'Slovenia', 'active' => 0],
        ['_id' => "SB", 'name' => 'Solomon Islands', 'active' => 0],
        ['_id' => "SO", 'name' => 'Somalia', 'active' => 0],
        ['_id' => "ZA", 'name' => 'South Africa', 'active' => 0],
        ['_id' => "GS", 'name' => 'South Georgia and the South Sandwich Islands', 'active' => 0],
        ['_id' => "SS", 'name' => 'South Sudan', 'active' => 0],
        ['_id' => "ES", 'name' => 'Spain', 'active' => 1],
        ['_id' => "LK", 'name' => 'Sri Lanka', 'active' => 0],
        ['_id' => "SD", 'name' => 'Sudan', 'active' => 0],
        ['_id' => "SR", 'name' => 'Suriname', 'active' => 0],
        ['_id' => "SJ", 'name' => 'Svalbard and Jan Mayen', 'active' => 0],
        ['_id' => "SZ", 'name' => 'Swaziland', 'active' => 0],
        ['_id' => "SE", 'name' => 'Sweden', 'active' => 0],
        ['_id' => "CH", 'name' => 'Switzerland', 'active' => 0],
        ['_id' => "SY", 'name' => 'Syrian Arab Republic', 'active' => 0],
        ['_id' => "TW", 'name' => 'Taiwan, Province of China', 'active' => 0],
        ['_id' => "TJ", 'name' => 'Tajikistan', 'active' => 0],
        ['_id' => "TZ", 'name' => 'Tanzania, United Republic of', 'active' => 0],
        ['_id' => "TH", 'name' => 'Thailand', 'active' => 0],
        ['_id' => "TL", 'name' => 'Timor-Leste', 'active' => 0],
        ['_id' => "TG", 'name' => 'Togo', 'active' => 0],
        ['_id' => "TK", 'name' => 'Tokelau', 'active' => 0],
        ['_id' => "TO", 'name' => 'Tonga', 'active' => 0],
        ['_id' => "TT", 'name' => 'Trinidad and Tobago', 'active' => 0],
        ['_id' => "TN", 'name' => 'Tunisia', 'active' => 0],
        ['_id' => "TR", 'name' => 'Turkey', 'active' => 0],
        ['_id' => "TM", 'name' => 'Turkmenistan', 'active' => 0],
        ['_id' => "TC", 'name' => 'Turks and Caicos Islands', 'active' => 0],
        ['_id' => "TV", 'name' => 'Tuvalu', 'active' => 0],
        ['_id' => "UG", 'name' => 'Uganda', 'active' => 0],
        ['_id' => "UA", 'name' => 'Ukraine', 'active' => 0],
        ['_id' => "AE", 'name' => 'United Arab Emirates', 'active' => 0],
        ['_id' => "GB", 'name' => 'United Kingdom', 'active' => 0],
        ['_id' => "US", 'name' => 'United States', 'active' => 0],
        ['_id' => "UM", 'name' => 'United States Minor Outlying Islands', 'active' => 0],
        ['_id' => "UY", 'name' => 'Uruguay', 'active' => 0],
        ['_id' => "UZ", 'name' => 'Uzbekistan', 'active' => 0],
        ['_id' => "VU", 'name' => 'Vanuatu', 'active' => 0],
        ['_id' => "VE", 'name' => 'Venezuela, Bolivarian Republic of', 'active' => 0],
        ['_id' => "VN", 'name' => 'Viet Nam', 'active' => 0],
        ['_id' => "VG", 'name' => 'Virgin Islands, British', 'active' => 0],
        ['_id' => "VI", 'name' => 'Virgin Islands, U.S', 'active' => 0],
        ['_id' => "WF", 'name' => 'Wallis and Futuna', 'active' => 0],
        ['_id' => "EH", 'name' => 'Western Sahara', 'active' => 0],
        ['_id' => "YE", 'name' => 'Yemen', 'active' => 0],
        ['_id' => "ZM", 'name' => 'Zambia', 'active' => 0],
        ['_id' => "ZW", 'name' => 'Zimbabwe', 'active' => 0],
    ];
}