<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Avenant;
use App\Models\Contract;
use App\Models\Employee;
use Illuminate\View\View;
use App\Models\Advancement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SearchFormRequest;
use App\Http\Requests\EmployeeFormRequest;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Employee::class, 'employee');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchFormRequest $request)
    {
        $employeesQuery = Employee::query()->with('contracts', 'advancements')->orderBy('created_at', 'desc');

        //For lastname search
        if ($request->validated('lastName')){
            $employeesQuery = $employeesQuery->where('lastName', 'like', "%{$request->validated('lastName')}%");
        }

        //For IM search
        if ($request->validated('im')){
            $employeesQuery = $employeesQuery->where('im', '==', $request->validated('im'));
        }

        // dd($employeesQuery->paginate(2));

        return view('editor.index', [
            'employees' => $employeesQuery->paginate(15),
            'inputForSearch' => $request->validated(),
            'contractOptions' => ['EFA' => 'EFA', 'ECD' => 'ECD', 'ELD' => 'ELD']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employee = new Employee();
        $advancement = new Advancement();
        $contract = new Contract();
        $avenant = new Avenant();

        return view('editor.create', [
            'employee' => $employee,
            'advancement' => $advancement,
            'contract' => $contract,
            'avenant' => $avenant,
            'contractOptions' => ['EFA' => 'EFA', 'ECD' => 'ECD', 'ELD' => 'ELD'],
            'echelonOptions' => [1 => 1, 2 => 2, 3 => 3],
            'classOptions' => ['Stagiaire' => 'Stagiaire', 'Deuxieme' => 'Deuxieme', 'Premiere' => 'Premiere', 'Principale' => 'Principale', 'Exceptionnelle' => 'Exceptionnelle'],
            'genderOptions' => ['Homme' => 'Homme', 'Femme' => 'Femme']
        ]);
    }

    private function extractProjectContractFilePath(Contract $contract, Avenant $avenant, EmployeeFormRequest $request) : array
    {
        $data = $request->validated();
        $projectContractFilePath = $request->validated('projectContractFilePath');
        
        //if project contract file is null or with error then return $data directly
        //Not applicable for avenant because avenant can be null
        if ($projectContractFilePath === null || $projectContractFilePath->getError()){
            return $data;
        }

        //Delete the previous image if already exists
        if($contract->projectContractFilePath) 
        {
            Storage::disk('public')->delete($contract->projectContractFilePath);
        }

        if($avenant->avenantFilePath) {
            Storage::disk('public')->delete($avenant->avenantFilePath);
        }
        
        $data['projectContractFilePath'] = $projectContractFilePath->store('project_contract', 'public');
        $data['avenantFilePath'] = $projectContractFilePath->store('avenant', 'public');
        
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeFormRequest $request)
    {
        //Validation already done in the extractProjectPath method
        // $employee = Employee::create($this->extractProjectContractFilePath(new Contract(), $request));

        /**
         * Extract project contract file path
         * Extract avenant file path
         * Save both data in storage folder 'project_contract' and 'avenant'
         * 
         * NB: all validation processes are done in the extractProjectFilePath function()
        */
        $data = $this->extractProjectContractFilePath(new Contract(), new Avenant(), $request);

        //Add user_id in data to avoid default_id error when creating user
        $data['user_id'] = Auth::user()->id;
        $employee = Employee::create($data);
        $advancement = new Advancement([
            'class' => $data['class'],
            'echelon' => $data['echelon'],
            'indice' => $data['indice'],
            'category' => $data['category'],
        ]);


        //Convert date format from d-m-Y to Y-m-d ( format date taken by laravel)
        $startDate = date('Y-m-d', strtotime($data['startDate']));
        $endDate = date('Y-m-d', strtotime( $data['endDate']));

        $contract = new Contract([
            'contractNumber' => $data['contractNumber'],
            'contractType' => $data['contractType'],
            'startDate' => $startDate,
            'endDate' => $endDate,
            'projectContractFilePath' => $data['projectContractFilePath'] 
        ]);

        //Convert date format from d-m-Y to Y-m-d ( format date taken by laravel)
        $date = date('Y-m-d', strtotime($data['date']));
        $avenant = new Avenant([
            'avenantNumber' => $data['avenantNumber'],
            'avenantFilePath' => $data['avenantFilePath'],
            'date' => $date
        ]);


        $employee->save();
        $employee->advancements()->save($advancement);
        $advancement->refresh();
        $advancement->save();

        $employee->contracts()->save($contract);
        $employee->refresh();
        $contract->save();

        $contract->avenants()->save($avenant);
        $contract->refresh();
        $contract->save();

        return to_route('editor.employee.index')->with("success", "L'employé a été bien enregistré");

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //extracting avenant associated to the contract 
        if($employee->contracts[0]->avenants[0]) {
            $avenants = $employee->contracts[0]->avenants;
            foreach ($avenants as $avenant) {
                $associatedAvenant = new Avenant([
                    'avenantNumber' => $avenant->avenantNumber,
                    'date' => $avenant->date  
                ]);

            }
        } else {
                $associatedAvenant = new Avenant();
        }
        
        return view('editor.create', [
            'employee' => $employee,
            'advancement' => $employee->advancements[0],
            'contract' => $employee->contracts[0],
            'avenant' => $associatedAvenant,
            'contractOptions' => ['EFA' => 'EFA', 'ECD' => 'ECD', 'ELD' => 'ELD'],
            'echelonOptions' => [1 => 1, 2 => 2, 3 => 3],
            'classOptions' => ['Stagiaire' => 'Stagiaire', 'Deuxieme' => 'Deuxieme', 'Premiere' => 'Premiere', 'Principale' => 'Principale', 'Exceptionnelle' => 'Exceptionnelle'],
            'genderOptions' => ['Homme' => 'Homme', 'Femme' => 'Femme']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeFormRequest $request, Employee $employee, Contract $contract, Avenant $avenant)
    {
        $data = $this->extractProjectContractFilePath($contract, $avenant, $request);

        //Convert date format from d-m-Y to Y-m-d ( format date taken by laravel)
        $data['startDate'] = date('Y-m-d', strtotime($data['startDate']));
        $data['endDate'] = date('Y-m-d', strtotime($data['endDate']));
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        
        $employee->update($data);
        // dd($employee->contracts[0]->avenant[0]);
        $employee->advancements[0]->update($data);

        //Relationship to be updated
        // $employee->contract->update($request->validated());
        $employee->contracts[0]->update($data);

        if($employee->contracts[0]->avenant) {
            optional($employee->contracts[0]->avenant[0])->update($data);
        }

        return to_route('editor.employee.index')->with("success", "L'employé a été bien mis à jour");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->contracts[0]->avenants[0]->delete();
        $employee->delete();

        return to_route('editor.employee.index')->with('success', 'L\'employé a été bien supprimé');
    }

    public function listContracts(Contract $contract)
    {
        $histories = DB::table('model_histories')->where('model_id', '=', $contract->id)->get();
        return view('editor.contracts.list', ['histories' => $histories] );
    }

    public function print()
    {
        return view('editor.print');
    }

    public function printAll() 
    {
        $employees = Employee::with('contracts')->orderBy('created_at', 'desc')->get();
        return view('editor.print_all',['employees' => $employees]);
    }
}
