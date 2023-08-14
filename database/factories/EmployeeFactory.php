<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        

        $gender = $this->faker->randomElement($array = array ('male','female'));
        if($gender == 'male')
            $g = 'L';
        else
            $g = 'P';

        return [
            'employee_id' => function(){
                $n_data = Employee::count();
                if($n_data == 0){
                    $id = 'E001';
                }else{
                    $last_id = Employee::max('employee_id');
                    $next_id = ((int)str_replace('E', '', $last_id))+1;
                    $id = 'E'.sprintf("%03s", $next_id);
                }
                return $id; 
            },
            'full_name' => $this->faker->name($gender),
            'job_id' => mt_rand(1,14),
            'hire_date' => $this->faker->dateTimeBetween('-4 years', '-1 years'),
            'gender' => $g,
            'date_of_birth' => $this->faker->dateTimeBetween('-40 years', '-25 years'),
            'email' => $this->faker->unique()->freeEmail(),
            'phone' => $this->faker->numerify('08##########'),
            'address' => $this->faker->streetAddress().' '.$this->faker->city(),
            'salary' => $this->faker->randomNumber(3, false)*10000,
        ];
    }
}
