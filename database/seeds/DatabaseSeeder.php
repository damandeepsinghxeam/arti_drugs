<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
    */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(DocumentCategoriesTableSeeder::class);
        $this->call(DocumentsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(LeaveTypesTableSeeder::class);
        $this->call(PerksTableSeeder::class);
        $this->call(QualificationsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(SalaryCyclesTableSeeder::class);
        $this->call(ShiftsTableSeeder::class);
        $this->call(ProbationPeriodsTableSeeder::class);
        $this->call(SalaryStructuresTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(DesignationsTableSeeder::class);
        $this->call(SalaryEarningsTableSeeder::class);
        $this->call(SalaryDeductionsTableSeeder::class);
        $this->call(FirstUserSeeder::class);
        $this->call(LogsTableSeeder::class);
        
        /*******************Lead and Til**************************/
        $this->call(LeadSourceTableSeeder::class);
        $this->call(LeadIndustryTableSeeder::class);
        $this->call(LeadUnitTableSeeder::class);
        $this->call(LeadServicesTableSeeder::class);
        $this->call(FeeTypeSeeder::class);
        $this->call(ObligationTableSeeder::class);
        $this->call(VerticalTableSeeder::class);
        $this->call(PaymentTermsTableSeeder::class);
        $this->call(CostFactorMasterTableSeeder::class);
        $this->call(CostFactorTypeTableSeeder::class);
        /*******************Lead and Til**************************/
    }
}