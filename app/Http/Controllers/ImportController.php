<?php

namespace App\Http\Controllers;

use App\Events\Deleted;
use App\Events\Imported;
use App\Imports\ImportUser;
use App\Imports\UsersImport;
use App\Listeners\Noti;
use App\Models\Import;
use App\Models\LogImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Requests\ImportCsvFileRequest;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function index() {

        $customers = Import::paginate(10);
        return view('import')->with(compact('customers'));
    }

    public function import(ImportCsvFileRequest $request) {

        $file = $request->file('csv_file')->store('excel');
//        $log_imports = LogImport::all();
//        if (in_array(hash_file('md5', Storage::disk('local')->path($file)), $log_imports->toArray())){
//            dd('true');
//        }else {
//            dd('false');
//        }
//        dd(hash_file('md5', Storage::disk('local')->path($file)));
        $collection = (new FastExcel)->import(Storage::disk('local')->path($file), function ($customer) {
            return [
                'name' => $customer['First Name'] . $customer['Last Name'],
                'email' => $customer['Email'],
                'phone' => $customer['Phone'],
                'address' => $customer['Email'] . $customer['Phone'],
            ];
        });

        $customers = array_chunk($collection->toArray(),10000);
        foreach ($customers as $customer) {
            Import::insert($customer);
        }

        LogImport::insert([
            'key' => hash_file('md5', Storage::disk('local')->path($file))
        ]);
        // Storage::disk('local')->delete($file);
        $data = ['time' =>Carbon::now(),'action' => 'Imported', 'count' => $collection->count()];
        event(new Imported($data));
        return redirect()->back()->with('success', 'Import success!');
    }

    public function delete() {
        $count = Import::count();
        Import::truncate();
        $data = ['time' =>Carbon::now(),'action' => 'Deleted', 'count' => $count];
        event(new Deleted($data));
        return redirect()->back()->with('success', 'Delete success!');
    }
}
