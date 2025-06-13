<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fee;
use App\Models\FeeInvoice;
use App\Models\StudentReceipt;
use App\Models\ProcessingFee;
use App\Models\PaymentToStudent;
use App\Models\Discount;
use App\Models\StudentDiscount;
use App\Models\StudentAccount;
use App\Models\SchoolFund;
use App\Models\Student;
use App\Models\Year;
use App\Models\Processing_fees;
use App\Models\Fees;

use App\Models\Stage;
use App\Models\Classroom;

class FeeSeeder extends Seeder
{
    public function run()
    {


        // Create one fee per classroom
        $year = Year::where('is_active', true)->first();
        $classrooms = Classroom::all();
        foreach ($classrooms as $classroom) {
            Fee::create([
                'name' => "{$classroom->name} Annual Fee",
                'value' => 1000,
                'year_id' => $year->id,
                'stage_id' => $classroom->stage_id,
                'classroom_id' => $classroom->id,
            ]);
        }

        // Pick first 3 students to demo scenarios
        $students = Student::take(3)->get();

        foreach ($students as $student) {
            $fee = Fee::where('classroom_id', $student->classroom_id)->first();

            //
            // 1) Partial leave: invoice 1000, paid 500, processing_fee 500
            //
            $inv1 = FeeInvoice::create([
                'fee_id' => $fee->id,
                'student_id' => $student->id,
                'amount' => 1000,
            ]);
            $rec1 = StudentReceipt::create([
                'student_id' => $student->id,
                'amount_received' => 500,
                'receipt_date' => now(),
            ]);
            $proc = ProcessingFee::create([
                'student_id' => $student->id,
                'amount' => 500,
                'description' => 'Mid‐year pro-rata adjustment',
            ]);

            // Ledger: invoice debit, receipt credit, processing_fee credit
            StudentAccount::insert([
                [
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'debit' => 1000,
                    'credit' => null,
                    'description' => "Invoice #{$inv1->id}",
                    'fee_invoice_id' => $inv1->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'debit' => null,
                    'credit' => 500,
                    'description' => "Receipt #{$rec1->id}",
                    'student_receipt_id' => $rec1->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'debit' => null,
                    'credit' => 500,
                    'description' => 'Processing Fee',
                    'processing_fee_id' => $proc->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            SchoolFund::insert([
                [
                    'debit' => 1000,
                    'credit' => null,
                    'description' => "Invoice #{$inv1->id}",
                    'student_id' => $student->id,
                    'student_receipt_id' => null,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'debit' => null,
                    'credit' => 500,
                    'description' => "Receipt #{$rec1->id}",
                    'student_id' => $student->id,
                    'student_receipt_id' => $rec1->id,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'debit' => null,
                    'credit' => 500,
                    'description' => 'Processing Fee',
                    'student_id' => $student->id,
                    'student_receipt_id' => null,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);


            //
            // 2) Full leave: invoice 1000, paid 1000, refund 500
            //
            $inv2 = FeeInvoice::create([
                'fee_id' => $fee->id,
                'student_id' => $student->id,
                'amount' => 1000,
            ]);
            $rec2 = StudentReceipt::create([
                'student_id' => $student->id,
                'amount_received' => 1000,
                'receipt_date' => now(),
            ]);
            $pay2 = PaymentToStudent::create([
                'student_id' => $student->id,
                'amount' => 500,
                'description' => 'Mid‐year refund',
            ]);

            StudentAccount::insert([
                [
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'debit' => 1000,
                    'credit' => null,
                    'description' => "Invoice #{$inv2->id}",
                    'fee_invoice_id' => $inv2->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'debit' => null,
                    'credit' => 1000,
                    'description' => "Receipt #{$rec2->id}",
                    'student_receipt_id' => $rec2->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'debit' => null,
                    'credit' => 500,
                    'description' => "Refund #{$pay2->id}",
                    'payment_to_student_id' => $pay2->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            SchoolFund::insert([
                [
                    'debit' => 1000,
                    'credit' => null,
                    'description' => "Invoice #{$inv2->id}",
                    'student_id' => $student->id,
                    'student_receipt_id' => null,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'debit' => null,
                    'credit' => 500,
                    'description' => "Receipt #{$rec2->id}",
                    'student_id' => $student->id,
                    'student_receipt_id' => $rec2->id,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'debit' => null,
                    'credit' => 500,
                    'description' => 'Processing Fee',
                    'student_id' => $student->id,
                    'student_receipt_id' => null,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);


            //
            // 3) Discount: invoice 1000, 10% discount → 100
            //
            $disc = Discount::firstOrCreate(
                ['name' => '10% Early‐bird'],
                ['type' => 'percent', 'value' => 10]
            );
            $inv3 = FeeInvoice::create([
                'fee_id' => $fee->id,
                'student_id' => $student->id,
                'amount' => 1000,
            ]);
            $applied = intval(1000 * ($disc->value / 100));
            $stdDisc = StudentDiscount::create([
                'discount_id' => $disc->id,
                'student_id' => $student->id,
                'fee_invoice_id' => $inv3->id,
                'amount_applied' => $applied,
            ]);

            StudentAccount::insert([
                [
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'debit' => 1000,
                    'credit' => null,
                    'description' => "Invoice #{$inv3->id}",
                    'fee_invoice_id' => $inv3->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'debit' => null,
                    'credit' => $applied,
                    'description' => "Discount #{$stdDisc->id}",
                    'student_discount_id' => $stdDisc->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            SchoolFund::insert([
                [
                    'debit' => 1000,
                    'credit' => null,
                    'description' => "Invoice #{$inv3->id}",
                    'student_id' => $student->id,
                    'student_receipt_id' => null,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'debit' => null,
                    'credit' => $applied,
                    'description' => "Discount #{$stdDisc->id}",
                    'student_id' => $student->id,
                    'student_receipt_id' => null,
                    'payment_to_student_id' => null,
                    'salary_receipt_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

        }
    }
}