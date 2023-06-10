<?php

namespace Database\Seeders;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        Customer::truncate();

        for ($i = 0; $i < 20; $i++) {
            list($state, $city) = $this->generateRandomStateAndCity();
            Customer::create([
                'cpf'         => $this->generateRandomCpf(),
                'name'        => $this->generateRandomName(),
                'birth_date'  => $this->generateRandomBirthDate(),
                'gender'      => $this->generateRandomGender(),
                'address'     => $this->generateRandomAddress(),
                'state'       => $state,
                'city'        => $city,
            ]);
        }
    }

    private function generateRandomCpf() {
        $digits = str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
        return substr($digits, 0, 3) . '.' . substr($digits, 3, 3) . '.' . substr($digits, 6, 3) . '-' . substr($digits, 9, 2);
    }

    private function generateRandomName() {
        $firstNames = ['Antônio', 'Maria', 'João', 'Ana', 'Pedro', 'Luiza', 'José', 'Marcos', 'Ricardo', 'Lucas', 'Julia', 'Cintia'];
        $lastNames = ['Silva', 'Santos', 'Oliveira', 'Pereira', 'Ferreira', 'Almeida', 'Souza', 'Lima', 'Martins', 'Gomes', 'Andrade', 'Costa'];
        $firstName = $firstNames[array_rand($firstNames)];
        $lastName = $lastNames[array_rand($lastNames)];
        return $firstName . ' ' . $lastName;
    }

    private function generateRandomBirthDate() {
        $start = Carbon::create(1950, 1, 1);
        $end = Carbon::now()->subYears(18);
        return Carbon::createFromTimestamp(mt_rand($start->timestamp, $end->timestamp))->format('Y-m-d');
    }

    private function generateRandomGender() {
        $genders = ['M', 'F'];
        return $genders[array_rand($genders)];
    }

    private function generateRandomAddress() {
        $streets = ['Rua A', 'Rua B', 'Rua C', 'Av. X', 'Av. Y', 'Av. Z', 'Travessa A', 'Travessa B', 'Travessa C', 'Alameda A', 'Alameda B', 'Alameda C'];
        $numbers = range(1, 1000);
        $street = $streets[array_rand($streets)];
        $number = $numbers[array_rand($numbers)];
        return $street . ', nº ' . $number;
    }

    private function generateRandomStateAndCity() {
        $statesAndCities = [
            'SP' => ['São Paulo', 'Santo André', 'São Bernardo do Campo', 'Guarulhos'],
            'RJ' => ['Rio de Janeiro', 'Niterói', 'Duque de Caxias', 'Nova Iguaçu'],
            'PR' => ['Curitiba', 'Londrina', 'Maringá'],
            'MG' => ['Belo Horizonte', 'Uberlândia', 'Contagem'],
            'RS' => ['Porto Alegre', 'Caxias do Sul', 'Pelotas'],
        ];

        $state = array_rand($statesAndCities);
        $city = $statesAndCities[$state][array_rand($statesAndCities[$state])];

        return [$state, $city];
    }
}
