<?php

namespace App\Http\Controllers;

use App\Models\Avenant;
use App\Models\Contract;
use App\Models\Employee;
use Illuminate\View\View;
use App\Models\Advancement;
use Illuminate\Http\Request;
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
        $employeesQuery = Employee::query()->with('contract', 'advancement')->orderBy('created_at', 'desc');
        
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
            'echelonOptions' => [1 => 1, 2 => 2],
            'classOptions' => ['Stagiaire' => 'Stagiaire', 'Deuxieme' => 'Deuxieme', 'Premiere' => 'Premiere', 'Principale' => 'Principale', 'Exceptionnelle' => 'Exceptionnelle']
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

        $employee = Employee::create($data);
        $advancement = new Advancement([
            'class' => $data['class'],
            'echelon' => $data['echelon'],
            'indice' => $data['indice'],
            'category' => $data['category'],
        ]);


        //Convert date format from d-m-Y to Y-m-d ( format date taken by laravel)
        $startDate = date('Y-m-d', strtotime($data['startDate']));
        $endDate = date('Y-m-d', strtotime( $data['startDate']));

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
        $employee->advancement()->save($advancement);
        $advancement->refresh();
        $advancement->save();

        $employee->contract()->save($contract);
        $employee->refresh();
        $contract->save();

        $contract->avenant()->save($avenant);
        $contract->refresh();
        $contract->save();

        return to_route('editor.employee.index')->with("success", "L'employé a été bien enregistré");

    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //extracting avenant associated to the contract 
        $avenants = $employee->contract->avenant;
        foreach ($avenants as $avenant) {
            $associatedAvenant = new Avenant([
                'avenantNumber' => $avenant->avenantNumber,
                'date' => $avenant->date  
            ]);

        // dd($associatedAvenant->date);
        }
        
        return view('editor.create', [
            'employee' => $employee,
            'advancement' => $employee->advancement,
            'contract' => $employee->contract,
            'avenant' => $associatedAvenant,
            'contractOptions' => ['EFA' => 'EFA', 'ECD' => 'ECD', 'ELD' => 'ELD'],
            'echelonOptions' => [1 => 1, 2 => 2],
            'classOptions' => ['Stagiaire' => 'Stagiaire', 'Deuxieme' => 'Deuxieme', 'Premiere' => 'Premiere', 'Principale' => 'Principale', 'Exceptionnelle' => 'Exceptionnelle']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeFormRequest $request, Employee $employee, Contract $contract, Avenant $avenant)
    {
        $data = $this->extractProjectContractFilePath($contract, $avenant, $request);
        $employee->update($data);
        $employee->advancement->update($data);

        //Formatting date to adapt to date format in database
        // $dataToUpdate = $request->validated();
        // $dataToUpdate['startDate'] = date('Y-m-d', strtotime($request->validated('startDate')));
        // $dataToUpdate['endDate'] = date('Y-m-d', strtotime($request->validated('startDate')));
        // $dataToUpdate = date('Y-m-d', strtotime( $request->validated('date')));

        //Relationship to be updated
        // $employee->contract->update($request->validated());
        $employee->contract->update($data);

        optional($employee->contract->avenant[0])->update($data);

        return to_route('editor.employee.index')->with("success", "L'employé a été bien mis à jour");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->contract->avenant[0]->delete();
        $employee->delete();

        return to_route('editor.employee.index')->with('success', 'L\'employé a été bien supprimé');
    }
}
