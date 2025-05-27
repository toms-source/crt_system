<?php

namespace Database\Seeders;

use App\Models\Inventories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Inventories::create([
            'description' => 'Annual Financial Report',
            'doc_date' => Carbon::parse('2025-01-15 10:00:00'),
            'quantity_code' => 'QTY123',
            'index_code' => 'IDX456',
            'status' => 'active',
            'retention_period' => 5,
            'disposal_date' => Carbon::parse('2030-01-15 10:00:00'),
            'office_origin' => 'Finance Department',
            'turn_over_date' => Carbon::parse('2025-02-01 14:00:00'),
            'prepared_by' => 'Jane Doe',
            'list_no' => 'L001',
            'series_no' => 'S001',
            'loc_code' => 'LOC789',
            'recieved_by' => 'John Smith',
            'recieve_date' => '2025-02-05',
            'approved_by' => 'Mary Johnson',
            'approved_date' => '2025-02-10'
        ]);
    }
}
