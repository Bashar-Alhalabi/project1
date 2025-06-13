<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryPayout;
use App\Models\SalaryAdjustment;
use App\Models\SalaryReceipt;
use App\Models\SalaryAccount;
use App\Models\SchoolFund;
use App\Models\Teacher;
use App\Models\Supervisor;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
class SalarySeeder extends Seeder
{
    public function run()
    {


        // Pick a few payees (teachers + supervisors)
        $teachers = Teacher::all()->pluck('id')->toArray();
        $supervisors = Supervisor::all()->pluck('id')->toArray();

        // Combine into a single list of [type, id]
        $payees = array_merge(
            array_map(fn($id) => ['type' => Teacher::class, 'id' => $id], $teachers),
            array_map(fn($id) => ['type' => Supervisor::class, 'id' => $id], $supervisors)
        );

        foreach ($payees as $idx => $payee) {
            // 1) Payout: pay salary for month
            $month = now()->startOfMonth()->subMonths($idx);
            $payout = SalaryPayout::create([
                'payee_type' => $payee['type'],
                'payee_id' => $payee['id'],
                'amount' => 2000 + $idx * 100,  // sample varying amounts
                'salary_month' => $month->toDateString(),
                'paid_on' => now(),
            ]);

            // 2) Adjustment: e.g. bonus for first, penalty for second
            $type = $idx % 2 === 0 ? 'bonus' : 'penalty';
            $adjust = SalaryAdjustment::create([
                'payee_type' => $payee['type'],
                'payee_id' => $payee['id'],
                'salary_payout_id' => $payout->id,
                'type' => $type,
                'amount' => 100,
                'reason' => ucfirst($type) . " adjustment",
            ]);

            // 3) Receipt: record the payout in school fund
            $receipt = SalaryReceipt::create([
                'payee_type' => $payee['type'],
                'payee_id' => $payee['id'],
                'salary_payout_id' => $payout->id,
                'amount' => $payout->amount,
                'paid_on' => now(),
            ]);

            // 4) Salary account ledger entries
            //    - Debit: payout amount
            //    - Credit: adjustment if penalty, or Debit for bonus?
            //      Here we treat bonus as credit to payee account.
            $baseEntry = [
                'debit' => $payout->amount,
                'credit' => null,
                'description' => "Salary Payout #{$payout->id}",
                'payee_type' => $payee['type'],
                'payee_id' => $payee['id'],
                'transactable_type' => SalaryPayout::class,
                'transactable_id' => $payout->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $adjustEntry = [
                'debit' => null,
                'credit' => $adjust->amount,
                'description' => ucfirst($adjust->type) . " #{$adjust->id}",
                'payee_type' => $payee['type'],
                'payee_id' => $payee['id'],
                'transactable_type' => SalaryAdjustment::class,
                'transactable_id' => $adjust->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            SalaryAccount::insert([
                // payout entry
                $baseEntry,
                // adjustment entry
                $adjustEntry,
            ]);

            // 5) School fund entry for the salary receipt
            SchoolFund::insert([
                [
                    'debit' => null,
                    'credit' => $receipt->amount,
                    'description' => "Salary Paid #{$receipt->id}",
                    'student_id' => null,
                    'student_receipt_id' => null,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => $receipt->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
