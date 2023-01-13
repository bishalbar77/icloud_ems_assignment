<?php

namespace App\Imports;

use App\BulkImportData;
use App\Branch;
use App\FeeCategory;
use App\Module;
use App\FeeType;
use App\FeeCollectionType;
use App\EntryMode;
use App\FinancialTrans;
use App\CommonFeeCollection;
use App\CommonFeeCollectionHeadwise;
use App\FinancialTransDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeeDataImport implements ToCollection,ShouldQueue, WithChunkReading, WithStartRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            BulkImportData::create([
                'date'         => $row[1],
                'academic_year'           => $row[2],
                'session'      => $row[3],
                'alloted_category'          => $row[4],
                'voucher_type'          => $row[5],
                'voucher_no'          => $row[6],
                'roll_no'          => $row[7],
                'admno_unique_id'          => $row[8],
                'status'          => $row[9],
                'fee_category'          => $row[10],
                'faculty'          => $row[11],
                'program'          => $row[12],
                'department'          => $row[13],
                'batch'          => $row[14],
                'receipt_no'          => $row[15],
                'fee_head'          => $row[16],
                'due_amount'          => $row[17],
                'paid_amount'          => $row[18],
                'concession_amount'          => $row[19],
                'scholarship_amount'          => $row[20],
                'reverse_concession_amount'          => $row[21],
                'write_off_amount'          => $row[22],
                'adjusted_amount'          => $row[23],
                'refund_amount'          => $row[24],
                'fund_transfer_amount'          => $row[25],
                'remarks'          => isset($row[26]) ? $row[26] : null
            ]);

            $findBranch = Branch::where([
                'faculty'      => $row[11],
                'program'      => $row[12],
                'department'   => $row[13],
            ])->first();
            if(!$findBranch) {
                $findBranch = Branch::create([
                    'faculty'      => $row[11],
                    'program'      => $row[12],
                    'department'   => $row[13],
                ]);
            }
            $findFeeCategory = FeeCategory::where([
                'branch_id'      => $findBranch->id,
                'fee_category'          => $row[10],
            ])->first();
            if(!$findFeeCategory) {
                $findFeeCategory = FeeCategory::create([
                    'branch_id'      => $findBranch->id,
                    'fee_category'          => $row[10],
                ]);
            }
            if($row[16] == "Hostel & Mess Fee") {
                $collection_head = "Hostel";
                $module_id = 2;
            } elseif(strpos($row[16], "Fine") !== false) {
                $collection_head = "Academic Misc";
                $module_id = 11;
            } else {
                $collection_head = "Academic";
                $module_id = 1;
            }
            $findModule = Module::where([
                'module'    => $collection_head,
                'module_id'    => $module_id,
            ])->first();
            if(!$findModule) {
                $findModule = Module::create([
                    'module'    => $collection_head,
                    'module_id'    => $module_id,
                ]);
            }
            $findFeeCollectionType = FeeCollectionType::where([
                'branch_id'      => $findBranch->id,
                'collection_head'          => $collection_head,
                'collection_desc'          => $collection_head,
            ])->first();
            if(!$findFeeCollectionType) {
                $findFeeCollectionType = FeeCollectionType::create([
                    'branch_id'      => $findBranch->id,
                    'collection_head'          => $collection_head,
                    'collection_desc'          => $collection_head,
                ]);
            }
            $findFeeType = FeeType::where([
                'branch_id'      => $findBranch->id,
                'fee_head_type'          => $findModule->module_id,
                'fee_category_id'          => $findFeeCategory->id,
                'collection_id'          => $findFeeCollectionType->id,
                'f_name'          => $row[16],
                'fee_type_ledger'          => $row[16],
            ])->first();
            if(!$findFeeType) {
                $findFeeType = FeeType::create([
                    'branch_id'      => $findBranch->id,
                    'fee_head_type'          => $findModule->module_id,
                    'fee_category_id'          => $findFeeCategory->id,
                    'collection_id'          => $findFeeCollectionType->id,
                    'f_name'          => $row[16],
                    'fee_type_ledger'          => $row[16],
                ]);
            }
            $con = null;
            if($row[5] == "PMT") {
                $entry_mode_name = "PMT";
                $crdr = "C";
                $entrymodeno = 1;
            } elseif($row[5] == "REVDUE") {
                $entry_mode_name = "REVDUE";
                $crdr = "C";
                $entrymodeno = 12;
            } elseif($row[5] == "REVJV") {
                $entry_mode_name = "REVJV";
                $crdr = "C";
                $entrymodeno = 14;
            } elseif($row[5] == "SCHOLARSHIP") {
                $entry_mode_name = "SCHOLARSHIP";
                $crdr = "C";
                $entrymodeno = 15;
                $con = 2;
            } elseif($row[5] == "CONCESSION") {
                $entry_mode_name = "SCHOLARSHIP";
                $crdr = "C";
                $entrymodeno = 15;
                $con = 1;
            } elseif($row[5] == "REVSCHOLARSHIP") {
                $entry_mode_name = "REVSCHOLARSHIP";
                $crdr = "D";
                $entrymodeno = 16;
            } else {
                $entry_mode_name = "DUE";
                $crdr = "D";
                $entrymodeno = 0;
            }
            $findEntryMode = EntryMode::where([
                'entry_mode_name'    => $entry_mode_name,
                'crdr'    => $crdr,
                'entrymodeno'    => $entrymodeno,
            ])->first();
            if(!$findEntryMode) {
                $findEntryMode = EntryMode::create([
                    'entry_mode_name'    => $entry_mode_name,
                    'crdr'    => $crdr,
                    'entrymodeno'    => $entrymodeno,
                ]);
            }
            $findFinancialTrans = FinancialTrans::where([
                'admno'    => $row[8],
            ])->first();
            if(!$findFinancialTrans) {
                $findFinancialTrans = FinancialTrans::create([
                    'branch_id'    => $findBranch->id,
                    'module_id'          => $findModule->module_id,
                    'entry_mode'    => $entrymodeno,
                    'tranid'    => rand(10000000,999999999),
                    'admno'    => $row[8],
                    'amount'    => $row[18],
                    'crdr'    => $crdr,
                    'tranDate'    => $row[1],
                    'acadYear'    => $row[3],
                    'voucherno'    => $row[6],
                    'type_of_concession'    => $con,
                ]);
            } else {
                $findFinancialTrans->amount += $row[18];
                $findFinancialTrans->save();
            }
            $newFinancialTransDetail = FinancialTransDetail::create([
                'branch_id'    => $findBranch->id,
                'module_id'          => $findModule->module_id,
                'financial_trans_id'    => $findFinancialTrans->id,
                'headid'    => $findFeeType->id,
                'amount'    => $row[18],
                'crdr'    => $crdr,
                'head_name'    => $row[16],
            ]);
            if(isset($row[15]) && $row[15] != null) {
                $findCommonFeeCollection = CommonFeeCollection::where([
                    'receipt_id'    => $row[15],
                ])->first();
                if(!$findCommonFeeCollection) {
                    $findCommonFeeCollection = CommonFeeCollection::create([
                        'branch_id'    => $findBranch->id,
                        'module_id'          => $findModule->module_id,
                        'entry_mode'    => $entrymodeno,
                        'receipt_id'    => $row[15],
                        'transId'    => rand(10000000,999999999),
                        'admno'    => $row[8],
                        'rollno'    => $row[7],
                        'amount'    => $row[18],
                        'acadamicYear'    => $row[3],
                        'financialYear'    => $row[3],
                        'displayReceiptNo'    => $row[15],
                        'paid_date'    => $row[1],
                        'inactive'    => strpos($row[5], "REV") !== false ? 1 : 0,
                    ]);
                } else {
                    $findCommonFeeCollection->amount += $row[18];
                    $findCommonFeeCollection->save();
                }
                $newCommonFeeCollectionHeadwise = CommonFeeCollectionHeadwise::create([
                    'branch_id'    => $findBranch->id,
                    'module_id'          => $findModule->module_id,
                    'receiptId'    => $findCommonFeeCollection->receipt_id,
                    'headid'    => $findFeeType->id,
                    'amount'    => $row[18],
                    'head_name'    => $row[16],
                ]);
            }
        }
    }

    public function startRow(): int
    {
        return 7;
    }

    public function batchSize(): int
    {
        return 2800;
    }

    public function chunkSize(): int
    {
        return 2800;
    }
}
